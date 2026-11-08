<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * All file uploads pass through here. Type is decided from the file's real content, never
 * from the name or the browser's claim, and stored names are always random.
 */
class Media_manager {

	const IMAGE_TYPES = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif');
	const RESUME_TYPES = array(
		'application/pdf' => array('pdf'),
		'application/msword' => array('doc'),
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => array('docx'),
		'application/zip' => array('docx'),
		'application/x-ole-storage' => array('doc'),
		'application/cdfv2' => array('doc'),
	);

	const WEBP_QUALITY = 82;
	const IMAGE_MAX_WIDTH = 2000;
	const IMAGE_COPY_WIDTHS = array(1200, 800, 420);

	private $CI;
	public $error = '';

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->load('girzock', FALSE, TRUE);
	}

	/**
	 * Checks an entry of $_FILES and returns the detected MIME type, or FALSE with $error set.
	 */
	private function inspect(array $file)
	{
		if ( ! isset($file['error']) OR is_array($file['error']))
		{
			$this->error = 'Invalid upload.';
			return FALSE;
		}
		if ($file['error'] !== UPLOAD_ERR_OK)
		{
			$this->error = in_array($file['error'], array(UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE), TRUE) ? 'The file is larger than the upload limit.' : 'The upload did not complete.';
			return FALSE;
		}
		if ( ! is_uploaded_file($file['tmp_name']))
		{
			$this->error = 'Invalid upload.';
			return FALSE;
		}
		if ($file['size'] > $this->CI->config->item('gz_upload_max_bytes'))
		{
			$this->error = 'The file must be 5 MB or smaller.';
			return FALSE;
		}
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		return strtolower((string) $finfo->file($file['tmp_name']));
	}

	/**
	 * Stores an uploaded image under assets/uploads/YYYY/MM as optimised WebP, with smaller
	 * copies for responsive display, and records it in the media library. If conversion fails
	 * nothing is stored and $error explains why, so a saved path is always a real WebP file.
	 * @return array|FALSE media_library row data including file_path
	 */
	public function store_image(array $file, $uploaded_by = NULL, $alt_text = NULL)
	{
		$mime = $this->inspect($file);
		if ($mime === FALSE)
		{
			return FALSE;
		}
		$extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
		$allowed_ext = array('jpg', 'jpeg', 'png', 'webp', 'gif');
		if ( ! isset(self::IMAGE_TYPES[$mime]) OR ! in_array($extension, $allowed_ext, TRUE))
		{
			$this->error = 'Please upload a JPG, PNG, WebP or GIF image.';
			return FALSE;
		}
		$info = @getimagesize($file['tmp_name']);
		if ( ! $info OR $info[0] < 1 OR $info[1] < 1 OR $info[0] > 8000 OR $info[1] > 8000 OR $info['mime'] !== $mime)
		{
			$this->error = 'That file is not a usable image.';
			return FALSE;
		}
		if ($this->is_animated($file['tmp_name'], $mime))
		{
			$this->error = 'Animated images cannot be converted to WebP here. Please upload a still image.';
			return FALSE;
		}
		$engine = $this->webp_engine();
		if ( ! $engine)
		{
			log_message('error', 'Media: neither Imagick nor GD can write WebP on this server.');
			$this->error = 'This server cannot create WebP images. It needs Imagick or GD with WebP support, so the image was not saved.';
			return FALSE;
		}
		if ( ! $this->enough_memory($info[0], $info[1]))
		{
			$this->error = 'That image has too many pixels for the server to process. Please upload a smaller one.';
			return FALSE;
		}

		$folder = 'assets/uploads/'.date('Y/m');
		$absolute = FCPATH.$folder;
		if ( ! is_dir($absolute) && ! @mkdir($absolute, 0755, TRUE))
		{
			log_message('error', 'Media: cannot create upload folder '.$absolute);
			$this->error = 'The upload folder is not writable.';
			return FALSE;
		}

		$name = bin2hex(random_bytes(16));
		$target = $folder.'/'.$name.'.webp';
		try
		{
			$size = $engine === 'imagick'
				? $this->encode_with_imagick($file['tmp_name'], FCPATH.$target)
				: $this->encode_with_gd($file['tmp_name'], $mime, FCPATH.$target);
		}
		catch (Throwable $e)
		{
			log_message('error', 'Media: conversion failed: '.$e->getMessage());
			$size = FALSE;
		}
		if ( ! $size OR ! $this->is_webp(FCPATH.$target))
		{
			$this->delete_files($target);
			$this->error = 'The image could not be converted to WebP, so it was not saved. Please try another file.';
			return FALSE;
		}

		$row = array(
			'file_name' => $name.'.webp',
			'original_name' => mb_substr(basename((string) $file['name']), 0, 255),
			'file_path' => $target,
			'mime_type' => 'image/webp',
			'file_size' => filesize(FCPATH.$target),
			'width' => $size[0],
			'height' => $size[1],
			'alt_text' => $alt_text,
			'uploaded_by' => $uploaded_by,
		);
		if ( ! $this->CI->db->insert('media_library', $row))
		{
			$this->delete_files($target);
			$this->error = 'The file could not be saved.';
			return FALSE;
		}
		$row['id'] = $this->CI->db->insert_id();
		return $row;
	}

	/**
	 * Stores a WebP, PNG or JPG image byte for byte, for artwork whose quality must not change.
	 * The real type is read from the content, the name is random and the extension comes from
	 * that type, so a disguised file cannot be stored. The uploads folder never runs scripts.
	 * @return array|FALSE media_library row data including file_path
	 */
	public function store_original_image(array $file, $uploaded_by, $min_side, $max_side)
	{
		$mime = $this->inspect($file);
		if ($mime === FALSE)
		{
			return FALSE;
		}
		$types = array('image/webp' => array('webp', array('webp')), 'image/png' => array('png', array('png')), 'image/jpeg' => array('jpg', array('jpg', 'jpeg')));
		$extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
		if ( ! isset($types[$mime]) OR ! in_array($extension, $types[$mime][1], TRUE))
		{
			$this->error = 'Please upload a WebP, PNG or JPG image.';
			return FALSE;
		}
		$info = @getimagesize($file['tmp_name']);
		if ( ! $info OR $info['mime'] !== $mime)
		{
			$this->error = 'That file is not a usable image.';
			return FALSE;
		}
		if ($info[0] < $min_side OR $info[1] < $min_side OR $info[0] > $max_side OR $info[1] > $max_side)
		{
			$this->error = 'The image must be '.$min_side.' to '.$max_side.' pixels on each side. This one is '.$info[0].' x '.$info[1].'.';
			return FALSE;
		}
		if ($this->is_animated($file['tmp_name'], $mime))
		{
			$this->error = 'Please upload a still image.';
			return FALSE;
		}
		$folder = 'assets/uploads/'.date('Y/m');
		if ( ! is_dir(FCPATH.$folder) && ! @mkdir(FCPATH.$folder, 0755, TRUE))
		{
			log_message('error', 'Media: cannot create upload folder '.$folder);
			$this->error = 'The upload folder is not writable.';
			return FALSE;
		}
		$name = bin2hex(random_bytes(16)).'.'.$types[$mime][0];
		$target = $folder.'/'.$name;
		if ( ! move_uploaded_file($file['tmp_name'], FCPATH.$target))
		{
			$this->error = 'The file could not be saved.';
			return FALSE;
		}
		@chmod(FCPATH.$target, 0644);
		$row = array('file_name' => $name, 'original_name' => mb_substr(basename((string) $file['name']), 0, 255), 'file_path' => $target, 'mime_type' => $mime, 'file_size' => filesize(FCPATH.$target), 'width' => $info[0], 'height' => $info[1], 'alt_text' => NULL, 'uploaded_by' => $uploaded_by);
		if ( ! $this->CI->db->insert('media_library', $row))
		{
			$this->delete_files($target);
			$this->error = 'The file could not be saved.';
			return FALSE;
		}
		$row['id'] = $this->CI->db->insert_id();
		return $row;
	}

	/** Removes a stored upload and its responsive copies. */
	public function delete_files($path)
	{
		$path = (string) $path;
		if (strpos($path, 'assets/uploads/') !== 0 OR strpos($path, '..') !== FALSE)
		{
			return;
		}
		@unlink(FCPATH.$path);
		if (substr($path, -5) === '.webp')
		{
			foreach ((array) glob(FCPATH.substr($path, 0, -5).'-*w.webp') as $copy)
			{
				@unlink($copy);
			}
		}
	}

	/** @return string|NULL which library can write WebP here; Imagick is preferred */
	private function webp_engine()
	{
		if (extension_loaded('imagick') && class_exists('Imagick') && in_array('WEBP', Imagick::queryFormats('WEBP'), TRUE))
		{
			return 'imagick';
		}
		return function_exists('imagewebp') ? 'gd' : NULL;
	}

	private function is_animated($path, $mime)
	{
		if ($mime !== 'image/gif' && $mime !== 'image/webp')
		{
			return FALSE;
		}
		$bytes = (string) @file_get_contents($path);
		if ($mime === 'image/webp')
		{
			return strpos(substr($bytes, 0, 256), 'ANIM') !== FALSE OR strpos($bytes, 'ANMF') !== FALSE;
		}
		return preg_match_all('/\x21\xF9\x04.{4}\x00[\x2C\x21]/s', $bytes) > 1;
	}

	private function enough_memory($width, $height)
	{
		$limit = trim((string) ini_get('memory_limit'));
		if ($limit === '' OR $limit === '-1')
		{
			return TRUE;
		}
		$units = array('G' => 1073741824, 'M' => 1048576, 'K' => 1024);
		$unit = strtoupper(substr($limit, -1));
		$bytes = (int) $limit * (isset($units[$unit]) ? $units[$unit] : 1);
		return memory_get_usage(TRUE) + $width * $height * 5 * 2 < $bytes;
	}

	private function is_webp($path)
	{
		$info = is_file($path) && filesize($path) > 0 ? @getimagesize($path) : FALSE;
		return $info && $info['mime'] === 'image/webp';
	}

	/** Width a stored image should have, and the smaller copies worth making for it. */
	private function plan_widths($width)
	{
		$full = min($width, self::IMAGE_MAX_WIDTH);
		$copies = array();
		foreach (self::IMAGE_COPY_WIDTHS as $copy)
		{
			if ($copy < $full)
			{
				$copies[] = $copy;
			}
		}
		return array($full, $copies);
	}

	/** @return array|FALSE final width and height */
	private function encode_with_gd($source, $mime, $destination)
	{
		$loaders = array('image/jpeg' => 'imagecreatefromjpeg', 'image/png' => 'imagecreatefrompng', 'image/gif' => 'imagecreatefromgif', 'image/webp' => 'imagecreatefromwebp');
		if ( ! function_exists($loaders[$mime]))
		{
			return FALSE;
		}
		$image = @call_user_func($loaders[$mime], $source);
		if ( ! $image)
		{
			return FALSE;
		}
		imagepalettetotruecolor($image);
		imagealphablending($image, FALSE);
		imagesavealpha($image, TRUE);
		if ($mime === 'image/jpeg' && function_exists('exif_read_data'))
		{
			$exif = @exif_read_data($source);
			$turn = array(3 => 180, 6 => -90, 8 => 90);
			if ( ! empty($exif['Orientation']) && isset($turn[$exif['Orientation']]))
			{
				$rotated = imagerotate($image, $turn[$exif['Orientation']], 0);
				if ($rotated)
				{
					imagedestroy($image);
					$image = $rotated;
				}
			}
		}
		list($full, $copies) = $this->plan_widths(imagesx($image));
		$base = substr($destination, 0, -5);
		$result = FALSE;
		$sizes = array($full => $destination);
		foreach ($copies as $copy)
		{
			$sizes[$copy] = $base.'-'.$copy.'w.webp';
		}
		foreach ($sizes as $width => $path)
		{
			$scaled = $width === imagesx($image) ? $image : imagescale($image, $width, -1, IMG_BICUBIC);
			if ( ! $scaled)
			{
				imagedestroy($image);
				return FALSE;
			}
			imagealphablending($scaled, FALSE);
			imagesavealpha($scaled, TRUE);
			$written = imagewebp($scaled, $path, self::WEBP_QUALITY);
			if ($path === $destination)
			{
				$result = array(imagesx($scaled), imagesy($scaled));
			}
			if ($scaled !== $image)
			{
				imagedestroy($scaled);
			}
			if ( ! $written)
			{
				imagedestroy($image);
				return FALSE;
			}
		}
		imagedestroy($image);
		return $result;
	}

	/** @return array|FALSE final width and height */
	private function encode_with_imagick($source, $destination)
	{
		$image = new Imagick($source);
		$image->autoOrient();
		$image->stripImage();
		$image->setImageFormat('webp');
		$image->setImageCompressionQuality(self::WEBP_QUALITY);
		list($full, $copies) = $this->plan_widths($image->getImageWidth());
		$base = substr($destination, 0, -5);
		$sizes = array($full => $destination);
		foreach ($copies as $copy)
		{
			$sizes[$copy] = $base.'-'.$copy.'w.webp';
		}
		$result = FALSE;
		foreach ($sizes as $width => $path)
		{
			$scaled = clone $image;
			if ($width !== $image->getImageWidth())
			{
				$scaled->resizeImage($width, 0, Imagick::FILTER_LANCZOS, 1);
			}
			if ( ! $scaled->writeImage($path))
			{
				return FALSE;
			}
			if ($path === $destination)
			{
				$result = array($scaled->getImageWidth(), $scaled->getImageHeight());
			}
			$scaled->clear();
		}
		$image->clear();
		return $result;
	}

	/**
	 * Stores a resume in the private folder outside the web root. It can only be reached
	 * through the permission-checked admin download.
	 * @return array|FALSE path, original_name, mime
	 */
	public function store_resume(array $file)
	{
		$mime = $this->inspect($file);
		if ($mime === FALSE)
		{
			return FALSE;
		}
		$extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
		if ( ! isset(self::RESUME_TYPES[$mime]) OR ! in_array($extension, self::RESUME_TYPES[$mime], TRUE))
		{
			$this->error = 'Please upload your resume as a PDF, DOC or DOCX file.';
			return FALSE;
		}
		$folder = GIRZOCK_PRIVATE_DIR.'/resumes';
		if ( ! is_dir($folder) && ! @mkdir($folder, 0750, TRUE))
		{
			log_message('error', 'Media: cannot create resume folder');
			$this->error = 'Your resume could not be saved. Please try again later.';
			return FALSE;
		}
		$name = bin2hex(random_bytes(16)).'.'.$extension;
		if ( ! move_uploaded_file($file['tmp_name'], $folder.'/'.$name))
		{
			$this->error = 'Your resume could not be saved. Please try again later.';
			return FALSE;
		}
		return array('path' => $name, 'original_name' => mb_substr(preg_replace('/[^\w.\- ]+/u', '_', basename((string) $file['name'])), 0, 255), 'mime' => $mime);
	}

	/** Absolute path of a stored resume. Only bare random filenames are accepted. */
	public function resume_path($stored_name)
	{
		if ( ! preg_match('/^[a-f0-9]{32}\.(pdf|docx?)$/', (string) $stored_name))
		{
			return NULL;
		}
		$path = GIRZOCK_PRIVATE_DIR.'/resumes/'.$stored_name;
		return is_file($path) ? $path : NULL;
	}

	/**
	 * Deletes a stored resume. Only a bare random filename inside the private resumes folder is accepted, and the
	 * resolved path is checked again, so nothing outside that folder can ever be removed. Returns TRUE if deleted.
	 */
	public function delete_resume($stored_name)
	{
		$path = $this->resume_path($stored_name);
		if ( ! $path)
		{
			return FALSE;
		}
		$folder = realpath(GIRZOCK_PRIVATE_DIR.'/resumes');
		$real = realpath($path);
		if ( ! $folder OR ! $real OR dirname($real) !== $folder)
		{
			log_message('error', 'Media: refused to delete a resume outside the resumes folder');
			return FALSE;
		}
		return @unlink($real);
	}
}

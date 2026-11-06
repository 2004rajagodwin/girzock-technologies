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
	 * Stores an uploaded image under assets/uploads/YYYY/MM and records it in the media library.
	 * JPEG and PNG files are converted to WebP when the server supports it.
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
		if ( ! $info OR $info[0] < 1 OR $info[0] > 8000 OR $info[1] > 8000)
		{
			$this->error = 'That file is not a usable image.';
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
		$final_mime = $mime;
		$width = $info[0];
		$height = $info[1];
		$saved = FALSE;
		$converted = $this->convert_to_webp($file['tmp_name'], $mime, $absolute.'/'.$name.'.webp');
		if ($converted)
		{
			$target = $name.'.webp';
			$final_mime = 'image/webp';
			$saved = TRUE;
			$size = filesize($absolute.'/'.$target);
			$width = $converted[0];
			$height = $converted[1];
		}
		else
		{
			$target = $name.'.'.self::IMAGE_TYPES[$mime];
			$saved = move_uploaded_file($file['tmp_name'], $absolute.'/'.$target);
			$size = $saved ? filesize($absolute.'/'.$target) : 0;
		}
		if ( ! $saved)
		{
			$this->error = 'The file could not be saved.';
			return FALSE;
		}

		$row = array(
			'file_name' => $target,
			'original_name' => mb_substr(basename((string) $file['name']), 0, 255),
			'file_path' => $folder.'/'.$target,
			'mime_type' => $final_mime,
			'file_size' => $size,
			'width' => $width,
			'height' => $height,
			'alt_text' => $alt_text,
			'uploaded_by' => $uploaded_by,
		);
		$this->CI->db->insert('media_library', $row);
		$row['id'] = $this->CI->db->insert_id();
		return $row;
	}

	/** @return array|FALSE final width and height */
	private function convert_to_webp($source, $mime, $destination)
	{
		if ( ! function_exists('imagewebp') OR ! in_array($mime, array('image/jpeg', 'image/png'), TRUE))
		{
			return FALSE;
		}
		$image = $mime === 'image/png' ? @imagecreatefrompng($source) : @imagecreatefromjpeg($source);
		if ( ! $image)
		{
			return FALSE;
		}
		$width = imagesx($image);
		$height = imagesy($image);
		if ($width > 2000)
		{
			$scaled = imagescale($image, 2000);
			if ($scaled)
			{
				imagedestroy($image);
				$image = $scaled;
				$width = imagesx($image);
				$height = imagesy($image);
			}
		}
		imagepalettetotruecolor($image);
		imagealphablending($image, TRUE);
		imagesavealpha($image, TRUE);
		$ok = imagewebp($image, $destination, 82);
		imagedestroy($image);
		return $ok ? array($width, $height) : FALSE;
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
}

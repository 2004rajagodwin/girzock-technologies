<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Admin_Controller {

	protected $module = 'media';

	/** Columns that may reference a media file, checked before a delete. */
	const REFERENCES = array(
		'services' => array('image', 'detail_image', 'icon', 'menu_image', 'home_core_image', 'home_overview_image', 'description'),
		'products' => array('image', 'description'),
		'portfolio_projects' => array('image', 'gallery', 'description'),
		'case_studies' => array('image', 'gallery'),
		'blog_posts' => array('featured_image', 'content'),
		'seo_metadata' => array('og_image'),
		'website_settings' => array('setting_value'),
		'career_openings' => array('description'),
	);

	private function list_query($q)
	{
		$this->db->where('deleted_at IS NULL', NULL, FALSE);
		if ($q !== '')
		{
			$this->db->group_start()->like('original_name', $q)->or_like('alt_text', $q)->group_end();
		}
	}

	public function index()
	{
		$q = mb_substr(trim((string) $this->input->get('q')), 0, 100);
		$per_page = 24;
		$page = $this->page_number();
		$this->list_query($q);
		$total = (int) $this->db->count_all_results('media_library');
		$this->list_query($q);
		$rows = $this->db->order_by('created_at', 'DESC')->order_by('id', 'DESC')->get('media_library', $per_page, ($page - 1) * $per_page)->result_array();
		$this->render('admin/media/index', array(
			'page_title' => 'Media Library', 'rows' => $rows, 'q' => $q, 'total' => $total,
			'pagination' => $this->pagination($total, $per_page, $page),
			'can_create' => $this->auth->can('media', 'create'),
			'can_edit' => $this->auth->can('media', 'edit'),
			'can_delete' => $this->auth->can('media', 'delete'),
		));
	}

	/** JSON list for the image picker in forms and the editor. */
	public function picker()
	{
		$q = mb_substr(trim((string) $this->input->get('q')), 0, 100);
		$this->list_query($q);
		$rows = $this->db->select('file_path, original_name, alt_text')->order_by('created_at', 'DESC')->get('media_library', 60)->result_array();
		$items = array();
		// Social image fields also offer the brand images kept at the site root (only those that exist)
		if ($this->input->get('brand') === '1')
		{
			foreach (brand_root_images() as $path)
			{
				if (valid_social_image_path($path) && ($q === '' OR stripos($path, $q) !== FALSE))
				{
					$items[] = array('path' => $path, 'url' => media_url($path), 'name' => $path.' (brand image)', 'alt' => '');
				}
			}
		}
		foreach ($rows as $row)
		{
			$items[] = array('path' => $row['file_path'], 'url' => media_url($row['file_path']), 'name' => $row['original_name'], 'alt' => (string) $row['alt_text']);
		}
		$this->json(array('items' => $items));
	}

	public function upload()
	{
		$this->require_post();
		$this->require_can('create');
		$this->load->library('media_manager');
		$files = isset($_FILES['files']) ? $_FILES['files'] : array();
		$stored = 0;
		$problems = array();
		if ( ! empty($files['name']) && is_array($files['name']))
		{
			foreach ($files['name'] as $i => $name)
			{
				if ($files['error'][$i] === UPLOAD_ERR_NO_FILE)
				{
					continue;
				}
				$file = array('name' => $name, 'type' => $files['type'][$i], 'tmp_name' => $files['tmp_name'][$i], 'error' => $files['error'][$i], 'size' => $files['size'][$i]);
				if ($this->media_manager->store_image($file, $this->user['id']))
				{
					$stored++;
				}
				else
				{
					$problems[] = $name.': '.$this->media_manager->error;
				}
			}
		}
		if ($stored)
		{
			$this->log_action('upload', NULL, $stored.' file(s) uploaded');
			$this->flash_success($stored.' file(s) uploaded.');
		}
		if ($problems)
		{
			$this->flash_error(implode(' ', $problems));
		}
		elseif ( ! $stored)
		{
			$this->flash_error('Choose at least one image.');
		}
		redirect('admin/media');
	}

	public function update($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$alt = mb_substr(trim((string) $this->input->post('alt_text')), 0, 255);
		$this->db->where('id', (int) $id)->update('media_library', array('alt_text' => $alt === '' ? NULL : $alt));
		$this->json(array('ok' => TRUE));
	}

	public function delete($id = 0)
	{
		$this->require_post();
		$this->require_can('delete');
		$row = $this->db->where('deleted_at IS NULL', NULL, FALSE)->get_where('media_library', array('id' => (int) $id), 1)->row_array();
		if ( ! $row)
		{
			show_404();
		}
		foreach (self::REFERENCES as $table => $columns)
		{
			$this->db->group_start();
			foreach ($columns as $column)
			{
				$this->db->or_like($column, $row['file_path']);
			}
			$this->db->group_end();
			if ($this->db->count_all_results($table) > 0)
			{
				$this->flash_error('This file is still used by the website, so it was not deleted.');
				redirect('admin/media');
			}
		}
		$this->db->where('id', $row['id'])->update('media_library', array('deleted_at' => date('Y-m-d H:i:s')));
		if (is_safe_asset_path($row['file_path']) && strpos($row['file_path'], 'assets/uploads/') === 0)
		{
			$this->load->library('media_manager');
			$this->media_manager->delete_files($row['file_path']);
		}
		$this->log_action('delete', $row['id'], $row['original_name']);
		$this->flash_success('File deleted.');
		redirect('admin/media');
	}
}

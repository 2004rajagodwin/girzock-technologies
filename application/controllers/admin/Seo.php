<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seo extends Admin_Controller {

	protected $module = 'seo';

	const PAGES = array('home' => 'Homepage', 'about' => 'About', 'services' => 'Services', 'products' => 'Products', 'portfolio' => 'Portfolio', 'case-studies' => 'Case Studies', 'blog' => 'Blog', 'careers' => 'Careers', 'contact' => 'Contact', 'areas-we-serve' => 'Areas We Serve');

	public function index()
	{
		$pages = array();
		foreach (self::PAGES as $key => $label)
		{
			$pages[$key] = array('label' => $label, 'seo' => $this->settings_model->seo('page', $key));
		}
		$types = array(
			array('Services', 'services', 'service', 'services'),
			array('Products', 'products', 'product', 'products'),
			array('Portfolio', 'portfolio_projects', 'portfolio', 'portfolio'),
			array('Case Studies', 'case_studies', 'case_study', 'case-studies'),
			array('Blog', 'blog_posts', 'blog', 'blog'),
			array('Careers', 'career_openings', 'career', 'careers'),
		);
		$content = array();
		foreach ($types as $type)
		{
			$rows = $this->db->select($type[1].'.id, '.$type[1].'.title, '.$type[1].'.slug, seo_metadata.meta_title, seo_metadata.meta_description')
				->join('seo_metadata', "seo_metadata.entity_type = ".$this->db->escape($type[2])." AND seo_metadata.entity_key = ".$type[1].".id", 'left', FALSE)
				->where($type[1].'.deleted_at IS NULL', NULL, FALSE)->order_by($type[1].'.title', 'ASC')->get($type[1])->result_array();
			$content[] = array('label' => $type[0], 'route' => $type[3], 'rows' => $rows);
		}
		$this->render('admin/seo/index', array(
			'page_title' => 'SEO Management',
			'pages' => $pages,
			'content' => $content,
			'redirects' => $this->db->order_by('id', 'DESC')->get('url_redirects', 100)->result_array(),
			'can_edit' => $this->auth->can('seo', 'edit'),
		));
	}

	public function page($key = '')
	{
		if ( ! isset(self::PAGES[$key]))
		{
			show_404();
		}
		$this->require_can('edit');
		$error = NULL;
		$seo = $this->settings_model->seo('page', $key);
		if ($this->input->method() === 'post')
		{
			$seo = array(
				'meta_title' => trim((string) $this->input->post('meta_title')),
				'meta_description' => trim((string) $this->input->post('meta_description')),
				'focus_keyword' => trim((string) $this->input->post('focus_keyword')),
				'og_title' => trim((string) $this->input->post('og_title')),
				'og_description' => trim((string) $this->input->post('og_description')),
				'canonical_url' => trim((string) $this->input->post('canonical_url')),
				'og_image' => trim((string) $this->input->post('og_image')),
				'robots' => trim((string) $this->input->post('robots')),
			);
			if (mb_strlen($seo['meta_title']) > 255 OR mb_strlen($seo['meta_description']) > 500 OR mb_strlen($seo['focus_keyword']) > 120 OR mb_strlen($seo['og_title']) > 255 OR mb_strlen($seo['og_description']) > 500)
			{
				$error = 'The title or description is too long.';
			}
			elseif ($seo['canonical_url'] !== '' && ! is_safe_http_url($seo['canonical_url']))
			{
				$error = 'The canonical URL must be a full URL.';
			}
			elseif ($seo['og_image'] !== '' && ! is_safe_asset_path($seo['og_image']))
			{
				$error = 'Choose the social image from the media library.';
			}
			elseif ( ! in_array($seo['robots'], array('', 'index, follow', 'noindex, follow', 'noindex, nofollow'), TRUE))
			{
				$error = 'Choose a robots value from the list.';
			}
			if ($error === NULL)
			{
				$this->settings_model->save_seo('page', $key, $seo);
				$this->log_action('update', NULL, 'SEO for page '.$key);
				$this->flash_success('SEO settings saved.');
				redirect('admin/seo');
			}
		}
		$this->render('admin/seo/page', array('page_title' => 'SEO: '.self::PAGES[$key], 'key' => $key, 'seo' => $seo, 'error' => $error));
	}

	public function redirect_save()
	{
		$this->require_post();
		$this->require_can('edit');
		$old = trim(parse_url((string) $this->input->post('old_path'), PHP_URL_PATH), '/');
		$new = trim(parse_url((string) $this->input->post('new_path'), PHP_URL_PATH), '/');
		$code = (int) $this->input->post('status_code') === 410 ? 410 : 301;
		$valid_path = function ($path) { return (bool) preg_match('#^[A-Za-z0-9/_.\-]+$#', $path) && strpos($path, '..') === FALSE; };
		if ( ! $valid_path($old) OR ($code === 301 && ! $valid_path($new)))
		{
			$this->flash_error('Enter site-relative paths, such as old-page or blog/old-post.');
		}
		else
		{
			$this->settings_model->add_redirect($old, $code === 301 ? $new : NULL, $code);
			$this->log_action('save', NULL, 'Redirect '.$old);
			$this->flash_success('Redirect saved.');
		}
		redirect('admin/seo#redirects');
	}

	public function redirect_delete($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$this->db->where('id', (int) $id)->delete('url_redirects');
		$this->flash_success('Redirect removed.');
		redirect('admin/seo#redirects');
	}
}

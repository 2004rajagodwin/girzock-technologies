<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seo extends Admin_Controller {

	protected $module = 'seo';

	const PAGES = array('home' => 'Homepage', 'about' => 'About', 'services' => 'Services', 'products' => 'Products', 'portfolio' => 'Portfolio', 'case-studies' => 'Case Studies', 'blog' => 'Blog', 'careers' => 'Careers', 'contact' => 'Contact', 'areas-we-serve' => 'Areas We Serve', 'privacy-policy' => 'Privacy Policy', 'terms' => 'Terms and Conditions', 'cookie-policy' => 'Cookie Policy');

	public function index()
	{
		$pages = array();
		foreach (self::PAGES as $key => $label)
		{
			$seo = $this->settings_model->seo('page', $key);
			$pages[$key] = array('label' => $label, 'seo' => $seo, 'live' => $this->live_url($key === 'home' ? '' : $key, $seo), 'noindex' => isset($seo['robots']) && stripos((string) $seo['robots'], 'noindex') === 0);
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
			$rows = $this->db->select($type[1].'.id, '.$type[1].'.title, '.$type[1].'.slug, '.$type[1].'.status, seo_metadata.meta_title, seo_metadata.meta_description, seo_metadata.robots, seo_metadata.canonical_url'.($type[1] === 'case_studies' ? ', case_studies.card_label, case_studies.status_label' : ''))
				->join('seo_metadata', "seo_metadata.entity_type = ".$this->db->escape($type[2])." AND seo_metadata.entity_key = ".$type[1].".id", 'left', FALSE)
				->where($type[1].'.deleted_at IS NULL', NULL, FALSE)->order_by($type[1].'.title', 'ASC')->get($type[1])->result_array();
			foreach ($rows as &$row)
			{
				$row['live'] = $this->live_url($type[3].'/'.$row['slug'], $row);
				$explicit = (string) $row['robots'];
				$row['noindex'] = stripos($explicit, 'noindex') === 0 || ($explicit === '' && $type[1] === 'case_studies' && $this->is_sample_study($row));
			}
			unset($row);
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

	/** The address this page has on the live site: a valid override, otherwise its own production URL. */
	private function live_url($path, $seo)
	{
		$stored = isset($seo['canonical_url']) ? trim((string) $seo['canonical_url']) : '';
		$noindex = isset($seo['robots']) && stripos((string) $seo['robots'], 'noindex') === 0;
		if ($stored !== '' && ! $noindex && seo_canonical_error($stored, $path === '') === NULL)
		{
			return seo_is_home_url($stored) ? rtrim(seo_normalize_url($stored), '/').'/' : seo_normalize_url($stored);
		}
		return seo_production_url($path);
	}

	private function is_sample_study(array $row)
	{
		$this->load->model('case_study_model');
		return Case_study_model::is_sample($row);
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
				'secondary_keywords' => trim((string) $this->input->post('secondary_keywords')),
				'og_title' => trim((string) $this->input->post('og_title')),
				'og_description' => trim((string) $this->input->post('og_description')),
				'canonical_url' => trim((string) $this->input->post('canonical_url')),
				'og_image' => '',
				'robots' => trim((string) $this->input->post('robots')),
			);
			$image_error = NULL;
			$image = $this->social_image_value('og_image', $image_error);
			$seo['og_image'] = $image === NULL ? trim((string) $this->input->post('og_image')) : $image;
			if (mb_strlen($seo['meta_title']) > 255 OR mb_strlen($seo['meta_description']) > 500 OR mb_strlen($seo['focus_keyword']) > 120 OR mb_strlen($seo['secondary_keywords']) > 255 OR mb_strlen($seo['og_title']) > 255 OR mb_strlen($seo['og_description']) > 500)
			{
				$error = 'The title or description is too long.';
			}
			elseif (($canonical_error = seo_canonical_error($seo['canonical_url'], $key === 'home')) !== NULL)
			{
				$error = $canonical_error;
			}
			elseif ($image_error !== NULL)
			{
				$error = $image_error;
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

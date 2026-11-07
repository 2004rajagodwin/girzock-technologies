<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	public function index()
	{
		$this->load->model(array('portfolio_model', 'blog_model'));
		$this->render('frontend/home/index', array(
			'is_home' => TRUE,
			'use_wrapper' => TRUE,
			'seo' => $this->seo->build(array('entity' => array('page', 'home'), 'path' => '')),
			'overview_services' => $this->settings_model->services_by('home_overview_order'),
			'core_services' => $this->settings_model->services_by('home_core_order'),
			'service_count' => count($this->settings_model->active_services()),
			'featured_projects' => $this->portfolio_model->featured(),
			'latest_posts' => $this->blog_model->list_public(array(), 3),
		));
	}

	public function legal($page = '')
	{
		$pages = array(
			'privacy' => array('Privacy Policy', 'privacy-policy', 'How GIRZOCK Technologies collects, uses, keeps and protects the personal details you send through our enquiry, contact and job application forms.'),
			'terms' => array('Terms and Conditions', 'terms', 'The terms that apply when you use the GIRZOCK Technologies website, including its information, promotional offers, sample work and links to other sites.'),
			'cookies' => array('Cookie Policy', 'cookie-policy', 'The cookies and browser storage the GIRZOCK Technologies website uses, what each one is for, how long it lasts and how you can control them.'),
		);
		if ( ! isset($pages[$page]))
		{
			$this->not_found();
		}
		$item = $pages[$page];
		$this->render('frontend/legal/page', array(
			'legal_page' => $page,
			'legal_title' => $item[0],
			'seo' => $this->seo->build(array('title' => $item[0].' | '.setting('company_name'), 'description' => $item[2], 'path' => $item[1],
				'breadcrumbs' => array('Home' => '', $item[0] => NULL))),
		));
	}

	public function areas()
	{
		$this->render('frontend/home/areas', array(
			'seo' => $this->seo->build(array('entity' => array('page', 'areas-we-serve'), 'path' => 'areas-we-serve',
				'breadcrumbs' => array('Home' => '', 'Areas We Serve' => NULL))),
		));
	}

	public function about()
	{
		$this->render('frontend/home/about', array(
			'use_wrapper' => TRUE,
			'service_count' => count($this->settings_model->active_services()),
			'seo' => $this->seo->build(array('entity' => array('page', 'about'), 'path' => 'about',
				'breadcrumbs' => array('Home' => '', 'About' => NULL))),
		));
	}
}

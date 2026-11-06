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
			'featured_projects' => $this->portfolio_model->featured(),
			'latest_posts' => $this->blog_model->list_public(array(), 3),
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
			'seo' => $this->seo->build(array('entity' => array('page', 'about'), 'path' => 'about',
				'breadcrumbs' => array('Home' => '', 'About' => NULL))),
		));
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('service_model');
	}

	public function index()
	{
		$this->render('frontend/services/index', array(
			'gallery_css' => TRUE,
			'seo' => $this->seo->build(array('entity' => array('page', 'services'), 'path' => 'services',
				'breadcrumbs' => array('Home' => '', 'Services' => NULL))),
			'card_services' => $this->service_model->public_by_layout('card'),
			'feature_services' => $this->service_model->public_by_layout('feature'),
		));
	}

	public function detail($slug = '')
	{
		$service = $this->service_model->find_public($slug);
		$is_preview = FALSE;
		if ( ! $service && $this->preview_allowed('services'))
		{
			$service = $this->service_model->find_for_preview($slug);
			$is_preview = (bool) $service;
		}
		if ( ! $service)
		{
			$this->not_found();
		}
		$path = 'services/'.$service['slug'];
		$description = $service['short_description'] ? $service['short_description'] : plain_excerpt($service['description']);
		$this->render('frontend/services/detail', array(
			'service' => $service,
			'is_preview' => $is_preview,
			'related' => $this->service_model->related_to($service),
			'seo' => $this->seo->build(array(
				'entity' => array('service', $service['id']),
				'is_preview' => $is_preview,
				'title' => $service['title'].' | '.setting('company_name'),
				'description' => $description,
				'path' => $path,
				'image' => $service['detail_image'] ? $service['detail_image'] : $service['image'],
				'breadcrumbs' => array('Home' => '', 'Services' => 'services', $service['title'] => NULL),
				'schema' => array(array('@context' => 'https://schema.org', '@type' => 'Service', 'name' => $service['title'], 'description' => $description,
					'url' => $this->seo->canonical($path), 'provider' => $this->seo->provider(), 'areaServed' => $this->seo->area_served())),
			)),
		));
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CaseStudies extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('case_study_model');
	}

	public function index()
	{
		$studies = $this->case_study_model->published();
		$samples = array_filter($studies, function ($study) { return stripos((string) $study['card_label'], 'sample') !== FALSE; });
		$this->render('frontend/case-studies/index', array(
			'gallery_scripts' => TRUE,
			'seo' => $this->seo->build(array('entity' => array('page', 'case-studies'), 'path' => 'case-studies',
				'breadcrumbs' => array('Home' => '', 'Case Studies' => NULL))),
			'studies' => $studies,
			'sample_count' => count($samples),
			'service_count' => count($this->settings_model->services_by('home_core_order')),
		));
	}

	public function detail($slug = '')
	{
		$study = $this->case_study_model->find_public($slug);
		$is_preview = FALSE;
		if ( ! $study && $this->preview_allowed('case_studies'))
		{
			$study = $this->case_study_model->find_for_preview($slug);
			$is_preview = (bool) $study;
		}
		if ( ! $study)
		{
			$this->not_found();
		}
		$this->load->model('portfolio_model');
		$this->render('frontend/case-studies/detail', array(
			'study' => $study,
			'is_preview' => $is_preview,
			'related_projects' => $this->portfolio_model->for_case_study($study['id']),
			'gallery_scripts' => (bool) text_lines($study['gallery']),
			'seo' => $this->seo->build(array(
				'entity' => array('case_study', $study['id']),
				'is_preview' => $is_preview,
				'title' => $study['title'].' | Case Study | '.setting('company_name'),
				'description' => $study['summary'] ? $study['summary'] : plain_excerpt($study['challenge']),
				'path' => 'case-studies/'.$study['slug'],
				'image' => $study['image'],
				'og_type' => 'article',
				'breadcrumbs' => array('Home' => '', 'Case Studies' => 'case-studies', $study['title'] => NULL),
			)),
		));
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('portfolio_model');
	}

	public function index()
	{
		$categories = $this->db->where('type', 'portfolio')->order_by('sort_order', 'ASC')->get('content_categories')->result_array();
		$this->render('frontend/portfolio/index', array(
			'gallery_scripts' => TRUE,
			'seo' => $this->seo->build(array('entity' => array('page', 'portfolio'), 'path' => 'portfolio',
				'breadcrumbs' => array('Home' => '', 'Portfolio' => NULL))),
			'categories' => $categories,
			'projects' => $this->portfolio_model->gallery(),
		));
	}

	public function detail($slug = '')
	{
		$project = $this->portfolio_model->find_public($slug);
		$is_preview = FALSE;
		if ( ! $project && $this->preview_allowed('portfolio'))
		{
			$project = $this->portfolio_model->find_for_preview($slug);
			$is_preview = (bool) $project;
		}
		if ( ! $project)
		{
			$this->not_found();
		}
		$this->load->model('case_study_model');
		$case_study = NULL;
		if ($project['case_study_id'])
		{
			$study = $this->case_study_model->find($project['case_study_id']);
			$case_study = ($study && $study['status'] === 'published') ? $study : NULL;
		}
		$this->render('frontend/portfolio/detail', array(
			'project' => $project,
			'is_preview' => $is_preview,
			'case_study' => $case_study,
			'gallery_scripts' => (bool) text_lines($project['gallery']),
			'seo' => $this->seo->build(array(
				'entity' => array('portfolio', $project['id']),
				'is_preview' => $is_preview,
				'title' => $project['title'].' | Portfolio | '.setting('company_name'),
				'description' => $project['short_description'] ? $project['short_description'] : plain_excerpt($project['description']),
				'path' => 'portfolio/'.$project['slug'],
				'image' => $project['image'],
				'breadcrumbs' => array('Home' => '', 'Portfolio' => 'portfolio', $project['title'] => NULL),
			)),
		));
	}
}

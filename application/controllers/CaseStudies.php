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
			'seo' => $this->seo->build(array('entity' => array('page', 'case-studies'), 'path' => 'case-studies', 'webpage_type' => 'CollectionPage',
				'breadcrumbs' => array('Home' => '', 'Case Studies' => NULL))),
			'studies' => $studies,
			'sample_count' => count($samples),
			'service_count' => count($this->settings_model->active_services()),
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
				// Sample concepts are thin and not client work, so they default to noindex. An explicit
				// "index, follow" saved in the admin still wins.
				'robots' => Case_study_model::is_sample($study) ? 'noindex, follow' : NULL,
				'breadcrumbs' => array('Home' => '', 'Case Studies' => 'case-studies', $study['title'] => NULL),
				// Article markup, with only facts held for the record: no ratings, results or client names are added
				'schema' => $is_preview ? array() : array(array_filter(array('@context' => 'https://schema.org', '@type' => 'Article', 'headline' => $study['title'], 'description' => $study['summary'] ? $study['summary'] : plain_excerpt($study['challenge']), 'image' => $study['image'] ? $this->seo->absolute_media($study['image']) : NULL, 'datePublished' => date('c', strtotime($study['created_at'])), 'dateModified' => date('c', strtotime($study['updated_at'])), 'author' => $this->seo->provider(), 'publisher' => $this->seo->provider(), 'mainEntityOfPage' => $this->seo->canonical_for('case-studies/'.$study['slug'])))),
			)),
		));
	}
}

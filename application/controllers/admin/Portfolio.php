<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends Admin_Crud_Controller {

	protected $module = 'portfolio';
	protected $model_name = 'portfolio_model';
	protected $route = 'portfolio';
	protected $public_base = 'portfolio';
	protected $seo_type = 'portfolio';
	protected $title_plural = 'Portfolio';
	protected $title_singular = 'Project';
	protected $status_toggle = array('published', 'draft');
	protected $status_filter = array('published', 'draft');

	protected function columns()
	{
		return array('image' => array('Image', 'image'), 'title' => array('Project', 'text'), 'category_name' => array('Category', 'text'), 'placement' => array('Shown on', 'human'), 'updated_at' => array('Updated', 'date'), 'status' => array('Status', 'status'));
	}

	protected function fields()
	{
		$this->load->model('case_study_model');
		$studies = array('' => 'None');
		foreach ($this->case_study_model->options() as $row)
		{
			$studies[$row['id']] = $row['title'];
		}
		return array(
			array('name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => TRUE, 'max' => 160, 'group' => 'main'),
			array('name' => 'short_description', 'label' => 'Short description', 'type' => 'textarea', 'max' => 500, 'group' => 'main'),
			array('name' => 'description', 'label' => 'Project description', 'type' => 'richtext', 'group' => 'main'),
			array('name' => 'client_name', 'label' => 'Client name', 'type' => 'text', 'max' => 160, 'group' => 'main'),
			array('name' => 'client_details', 'label' => 'Client details', 'type' => 'textarea', 'max' => 500, 'group' => 'main'),
			array('name' => 'technologies', 'label' => 'Technologies used', 'type' => 'text', 'max' => 500, 'group' => 'main', 'help' => 'Separate with commas.'),
			array('name' => 'gallery', 'label' => 'Project gallery', 'type' => 'gallery', 'group' => 'main'),
			array('name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => TRUE, 'options' => array('draft' => 'Draft', 'published' => 'Published'), 'group' => 'side'),
			array('name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => $this->content_category_options('portfolio'), 'group' => 'side'),
			array('name' => 'placement', 'label' => 'Show on', 'type' => 'select', 'required' => TRUE, 'options' => array('gallery' => 'Portfolio gallery', 'featured' => 'Homepage featured projects', 'both' => 'Both'), 'group' => 'side'),
			array('name' => 'card_label', 'label' => 'Homepage card label', 'type' => 'text', 'max' => 80, 'group' => 'side', 'help' => 'For example: Concept / E-commerce'),
			array('name' => 'image', 'label' => 'Main image', 'type' => 'image', 'group' => 'side'),
			array('name' => 'image_alt', 'label' => 'Main image alt text', 'type' => 'text', 'max' => 255, 'group' => 'side'),
			array('name' => 'live_url', 'label' => 'Live website URL', 'type' => 'url', 'max' => 255, 'group' => 'side'),
			array('name' => 'case_study_id', 'label' => 'Related case study', 'type' => 'select', 'options' => $studies, 'group' => 'side'),
			array('name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'group' => 'side'),
		);
	}
}

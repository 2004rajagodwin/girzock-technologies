<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CaseStudies extends Admin_Crud_Controller {

	protected $module = 'case_studies';
	protected $model_name = 'case_study_model';
	protected $route = 'case-studies';
	protected $public_base = 'case-studies';
	protected $seo_type = 'case_study';
	protected $title_plural = 'Case Studies';
	protected $title_singular = 'Case Study';
	protected $status_toggle = array('published', 'draft');
	protected $status_filter = array('published', 'draft');

	protected function columns()
	{
		return array('title' => array('Case study', 'text'), 'service_label' => array('Service', 'text'), 'card_label' => array('Label', 'text'), 'sort_order' => array('Order', 'text'), 'updated_at' => array('Updated', 'date'), 'status' => array('Status', 'status'));
	}

	protected function fields()
	{
		$this->load->model('portfolio_model');
		$projects = array();
		foreach ($this->portfolio_model->options() as $row)
		{
			$projects[$row['id']] = $row['title'];
		}
		return array(
			array('name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => TRUE, 'max' => 160, 'group' => 'main'),
			array('name' => 'summary', 'label' => 'Summary', 'type' => 'textarea', 'max' => 500, 'group' => 'main', 'help' => 'Shown on the listing card and as the default SEO description.'),
			array('name' => 'overview', 'label' => 'Project overview', 'type' => 'textarea', 'group' => 'main'),
			array('name' => 'challenge', 'label' => 'Client challenge', 'type' => 'textarea', 'required' => TRUE, 'group' => 'main'),
			array('name' => 'solution', 'label' => 'Proposed solution', 'type' => 'textarea', 'required' => TRUE, 'group' => 'main'),
			array('name' => 'implementation', 'label' => 'Implementation details', 'type' => 'textarea', 'group' => 'main'),
			array('name' => 'results', 'label' => 'Results', 'type' => 'textarea', 'group' => 'main', 'help' => 'Only publish results the client has approved and you can verify.'),
			array('name' => 'highlights', 'label' => 'Highlights', 'type' => 'lines', 'group' => 'main', 'help' => 'One per line.'),
			array('name' => 'quote', 'label' => 'Quote', 'type' => 'textarea', 'max' => 500, 'group' => 'main'),
			array('name' => 'quote_author', 'label' => 'Quote author', 'type' => 'text', 'max' => 120, 'group' => 'main'),
			array('name' => 'gallery', 'label' => 'Images', 'type' => 'gallery', 'group' => 'main'),
			array('name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => TRUE, 'options' => array('draft' => 'Draft', 'published' => 'Published'), 'group' => 'side'),
			array('name' => 'image', 'label' => 'Main image', 'type' => 'image', 'group' => 'side'),
			array('name' => 'image_alt', 'label' => 'Main image alt text', 'type' => 'text', 'max' => 255, 'group' => 'side', 'help' => 'For a sample concept, say that it is a concept.'),
			array('name' => 'card_label', 'label' => 'Card label', 'type' => 'text', 'max' => 60, 'group' => 'side', 'help' => 'For example: Sample concept, or Client project'),
			array('name' => 'card_title', 'label' => 'Card title', 'type' => 'text', 'max' => 160, 'group' => 'side'),
			array('name' => 'category_label', 'label' => 'Category', 'type' => 'text', 'max' => 80, 'group' => 'side'),
			array('name' => 'service_label', 'label' => 'Service', 'type' => 'text', 'max' => 120, 'group' => 'side'),
			array('name' => 'approach', 'label' => 'Approach', 'type' => 'text', 'max' => 160, 'group' => 'side'),
			array('name' => 'status_label', 'label' => 'Status shown publicly', 'type' => 'text', 'max' => 120, 'group' => 'side'),
			array('name' => 'related_projects', 'label' => 'Related projects', 'type' => 'multiselect', 'options' => $projects, 'virtual' => TRUE, 'group' => 'side'),
			array('name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'group' => 'side'),
		);
	}

	protected function form_values(array $values, $id)
	{
		if ($id)
		{
			$rows = $this->db->select('id')->get_where('portfolio_projects', array('case_study_id' => (int) $id))->result_array();
			$values['related_projects'] = array_column($rows, 'id');
		}
		return $values;
	}

	protected function after_save($id, array $data)
	{
		$this->load->model('portfolio_model');
		$posted = $this->input->post('related_projects');
		$this->portfolio_model->assign_case_study($id, is_array($posted) ? $posted : array());
	}
}

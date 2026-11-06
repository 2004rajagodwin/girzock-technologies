<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends Admin_Crud_Controller {

	protected $module = 'careers';
	protected $model_name = 'career_model';
	protected $route = 'careers';
	protected $public_base = 'careers';
	protected $seo_type = 'career';
	protected $title_plural = 'Careers';
	protected $title_singular = 'Job Opening';
	protected $status_toggle = array('active', 'disabled');
	protected $status_filter = array('active', 'disabled', 'archived');

	protected function columns()
	{
		return array('title' => array('Position', 'text'), 'employment_type' => array('Type', 'human'), 'location' => array('Location', 'text'), 'applications_enabled' => array('Applications', 'yesno'), 'status' => array('Status', 'status'));
	}

	protected function fields()
	{
		return array(
			array('name' => 'title', 'label' => 'Job title', 'type' => 'text', 'required' => TRUE, 'max' => 160, 'group' => 'main'),
			array('name' => 'summary', 'label' => 'Summary', 'type' => 'textarea', 'max' => 600, 'group' => 'main', 'help' => 'Shown on the careers page.'),
			array('name' => 'description', 'label' => 'Job description', 'type' => 'richtext', 'group' => 'main'),
			array('name' => 'responsibilities', 'label' => 'Responsibilities', 'type' => 'lines', 'group' => 'main', 'help' => 'One per line.'),
			array('name' => 'qualifications', 'label' => 'Qualifications', 'type' => 'lines', 'group' => 'main', 'help' => 'One per line.'),
			array('name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => TRUE, 'options' => array('active' => 'Active', 'disabled' => 'Disabled', 'archived' => 'Archived'), 'group' => 'side'),
			array('name' => 'applications_enabled', 'label' => 'Accept applications', 'type' => 'checkbox', 'group' => 'side'),
			array('name' => 'employment_type', 'label' => 'Employment type', 'type' => 'select', 'required' => TRUE, 'options' => array('FULL_TIME' => 'Full time', 'PART_TIME' => 'Part time', 'CONTRACTOR' => 'Contract', 'TEMPORARY' => 'Temporary', 'INTERN' => 'Internship', 'OTHER' => 'Other'), 'group' => 'side'),
			array('name' => 'experience_required', 'label' => 'Experience required', 'type' => 'text', 'max' => 120, 'group' => 'side'),
			array('name' => 'location', 'label' => 'Location', 'type' => 'text', 'max' => 160, 'group' => 'side'),
			array('name' => 'closes_at', 'label' => 'Closing date', 'type' => 'date', 'group' => 'side'),
			array('name' => 'legacy_anchor', 'label' => 'Page anchor', 'type' => 'text', 'max' => 60, 'group' => 'side'),
			array('name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'group' => 'side'),
		);
	}
}

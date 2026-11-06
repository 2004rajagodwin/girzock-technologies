<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Career_model extends MY_Model {

	protected $table = 'career_openings';
	protected $search_columns = array('title', 'location');
	protected $default_order = array('sort_order' => 'ASC', 'id' => 'ASC');

	public function active()
	{
		$this->base()->where('status', 'active')->order_by('sort_order', 'ASC')->order_by('id', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	public function find_public($slug)
	{
		$this->base()->where(array('slug' => $slug, 'status' => 'active'));
		return $this->db->get($this->table, 1)->row_array();
	}

	public function accepts_applications(array $job)
	{
		return (int) $job['applications_enabled'] === 1 && $job['status'] === 'active'
			&& (empty($job['closes_at']) OR $job['closes_at'] >= date('Y-m-d'));
	}
}

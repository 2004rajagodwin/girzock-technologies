<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio_model extends MY_Model {

	protected $table = 'portfolio_projects';
	protected $search_columns = array('portfolio_projects.title', 'portfolio_projects.client_name', 'portfolio_projects.technologies');
	protected $default_order = array('portfolio_projects.sort_order' => 'ASC', 'portfolio_projects.id' => 'ASC');

	private function with_category()
	{
		return $this->db->select('portfolio_projects.*, content_categories.name AS category_name')
			->join('content_categories', 'content_categories.id = portfolio_projects.category_id', 'left');
	}

	public function list_filtered(array $filters, $limit, $offset)
	{
		$this->with_category();
		return parent::list_filtered($filters, $limit, $offset);
	}

	public function gallery()
	{
		$this->with_category();
		$this->base()->where('portfolio_projects.status', 'published')->where_in('portfolio_projects.placement', array('gallery', 'both'))
			->order_by('portfolio_projects.sort_order', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	public function featured($limit = 8)
	{
		$this->base()->where('status', 'published')->where_in('placement', array('featured', 'both'))->order_by('sort_order', 'ASC');
		return $this->db->get($this->table, (int) $limit)->result_array();
	}

	public function find_for_preview($slug)
	{
		$this->with_category();
		return parent::find_for_preview($slug);
	}

	public function find_public($slug)
	{
		$this->with_category();
		$this->base()->where(array('portfolio_projects.slug' => $slug, 'portfolio_projects.status' => 'published'));
		return $this->db->get($this->table, 1)->row_array();
	}

	public function for_case_study($case_study_id)
	{
		$this->base()->where(array('case_study_id' => (int) $case_study_id, 'status' => 'published'))->order_by('sort_order', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	/** Points the chosen projects at a case study and clears the rest, in one transaction. */
	public function assign_case_study($case_study_id, array $project_ids)
	{
		$this->db->trans_start();
		$this->db->where('case_study_id', (int) $case_study_id)->update($this->table, array('case_study_id' => NULL));
		if ($project_ids)
		{
			$this->db->where_in('id', array_map('intval', $project_ids))->update($this->table, array('case_study_id' => (int) $case_study_id));
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function options()
	{
		$this->base()->select('id, title')->order_by('title', 'ASC');
		return $this->db->get($this->table)->result_array();
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_study_model extends MY_Model {

	protected $table = 'case_studies';
	protected $search_columns = array('title', 'summary', 'service_label');
	protected $default_order = array('sort_order' => 'ASC', 'id' => 'ASC');

	public function published()
	{
		$this->base()->where('status', 'published')->order_by('sort_order', 'ASC')->order_by('id', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	/** A sample concept, not a client project: labelled "Sample" on its card or status. These stay out of search by default. */
	public static function is_sample(array $study)
	{
		return stripos((string) (isset($study['card_label']) ? $study['card_label'] : ''), 'sample') !== FALSE OR stripos((string) (isset($study['status_label']) ? $study['status_label'] : ''), 'sample') !== FALSE;
	}

	public function find_public($slug)
	{
		$this->base()->where(array('slug' => $slug, 'status' => 'published'));
		return $this->db->get($this->table, 1)->row_array();
	}

	public function options()
	{
		$this->base()->select('id, title')->order_by('title', 'ASC');
		return $this->db->get($this->table)->result_array();
	}
}

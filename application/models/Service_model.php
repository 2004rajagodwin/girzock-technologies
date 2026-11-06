<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends MY_Model {

	protected $table = 'services';
	protected $search_columns = array('title', 'short_description');
	protected $default_order = array('page_order' => 'ASC', 'id' => 'ASC');

	public function find_public($slug)
	{
		$this->base()->where(array('slug' => $slug, 'status' => 'active'));
		return $this->db->get($this->table, 1)->row_array();
	}

	public function public_by_layout($layout)
	{
		$this->base()->where(array('status' => 'active', 'page_layout' => $layout))->order_by('page_order', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	/** The services chosen for this one, in the chosen order, or a default set. */
	public function related_to(array $service, $limit = 3)
	{
		$slugs = array_filter(array_map('trim', explode(',', (string) $service['related_services'])));
		if ( ! $slugs)
		{
			return $this->related($service['id'], $limit);
		}
		$rows = array();
		foreach ($this->db->where('status', 'active')->where('deleted_at IS NULL', NULL, FALSE)->where_in('slug', $slugs)->get($this->table)->result_array() as $row)
		{
			$rows[$row['slug']] = $row;
		}
		$ordered = array();
		foreach ($slugs as $slug)
		{
			if (isset($rows[$slug]))
			{
				$ordered[] = $rows[$slug];
			}
		}
		return array_slice($ordered, 0, $limit);
	}

	public function related($id, $limit = 3)
	{
		$this->base()->where(array('status' => 'active', 'id !=' => (int) $id))->order_by('page_order', 'ASC');
		return $this->db->get($this->table, (int) $limit)->result_array();
	}
}

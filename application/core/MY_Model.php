<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shared data access for content tables: soft delete, search, pagination and unique slugs.
 * Every query goes through Query Builder or bound parameters.
 */
class MY_Model extends CI_Model {

	protected $table = '';
	protected $soft_delete = TRUE;
	protected $search_columns = array('title');
	protected $default_order = array('id' => 'DESC');

	/** Records that have not been deleted. */
	protected function base()
	{
		if ($this->soft_delete)
		{
			$this->db->where($this->table.'.deleted_at IS NULL', NULL, FALSE);
		}
		return $this->db;
	}

	/** The database table behind this model. */
	public function table_name()
	{
		return $this->table;
	}

	public function find($id)
	{
		$this->base()->where($this->table.'.id', (int) $id);
		$row = $this->db->get($this->table, 1)->row_array();
		return $row ? $row : NULL;
	}

	/** A record of any status, for an admin preview. */
	public function find_for_preview($slug)
	{
		$this->base()->where($this->table.'.slug', $slug);
		$row = $this->db->get($this->table, 1)->row_array();
		return $row ? $row : NULL;
	}

	/** Applies status and text filters for the admin lists. */
	protected function apply_filters(array $filters)
	{
		if ( ! empty($filters['status']))
		{
			$this->db->where($this->table.'.status', $filters['status']);
		}
		if ( ! empty($filters['q']))
		{
			$this->db->group_start();
			foreach ($this->search_columns as $column)
			{
				$this->db->or_like($column, $filters['q']);
			}
			$this->db->group_end();
		}
	}

	public function count_filtered(array $filters = array())
	{
		$this->base();
		$this->apply_filters($filters);
		return (int) $this->db->count_all_results($this->table);
	}

	public function list_filtered(array $filters, $limit, $offset)
	{
		$this->base();
		$this->apply_filters($filters);
		foreach ($this->default_order as $column => $direction)
		{
			$this->db->order_by($column, $direction);
		}
		return $this->db->get($this->table, (int) $limit, (int) $offset)->result_array();
	}

	public function create(array $data)
	{
		return $this->db->insert($this->table, $data) ? (int) $this->db->insert_id() : FALSE;
	}

	public function update_by_id($id, array $data)
	{
		return $this->db->where('id', (int) $id)->update($this->table, $data);
	}

	public function remove($id)
	{
		if ($this->soft_delete)
		{
			return $this->update_by_id($id, array('deleted_at' => date('Y-m-d H:i:s')));
		}
		return $this->db->where('id', (int) $id)->delete($this->table);
	}

	/** Returns $slug, or $slug-2, $slug-3... when taken. Deleted records keep their slug reserved. */
	public function unique_slug($slug, $ignore_id = NULL)
	{
		$base = make_slug($slug);
		$candidate = $base;
		for ($n = 2; ; $n++)
		{
			$this->db->where('slug', $candidate);
			if ($ignore_id)
			{
				$this->db->where('id !=', (int) $ignore_id);
			}
			if ($this->db->count_all_results($this->table) === 0)
			{
				return $candidate;
			}
			$candidate = $base.'-'.$n;
		}
	}
}

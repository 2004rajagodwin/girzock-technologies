<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model {

	protected $table = 'products';
	protected $search_columns = array('products.title', 'products.short_description');
	protected $default_order = array('products.sort_order' => 'ASC', 'products.id' => 'ASC');

	private function with_category()
	{
		return $this->db->select('products.*, content_categories.name AS category_name')
			->join('content_categories', 'content_categories.id = products.category_id', 'left');
	}

	public function list_filtered(array $filters, $limit, $offset)
	{
		$this->with_category();
		return parent::list_filtered($filters, $limit, $offset);
	}

	public function published()
	{
		$this->with_category();
		$this->base()->where('products.status', 'published')->order_by('products.sort_order', 'ASC')->order_by('products.id', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	public function find_for_preview($slug)
	{
		$this->with_category();
		return parent::find_for_preview($slug);
	}

	public function find_public($slug)
	{
		$this->with_category();
		$this->base()->where(array('products.slug' => $slug, 'products.status' => 'published'));
		return $this->db->get($this->table, 1)->row_array();
	}
}

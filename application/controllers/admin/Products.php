<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Crud_Controller {

	protected $module = 'products';
	protected $model_name = 'product_model';
	protected $route = 'products';
	protected $public_base = 'products';
	protected $seo_type = 'product';
	protected $title_plural = 'Products';
	protected $title_singular = 'Product';
	protected $status_toggle = array('published', 'draft');
	protected $status_filter = array('published', 'draft');

	protected function columns()
	{
		return array('image' => array('Image', 'image'), 'title' => array('Product', 'text'), 'category_name' => array('Category', 'text'), 'sort_order' => array('Order', 'text'), 'updated_at' => array('Updated', 'date'), 'status' => array('Status', 'status'));
	}

	protected function fields()
	{
		return array(
			array('name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => TRUE, 'max' => 160, 'group' => 'main'),
			array('name' => 'short_description', 'label' => 'Short description', 'type' => 'textarea', 'max' => 500, 'group' => 'main'),
			array('name' => 'description', 'label' => 'Full description', 'type' => 'richtext', 'group' => 'main'),
			array('name' => 'features', 'label' => 'Features', 'type' => 'lines', 'group' => 'main', 'help' => 'One feature per line.'),
			array('name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => TRUE, 'options' => array('draft' => 'Draft', 'published' => 'Published'), 'group' => 'side'),
			array('name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => $this->content_category_options('product'), 'group' => 'side'),
			array('name' => 'image', 'label' => 'Product image', 'type' => 'image', 'group' => 'side'),
			array('name' => 'external_url', 'label' => 'External product URL', 'type' => 'url', 'max' => 255, 'group' => 'side'),
			array('name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'group' => 'side'),
		);
	}
}

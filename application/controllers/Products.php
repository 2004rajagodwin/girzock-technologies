<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
	}

	public function index()
	{
		$this->render('frontend/products/index', array(
			'seo' => $this->seo->build(array('entity' => array('page', 'products'), 'path' => 'products', 'webpage_type' => 'CollectionPage',
				'breadcrumbs' => array('Home' => '', 'Products' => NULL))),
			'products' => $this->product_model->published(),
		));
	}

	public function detail($slug = '')
	{
		$product = $this->product_model->find_public($slug);
		$is_preview = FALSE;
		if ( ! $product && $this->preview_allowed('products'))
		{
			$product = $this->product_model->find_for_preview($slug);
			$is_preview = (bool) $product;
		}
		if ( ! $product)
		{
			$this->not_found();
		}
		$path = 'products/'.$product['slug'];
		$description = $product['short_description'] ? $product['short_description'] : plain_excerpt($product['description']);
		$this->render('frontend/products/detail', array(
			'product' => $product,
			'is_preview' => $is_preview,
			'seo' => $this->seo->build(array(
				'entity' => array('product', $product['id']),
				'is_preview' => $is_preview,
				'title' => $product['title'].' | '.setting('company_name'),
				'description' => $description,
				'path' => $path,
				'image' => $product['image'],
				'breadcrumbs' => array('Home' => '', 'Products' => 'products', $product['title'] => NULL),
				'schema' => array(array('@context' => 'https://schema.org', '@type' => 'Product', 'name' => $product['title'], 'description' => $description,
					'image' => $this->seo->absolute_media($product['image']), 'url' => $this->seo->canonical($path), 'brand' => array('@type' => 'Brand', 'name' => setting('company_name')))),
			)),
		));
	}
}

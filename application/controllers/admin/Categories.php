<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Blog categories, blog tags, and product and portfolio categories on one page. */
class Categories extends Admin_Controller {

	protected $module = 'categories';

	private function groups()
	{
		return array(
			'blog' => array('label' => 'Blog categories', 'table' => 'blog_categories', 'where' => array(), 'fixed' => array(), 'sortable' => TRUE),
			'tag' => array('label' => 'Blog tags', 'table' => 'blog_tags', 'where' => array(), 'fixed' => array(), 'sortable' => FALSE),
			'product' => array('label' => 'Product categories', 'table' => 'content_categories', 'where' => array('type' => 'product'), 'fixed' => array('type' => 'product'), 'sortable' => TRUE),
			'portfolio' => array('label' => 'Portfolio categories', 'table' => 'content_categories', 'where' => array('type' => 'portfolio'), 'fixed' => array('type' => 'portfolio'), 'sortable' => TRUE),
		);
	}

	public function index()
	{
		$groups = $this->groups();
		foreach ($groups as $key => &$group)
		{
			if ($group['sortable'])
			{
				$this->db->order_by('sort_order', 'ASC');
			}
			$group['rows'] = $this->db->where($group['where'])->order_by('name', 'ASC')->get($group['table'])->result_array();
		}
		unset($group);
		$this->render('admin/categories/index', array(
			'page_title' => 'Categories',
			'groups' => $groups,
			'can_create' => $this->auth->can('categories', 'create'),
			'can_edit' => $this->auth->can('categories', 'edit'),
			'can_delete' => $this->auth->can('categories', 'delete'),
		));
	}

	public function save($group_key = '', $id = 0)
	{
		$this->require_post();
		$groups = $this->groups();
		if ( ! isset($groups[$group_key]))
		{
			show_404();
		}
		$group = $groups[$group_key];
		$id = (int) $id;
		$this->require_can($id ? 'edit' : 'create');

		$name = trim(strip_tags((string) $this->input->post('name')));
		if ($name === '' OR mb_strlen($name) > 80)
		{
			$this->flash_error('A name between 1 and 80 characters is required.');
			redirect('admin/categories');
		}
		$slug = make_slug($name);
		$this->db->where($group['where'])->where('slug', $slug);
		if ($id)
		{
			$this->db->where('id !=', $id);
		}
		if ($this->db->count_all_results($group['table']) > 0)
		{
			$this->flash_error('"'.$name.'" already exists.');
			redirect('admin/categories');
		}
		$data = array_merge($group['fixed'], array('name' => $name));
		if ($group['sortable'])
		{
			$data['sort_order'] = (int) $this->input->post('sort_order');
		}
		if ($id)
		{
			$current = $this->db->where($group['where'])->get_where($group['table'], array('id' => $id), 1)->row_array();
			if ( ! $current)
			{
				show_404();
			}
			$data['slug'] = $slug;
			$this->db->trans_start();
			$this->db->where('id', $id)->update($group['table'], $data);
			if ($group_key === 'blog' && $current['slug'] !== $slug)
			{
				$this->settings_model->add_redirect('blog/category/'.$current['slug'], 'blog/category/'.$slug);
			}
			$this->db->trans_complete();
		}
		else
		{
			$data['slug'] = $slug;
			$this->db->insert($group['table'], $data);
			$id = $this->db->insert_id();
		}
		$this->log_action('save', $id, $group['label'].': '.$name);
		$this->flash_success('Saved.');
		redirect('admin/categories');
	}

	/** Items in a deleted category stay published and simply lose the category. */
	public function delete($group_key = '', $id = 0)
	{
		$this->require_post();
		$this->require_can('delete');
		$groups = $this->groups();
		if ( ! isset($groups[$group_key]))
		{
			show_404();
		}
		$group = $groups[$group_key];
		$row = $this->db->where($group['where'])->get_where($group['table'], array('id' => (int) $id), 1)->row_array();
		if ( ! $row)
		{
			show_404();
		}
		$this->db->where('id', (int) $id)->delete($group['table']);
		$this->log_action('delete', $id, $group['label'].': '.$row['name']);
		$this->flash_success('Deleted.');
		redirect('admin/categories');
	}
}

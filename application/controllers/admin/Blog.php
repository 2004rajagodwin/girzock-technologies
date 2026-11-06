<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Admin_Crud_Controller {

	protected $module = 'blog';
	protected $model_name = 'blog_model';
	protected $route = 'blog';
	protected $public_base = 'blog';
	protected $seo_type = 'blog';
	protected $title_plural = 'Blog Management';
	protected $title_singular = 'Post';
	protected $status_toggle = array('published', 'unpublished');
	protected $status_filter = array('draft', 'scheduled', 'published', 'unpublished');

	protected function columns()
	{
		return array('featured_image' => array('Image', 'image'), 'title' => array('Title', 'text'), 'author_name' => array('Author', 'text'), 'published_at' => array('Publish date', 'date'), 'status' => array('Status', 'status'));
	}

	protected function fields()
	{
		$categories = array('' => 'No category');
		foreach ($this->blog_model->categories() as $row)
		{
			$categories[$row['id']] = $row['name'];
		}
		return array(
			array('name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => TRUE, 'max' => 200, 'group' => 'main'),
			array('name' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea', 'max' => 500, 'group' => 'main', 'help' => 'Shown on the homepage card and as the default SEO description.'),
			array('name' => 'content', 'label' => 'Content', 'type' => 'richtext', 'required' => TRUE, 'group' => 'main'),
			array('name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => TRUE, 'options' => array('draft' => 'Draft', 'scheduled' => 'Scheduled', 'published' => 'Published', 'unpublished' => 'Unpublished'), 'group' => 'side'),
			array('name' => 'published_at', 'label' => 'Publish date and time', 'type' => 'datetime', 'group' => 'side', 'help' => 'Required when scheduling. Left blank, publishing uses the current time.'),
			array('name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => $categories, 'group' => 'side'),
			array('name' => 'tags', 'label' => 'Tags', 'type' => 'text', 'virtual' => TRUE, 'group' => 'side', 'help' => 'Separate with commas. New tags are created automatically.'),
			array('name' => 'author_name', 'label' => 'Author', 'type' => 'text', 'max' => 120, 'group' => 'side', 'help' => 'Left blank, your own name is used.'),
			array('name' => 'reading_time', 'label' => 'Reading time (minutes)', 'type' => 'number', 'group' => 'side', 'help' => 'Left blank or 0, it is calculated from the content.'),
			array('name' => 'featured_image', 'label' => 'Featured image', 'type' => 'image', 'group' => 'side'),
			array('name' => 'featured_image_alt', 'label' => 'Featured image alt text', 'type' => 'text', 'max' => 255, 'group' => 'side', 'help' => 'Describe the image. Left blank, the article title is used.'),
		);
	}

	protected function form_values(array $values, $id)
	{
		if ($id)
		{
			$values['tags'] = implode(', ', $this->blog_model->post_tag_names($id));
		}
		return $values;
	}

	protected function prepare(array $data, $id, array &$errors)
	{
		if ($data['status'] === 'scheduled')
		{
			if (empty($data['published_at']))
			{
				$errors['published_at'] = 'Choose when this post should be published.';
			}
			elseif (strtotime($data['published_at']) <= time())
			{
				$errors['published_at'] = 'A scheduled time must be in the future.';
			}
		}
		if ($data['status'] === 'published' && empty($data['published_at']))
		{
			$data['published_at'] = date('Y-m-d H:i:s');
		}
		if (empty($data['author_name']))
		{
			$data['author_name'] = $this->user['full_name'];
		}
		if ( ! $id)
		{
			$data['author_id'] = $this->user['id'];
		}
		if (empty($data['reading_time']))
		{
			$data['reading_time'] = reading_minutes($data['content']);
		}
		return $data;
	}

	protected function after_save($id, array $data)
	{
		$this->blog_model->sync_tags($id, explode(',', (string) $this->input->post('tags')));
	}

	/** Publishing from the list needs a publish date too. */
	public function toggle($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$post = $this->blog_model->find($id);
		if ($post && $post['status'] !== 'published' && empty($post['published_at']))
		{
			$this->blog_model->update_by_id($post['id'], array('published_at' => date('Y-m-d H:i:s')));
		}
		parent::toggle($id);
	}
}

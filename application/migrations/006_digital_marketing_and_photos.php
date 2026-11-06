<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Adds the Digital Marketing service and its draft articles, and points all service menus and
 * pages at the realistic WebP images. Admin uploads and edited wording are kept, drafts stay
 * unpublished, and existing rows are never deleted.
 */
class Migration_Digital_marketing_and_photos extends CI_Migration {

	public function up()
	{
		$data = require APPPATH.'migrations/data/digital_marketing.php';
		$P = 'assets/images/generated/photo/';
		$this->db->trans_start();

		$service = $data['service'];
		$seo = $service['seo'];
		unset($service['seo']);
		$row = $this->db->get_where('services', array('slug' => $service['slug']), 1)->row_array();
		if ( ! $row)
		{
			$this->db->insert('services', $service);
			$this->add_seo('service', (int) $this->db->insert_id(), $seo);
		}

		foreach ($data['patches'] as $slug => $patch)
		{
			$target = $this->db->get_where('services', array('slug' => $slug), 1)->row_array();
			if ( ! $target)
			{
				continue;
			}
			$update = array();
			if ($target['related_services'] === $patch['old'])
			{
				$update['related_services'] = $patch['new'];
			}
			if (strpos((string) $target['description'], $patch['append']) === FALSE)
			{
				$update['description'] = $target['description'].$patch['append'];
			}
			if ($update)
			{
				$this->db->where('id', $target['id'])->update('services', $update);
			}
		}

		foreach ($data['photos'] as $slug => $alt)
		{
			$this->db->where('slug', $slug)->not_like('menu_image', 'assets/uploads/', 'after')->update('services', array('menu_image' => $P.'menu/'.$slug.'.webp'));
			$this->db->where('slug', $slug)->where("(detail_image IS NULL OR detail_image NOT LIKE 'assets/uploads/%')", NULL, FALSE)
				->update('services', array('detail_image' => $P.'services/'.$slug.'.webp', 'detail_image_alt' => $alt));
		}

		$category = $this->db->get_where('blog_categories', array('slug' => $data['category']['slug']), 1)->row_array();
		if ( ! $category)
		{
			$this->db->insert('blog_categories', $data['category']);
			$category_id = (int) $this->db->insert_id();
		}
		else
		{
			$category_id = (int) $category['id'];
		}

		foreach ($data['drafts'] as $slug => $post)
		{
			if ($this->db->where('slug', $slug)->count_all_results('blog_posts') > 0)
			{
				continue;
			}
			$this->db->insert('blog_posts', array(
				'category_id' => $category_id,
				'author_name' => 'GIRZOCK Team',
				'title' => $post['title'],
				'slug' => $slug,
				'excerpt' => $post['excerpt'],
				'content' => $post['content'],
				'featured_image' => $post['image'],
				'featured_image_alt' => $post['alt'],
				'reading_time' => max(1, (int) ceil(str_word_count(strip_tags($post['content'])) / 200)),
				'status' => 'draft',
			));
			$id = (int) $this->db->insert_id();
			$this->add_seo('blog', $id, $post['seo']);
			foreach ($post['tags'] as $order => $name)
			{
				$tag_slug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-');
				$tag = $this->db->get_where('blog_tags', array('slug' => $tag_slug), 1)->row_array();
				if ( ! $tag)
				{
					$this->db->insert('blog_tags', array('name' => $name, 'slug' => $tag_slug));
					$tag = array('id' => $this->db->insert_id());
				}
				$this->db->insert('blog_post_tags', array('post_id' => $id, 'tag_id' => (int) $tag['id'], 'sort_order' => $order));
			}
		}

		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The digital marketing migration could not be applied, and no changes were kept.');
		}
	}

	private function add_seo($type, $key, array $seo)
	{
		$this->db->insert('seo_metadata', array('entity_type' => $type, 'entity_key' => (string) $key, 'meta_title' => $seo[0], 'meta_description' => $seo[1], 'focus_keyword' => $seo[2]));
	}

	public function down()
	{
		// Content is not removed automatically. Unpublish the service in the admin panel if needed.
	}
}

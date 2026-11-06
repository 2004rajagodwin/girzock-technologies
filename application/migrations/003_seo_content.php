<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Adds the service content, page SEO and draft articles. Text is in migrations/data/.
 * Existing rows are updated field by field and nothing is deleted. Articles go in as drafts,
 * and SMTP settings, admin accounts, enquiries and uploads are not touched.
 */
class Migration_Seo_content extends CI_Migration {

	private function seo($type, $key, array $row)
	{
		$this->db->query('INSERT INTO seo_metadata (entity_type, entity_key, meta_title, meta_description, focus_keyword, robots)
			VALUES (?, ?, ?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE meta_title = VALUES(meta_title), meta_description = VALUES(meta_description),
			focus_keyword = VALUES(focus_keyword), robots = VALUES(robots)',
			array($type, (string) $key, $row[0], $row[1], isset($row[2]) ? $row[2] : NULL, isset($row[3]) ? $row[3] : NULL));
	}

	private function id_of($table, $slug)
	{
		$row = $this->db->select('id')->get_where($table, array('slug' => $slug), 1)->row_array();
		return $row ? (int) $row['id'] : 0;
	}

	public function up()
	{
		$this->db->trans_start();

		foreach (require APPPATH.'migrations/data/services.php' as $slug => $service)
		{
			$seo = $service['seo'];
			unset($service['seo']);
			$id = $this->id_of('services', $slug);
			if ($id)
			{
				$this->db->where('id', $id)->update('services', $service);
			}
			else
			{
				$service['slug'] = $slug;
				$service['status'] = 'active';
				$this->db->insert('services', $service);
				$id = (int) $this->db->insert_id();
			}
			$this->seo('service', $id, $seo);
		}

		$pages = require APPPATH.'migrations/data/pages.php';
		foreach ($pages['pages'] as $key => $seo)
		{
			$this->seo('page', $key, $seo);
		}
		foreach ($pages['products'] as $slug => $product)
		{
			$id = $this->id_of('products', $slug);
			if ($id)
			{
				$this->db->where('id', $id)->update('products', array('description' => $product['description'], 'features' => $product['features']));
				$this->seo('product', $id, $product['seo']);
			}
		}
		foreach ($pages['case_studies'] as $slug => $seo)
		{
			$id = $this->id_of('case_studies', $slug);
			if ($id)
			{
				$this->seo('case_study', $id, $seo);
			}
		}
		foreach ($pages['careers'] as $slug => $seo)
		{
			$id = $this->id_of('career_openings', $slug);
			if ($id)
			{
				$this->seo('career', $id, $seo);
			}
		}
		foreach ($pages['blog'] as $slug => $seo)
		{
			$id = $this->id_of('blog_posts', $slug);
			if ($id)
			{
				$this->seo('blog', $id, $seo);
			}
		}
		foreach ($pages['blog_categories'] as $slug => $row)
		{
			$id = $this->id_of('blog_categories', $slug);
			if ($id)
			{
				$this->db->where('id', $id)->update('blog_categories', array('description' => $row[1]));
				$this->seo('blog_category', $id, $row[0]);
			}
		}
		// The sample-concept gallery entries are artwork, not client work, so they stay out of search results.
		foreach ($this->db->select('id, title')->get('portfolio_projects')->result_array() as $project)
		{
			$this->seo('portfolio', $project['id'], array(NULL, NULL, NULL, 'noindex, follow'));
		}

		$categories = array();
		foreach ($this->db->get('blog_categories')->result_array() as $row)
		{
			$categories[$row['name']] = (int) $row['id'];
		}
		foreach (require APPPATH.'migrations/data/blog_drafts.php' as $slug => $post)
		{
			if ($this->id_of('blog_posts', $slug))
			{
				continue;
			}
			$words = str_word_count(strip_tags($post['content']));
			$this->db->insert('blog_posts', array(
				'category_id' => isset($categories[$post['category']]) ? $categories[$post['category']] : NULL,
				'author_name' => 'GIRZOCK Team',
				'title' => $post['title'],
				'slug' => $slug,
				'excerpt' => $post['excerpt'],
				'content' => $post['content'],
				'featured_image' => $post['image'],
				'reading_time' => max(1, (int) ceil($words / 200)),
				'status' => 'draft',
			));
			$id = (int) $this->db->insert_id();
			$this->seo('blog', $id, $post['seo']);
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
			show_error('The SEO content migration could not be applied, and no changes were kept.');
		}
	}

	public function down()
	{
		// Content is not removed automatically: an administrator may have edited it since.
	}
}

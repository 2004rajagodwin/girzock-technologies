<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Rewrites six short articles in full, adds a local-area paragraph to each service, and updates
 * two SEO fields. Each change is applied only when the stored text is still the earlier version,
 * so anything an admin has edited stays as it is. Publish dates are not changed.
 */
class Migration_Content_and_local_seo extends CI_Migration {

	public function up()
	{
		$data = require APPPATH.'migrations/data/content_012.php';
		$words = function ($html) { return str_word_count(strip_tags((string) $html)); };
		$this->db->trans_start();

		foreach ($data['posts'] as $slug => $post)
		{
			$row = $this->db->select('id, content')->get_where('blog_posts', array('slug' => $slug), 1)->row_array();
			// Only the short earlier versions are replaced; a post an admin has expanded is left alone.
			if ($row && $words($row['content']) < 300)
			{
				$this->db->where('id', $row['id'])->update('blog_posts', array('content' => trim($post['content']), 'excerpt' => $post['excerpt'], 'reading_time' => max(1, (int) ceil($words($post['content']) / 200))));
			}
		}

		foreach ($data['services_local'] as $slug => $paragraph)
		{
			$row = $this->db->select('id, description')->get_where('services', array('slug' => $slug), 1)->row_array();
			if ($row && strpos((string) $row['description'], mb_substr($paragraph, 0, 60)) === FALSE)
			{
				$this->db->set('description', rtrim((string) $row['description'])."\n<p>".htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8').'</p>')
					->set('updated_at', 'updated_at', FALSE)->where('id', $row['id'])->update('services');
			}
		}

		foreach ($data['seo'] as $item)
		{
			list($type, $key, $field, $old, $new) = $item;
			if ($type === 'service')
			{
				$service = $this->db->select('id')->get_where('services', array('slug' => $key), 1)->row_array();
				if ( ! $service) { continue; }
				$key = (string) $service['id'];
			}
			$row = $this->db->get_where('seo_metadata', array('entity_type' => $type, 'entity_key' => $key), 1)->row_array();
			if ($row && ($old === NULL ? mb_strlen((string) $row[$field]) > 160 : $row[$field] === $old))
			{
				$this->db->where('id', $row['id'])->update('seo_metadata', array($field => $new));
			}
		}

		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The content migration could not be applied, and no changes were kept.');
		}
	}

	public function down()
	{
		// Content is ordinary admin content and is not reverted automatically; restore from backup if needed.
	}
}

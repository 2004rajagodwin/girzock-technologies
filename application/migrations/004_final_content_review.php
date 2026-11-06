<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Final content review: adds image alt text, applies text corrections and publishes five
 * articles. A correction applies only if its original wording is still there, so changes made
 * in the admin panel are kept. An article is published only if it is still a draft.
 */
class Migration_Final_content_review extends CI_Migration {

	public function up()
	{
		if ( ! $this->db->field_exists('featured_image_alt', 'blog_posts'))
		{
			$this->db->query('ALTER TABLE `blog_posts` ADD COLUMN `featured_image_alt` VARCHAR(255) NULL AFTER `featured_image`');
		}
		$data = require APPPATH.'migrations/data/final_updates.php';

		$this->db->trans_start();
		foreach ($data['settings'] as $key => $pair)
		{
			$this->db->where(array('setting_key' => $key, 'setting_value' => $pair[0]))->update('website_settings', array('setting_value' => $pair[1]));
		}

		foreach ($data['services'] as $slug => $patch)
		{
			$row = $this->db->get_where('services', array('slug' => $slug), 1)->row_array();
			if ( ! $row)
			{
				continue;
			}
			$update = array();
			if ( ! empty($patch['replace']))
			{
				foreach ($patch['replace'] as $field => $pair)
				{
					if (strpos((string) $row[$field], $pair[0]) !== FALSE)
					{
						$update[$field] = str_replace($pair[0], $pair[1], $row[$field]);
					}
				}
			}
			if ( ! empty($patch['append']) && strpos((string) $row['description'], $patch['append']) === FALSE)
			{
				$update['description'] = (isset($update['description']) ? $update['description'] : $row['description']).$patch['append'];
			}
			if ($update)
			{
				$this->db->where('id', $row['id'])->update('services', $update);
			}
		}

		foreach ($data['images'] as $slug => $pair)
		{
			$set = array('featured_image_alt' => $pair[1]);
			if ($pair[0] !== NULL)
			{
				$set['featured_image'] = $pair[0];
			}
			$this->db->set('updated_at', 'updated_at', FALSE)->where('slug', $slug)->update('blog_posts', $set);
		}

		$minutes = 0;
		foreach ($data['publish'] as $slug => $patch)
		{
			$post = $this->db->get_where('blog_posts', array('slug' => $slug, 'status' => 'draft'), 1)->row_array();
			if ( ! $post)
			{
				continue;
			}
			$content = $post['content'];
			foreach (isset($patch['replace']) ? $patch['replace'] : array() as $old => $new)
			{
				$content = str_replace($old, $new, $content);
			}
			$faq = '<h2>Frequently asked questions</h2>';
			if (strpos($content, $faq) !== FALSE)
			{
				$content = str_replace($faq, $patch['insert_before_faq']."\n".$faq, $content);
				$last = strrpos($content, '<p><strong>');
				if ($last !== FALSE)
				{
					$content = substr($content, 0, $last).$patch['extra_faq'].substr($content, $last);
				}
			}
			$set = array(
				'content' => $content,
				'featured_image_alt' => $patch['alt'],
				'reading_time' => max(1, (int) ceil(str_word_count(strip_tags($content)) / 200)),
				'status' => 'published',
				'published_at' => date('Y-m-d H:i:s', time() - 60 * $minutes),
			);
			if ( ! empty($patch['image']))
			{
				$set['featured_image'] = $patch['image'];
			}
			$this->db->where('id', $post['id'])->update('blog_posts', $set);
			$minutes++;
		}
		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The content review migration could not be applied, and no changes were kept.');
		}
	}

	public function down()
	{
		// Published articles and corrected text are not reverted automatically.
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Secondary keywords for planning in the admin. They are not published on the pages.
 * Filled only where the field is empty, so values entered in the admin are kept.
 */
class Migration_Secondary_keywords extends CI_Migration {

	public function up()
	{
		$data = require APPPATH.'migrations/data/keywords_016.php';
		$tables = array('service' => 'services', 'product' => 'products', 'career' => 'career_openings', 'case_study' => 'case_studies', 'blog' => 'blog_posts');
		foreach ($data as $type => $items)
		{
			foreach ($items as $slug => $keywords)
			{
				$key = $slug;
				if (isset($tables[$type]))
				{
					$row = $this->db->select('id')->get_where($tables[$type], array('slug' => $slug), 1)->row_array();
					if ( ! $row)
					{
						continue;
					}
					$key = (string) $row['id'];
				}
				$this->db->query('INSERT IGNORE INTO seo_metadata (entity_type, entity_key) VALUES (?, ?)', array($type, $key));
				$this->db->query("UPDATE seo_metadata SET secondary_keywords = ? WHERE entity_type = ? AND entity_key = ? AND (secondary_keywords IS NULL OR secondary_keywords = '')", array($keywords, $type, $key));
			}
		}
	}

	public function down()
	{
		// Planning data only; restore a backup to undo.
	}
}

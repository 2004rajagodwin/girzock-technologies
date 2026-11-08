<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fuller product pages and job role details. A product description is replaced only while it is still the short
 * original (under 120 words), and a job field only while it is empty, so admin edits are never overwritten.
 * Update dates are kept.
 */
class Migration_Product_and_career_content extends CI_Migration {

	public function up()
	{
		$data = require APPPATH.'migrations/data/content_015.php';
		$words = function ($html) { return str_word_count(strip_tags((string) $html)); };
		$this->db->trans_start();

		foreach ($data['products'] as $slug => $html)
		{
			$row = $this->db->select('id, description')->get_where('products', array('slug' => $slug), 1)->row_array();
			if ($row && $words($row['description']) < 120)
			{
				$this->db->set('description', trim($html))->set('updated_at', 'updated_at', FALSE)->where('id', $row['id'])->update('products');
			}
		}

		foreach ($data['careers'] as $slug => $fields)
		{
			$row = $this->db->select('id, description, responsibilities')->get_where('career_openings', array('slug' => $slug), 1)->row_array();
			if ( ! $row)
			{
				continue;
			}
			foreach ($fields as $column => $value)
			{
				if (trim((string) $row[$column]) === '')
				{
					$this->db->set($column, trim($value))->set('updated_at', 'updated_at', FALSE)->where('id', $row['id'])->update('career_openings');
				}
			}
		}

		$this->db->trans_complete();
	}

	public function down()
	{
		// Content is not reverted; restore a backup to undo.
	}
}

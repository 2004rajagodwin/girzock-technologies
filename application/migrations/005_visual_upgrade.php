<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Points services, published articles and case studies at the original WebP illustrations in
 * assets/images/generated. A file an admin uploaded is never replaced, drafts are left alone,
 * and modified dates do not change because the wording has not. Earlier images stay on disk.
 */
class Migration_Visual_upgrade extends CI_Migration {

	public function up()
	{
		if ( ! $this->db->field_exists('detail_image', 'services'))
		{
			$this->db->query('ALTER TABLE `services` ADD COLUMN `detail_image` VARCHAR(255) NULL AFTER `image`, ADD COLUMN `detail_image_alt` VARCHAR(255) NULL AFTER `detail_image`');
		}
		if ( ! $this->db->field_exists('image_alt', 'case_studies'))
		{
			$this->db->query('ALTER TABLE `case_studies` ADD COLUMN `image_alt` VARCHAR(255) NULL AFTER `image`');
		}

		$G = 'assets/images/generated/';
		$data = require APPPATH.'migrations/data/visual_upgrade.php';
		$this->db->trans_start();

		foreach ($data['services'] as $slug => $alt)
		{
			$file = $slug.'.webp';
			$this->db->set('updated_at', 'updated_at', FALSE)->where('slug', $slug)
				->update('services', array('detail_image' => $G.'services/'.$file, 'detail_image_alt' => $alt));
			$this->db->set('updated_at', 'updated_at', FALSE)->where('slug', $slug)->not_like('menu_image', 'assets/uploads/', 'after')
				->update('services', array('menu_image' => $G.'menu/'.$file));
		}
		foreach ($data['blog'] as $slug => $item)
		{
			$this->db->set('updated_at', 'updated_at', FALSE)
				->where(array('slug' => $slug, 'status' => 'published'))->not_like('featured_image', 'assets/uploads/', 'after')
				->update('blog_posts', array('featured_image' => $G.'blog/'.$item[0].'.webp', 'featured_image_alt' => $item[1]));
		}
		foreach ($data['case_studies'] as $slug => $item)
		{
			$this->db->set('updated_at', 'updated_at', FALSE)->where('slug', $slug)->where('image IS NULL', NULL, FALSE)
				->update('case_studies', array('image' => $G.'case-studies/'.$item[0].'.webp', 'image_alt' => $item[1]));
		}

		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The visual upgrade migration could not be applied.');
		}
	}

	public function down()
	{
		// Image choices are not reverted automatically. The earlier files remain on disk.
	}
}

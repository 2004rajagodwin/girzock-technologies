<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Points published articles, case studies and portfolio items at realistic WebP images. Admin
 * uploads and drafts are left alone, wording and modified dates do not change, and the earlier
 * image files stay on disk.
 */
class Migration_Realistic_content_images extends CI_Migration {

	public function up()
	{
		$data = require APPPATH.'migrations/data/realistic_images.php';
		$P = 'assets/images/generated/photo/';
		$this->db->trans_start();

		foreach ($data['blog'] as $slug => $item)
		{
			$this->db->set('updated_at', 'updated_at', FALSE)
				->where(array('slug' => $slug, 'status' => 'published'))->not_like('featured_image', 'assets/uploads/', 'after')
				->update('blog_posts', array('featured_image' => $P.'blog/'.$item[0].'.webp', 'featured_image_alt' => $item[1]));
		}
		foreach ($data['case'] as $slug => $item)
		{
			$this->db->set('updated_at', 'updated_at', FALSE)
				->where('slug', $slug)->where("(image IS NULL OR image NOT LIKE 'assets/uploads/%')", NULL, FALSE)
				->update('case_studies', array('image' => $P.'case-studies/'.$item[0].'.webp', 'image_alt' => $item[1]));
		}
		foreach ($data['port'] as $slug => $item)
		{
			$this->db->set('updated_at', 'updated_at', FALSE)
				->where('slug', $slug)->where("(image IS NULL OR image NOT LIKE 'assets/uploads/%')", NULL, FALSE)
				->update('portfolio_projects', array('image' => $P.'portfolio/'.$item[0].'.webp', 'image_alt' => $item[1]));
		}

		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The image migration could not be applied, and no changes were kept.');
		}
	}

	public function down()
	{
		// Image choices are not reverted automatically. The earlier files remain on disk.
	}
}

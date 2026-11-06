<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Points services, published articles and three portfolio items at the corporate-style WebP
 * images, and gives the sample portfolio items clearer descriptions. Admin uploads and edited
 * wording are kept, modified dates of articles do not change, and earlier files stay on disk.
 */
class Migration_Professional_images extends CI_Migration {

	public function up()
	{
		$data = require APPPATH.'migrations/data/professional_images.php';
		$P = 'assets/images/generated/pro/';
		$this->db->trans_start();

		foreach ($data['services'] as $slug => $alt)
		{
			$this->db->where('slug', $slug)->not_like('menu_image', 'assets/uploads/', 'after')->update('services', array('menu_image' => $P.'menu/'.$slug.'.webp'));
			$this->db->where('slug', $slug)->where("(detail_image IS NULL OR detail_image NOT LIKE 'assets/uploads/%')", NULL, FALSE)
				->update('services', array('detail_image' => $P.'services/'.$slug.'.webp', 'detail_image_alt' => $alt));
		}
		foreach ($data['blog'] as $slug => $item)
		{
			$this->db->set('updated_at', 'updated_at', FALSE)
				->where(array('slug' => $slug, 'status' => 'published'))->not_like('featured_image', 'assets/uploads/', 'after')
				->update('blog_posts', array('featured_image' => $P.'blog/'.$item[0].'.webp', 'featured_image_alt' => $item[1]));
		}
		foreach ($data['portfolio'] as $slug => $item)
		{
			$this->db->where('slug', $slug)->where("(image IS NULL OR image NOT LIKE 'assets/uploads/%')", NULL, FALSE)
				->update('portfolio_projects', array('image' => $P.'portfolio/'.$item[0].'.webp', 'image_alt' => $item[1]));
		}
		foreach ($data['descriptions'] as $slug => $pair)
		{
			$this->db->where(array('slug' => $slug, 'short_description' => $pair[0]))->update('portfolio_projects', array('short_description' => $pair[1]));
		}

		$this->db->where(array('setting_key' => 'portfolio_intro', 'setting_value' => 'The gallery above uses sample concept artwork. Finished client work will be added here as projects are completed and approved for publication.'))
			->update('website_settings', array('setting_value' => 'The projects below are sample concepts, not client work. Finished client work will be added here as projects are completed and approved for publication.'));

		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The image migration could not be applied, and no changes were kept.');
		}
	}

	public function down()
	{
		// Not reverted automatically. Earlier image files remain on disk.
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SEO: a secondary keywords field for every editable page, the homepage sharing and keyword values supplied by
 * the owner, and the Google Search Console verification code. Existing values are never overwritten.
 */
class Migration_Seo_fields_and_home_meta extends CI_Migration {

	const HOME_KEYWORDS = 'GIRZOCK Technologies, Software Development Company in Tirunelveli, Software Company in Tirunelveli, IT Company in Tirunelveli, Web Design Company in Tirunelveli, Web Development Company in Tirunelveli, Website Development in Thisaiyanvilai, Software Company in Thisaiyanvilai, Web Designer in Tirunelveli, Website Design Services, Custom Software Development, Web Application Development, E Commerce Website Development, Responsive Website Design, UI UX Design, Cloud Computing Services, Cloud Application Development, AWS Cloud Services, Cloud Infrastructure Solutions, Cloud Hosting, Cloud Integration, Cloud Deployment, Digital Transformation, IT Services Tamil Nadu';

	public function up()
	{
		if ( ! $this->db->field_exists('secondary_keywords', 'seo_metadata'))
		{
			$this->db->query("ALTER TABLE seo_metadata ADD COLUMN secondary_keywords VARCHAR(255) NULL DEFAULT NULL AFTER focus_keyword");
		}

		$settings = array(
			array('home_meta_keywords', self::HOME_KEYWORDS),
			array('home_twitter_title', 'GIRZOCK Technologies | Software Development Company'),
			array('home_twitter_description', 'Website design, software development, cloud computing and digital technology solutions in Tirunelveli, Tamil Nadu.'),
			array('home_og_image_alt', 'GIRZOCK Technologies - Software, Web and Cloud Solutions'),
			array('gsc_verification', ''),
		);
		foreach ($settings as $row)
		{
			$this->db->query('INSERT IGNORE INTO website_settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?)', array($row[0], $row[1], 'seo'));
		}
		// The verification code is filled only when the field is still empty.
		$this->db->query("UPDATE website_settings SET setting_value = '8mvLPVKKdyFGhXsKoEhxiRoLyld5UB7bXjEaqObcjRI' WHERE setting_key = 'gsc_verification' AND (setting_value IS NULL OR setting_value = '')");

		// Homepage sharing values, only where nothing has been entered yet.
		$this->db->query("INSERT IGNORE INTO seo_metadata (entity_type, entity_key) VALUES ('page', 'home')");
		$home = array(
			'og_title' => 'GIRZOCK Technologies | Software, Web & Cloud Solutions',
			'og_description' => 'Explore professional software development, website design, web applications, cloud computing and AWS solutions from GIRZOCK Technologies in Tirunelveli and Thisaiyanvilai, Tamil Nadu.',
			'og_image' => 'girzock-hero.png',
			'secondary_keywords' => 'software company in Tirunelveli, web development company in Tirunelveli, website development in Thisaiyanvilai, custom software development Tamil Nadu',
		);
		foreach ($home as $column => $value)
		{
			$this->db->query("UPDATE seo_metadata SET $column = ? WHERE entity_type = 'page' AND entity_key = 'home' AND ($column IS NULL OR $column = '')", array($value));
		}
	}

	public function down()
	{
		// Content is not reverted; restore a backup to undo.
	}
}

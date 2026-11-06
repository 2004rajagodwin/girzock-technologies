<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Adds the focus keyword and Open Graph fields, and the sections of a service detail page. */
class Migration_Seo_fields_and_service_sections extends CI_Migration {

	private $seo = array(
		'focus_keyword' => "VARCHAR(120) NULL AFTER `meta_description`",
		'og_title' => "VARCHAR(255) NULL AFTER `focus_keyword`",
		'og_description' => "VARCHAR(500) NULL AFTER `og_title`",
	);

	private $services = array(
		'headline' => "VARCHAR(200) NULL AFTER `short_description`",
		'problems' => "TEXT NULL AFTER `description`",
		'benefits' => "TEXT NULL AFTER `problems`",
		'workflow' => "TEXT NULL AFTER `benefits`",
		'use_cases' => "TEXT NULL AFTER `workflow`",
		'faqs' => "TEXT NULL AFTER `use_cases`",
		'cta_text' => "VARCHAR(300) NULL AFTER `faqs`",
		'related_services' => "VARCHAR(500) NULL AFTER `cta_text`",
	);

	public function up()
	{
		foreach (array('seo_metadata' => $this->seo, 'services' => $this->services) as $table => $columns)
		{
			foreach ($columns as $name => $definition)
			{
				if ( ! $this->db->field_exists($name, $table))
				{
					$this->db->query("ALTER TABLE `$table` ADD COLUMN `$name` $definition");
				}
			}
		}
	}

	public function down()
	{
		foreach (array('seo_metadata' => $this->seo, 'services' => $this->services) as $table => $columns)
		{
			foreach (array_keys($columns) as $name)
			{
				if ($this->db->field_exists($name, $table))
				{
					$this->db->query("ALTER TABLE `$table` DROP COLUMN `$name`");
				}
			}
		}
	}
}

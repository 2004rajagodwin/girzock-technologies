<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Baseline. A fresh install imports database/girzock_technologies.sql, which already records
 * this version. This migration exists so an empty database can also be built with
 * "php index.php setup migrate". Add later schema changes as 002_*.php, 003_*.php and so on,
 * and raise migration_version in config/migration.php.
 */
class Migration_Initial_schema extends CI_Migration {

	public function up()
	{
		if ($this->db->table_exists('admin_users'))
		{
			return;
		}
		$sql = preg_replace('/^\s*--.*$/m', '', file_get_contents(FCPATH.'database/schema.sql'));
		foreach (array_filter(array_map('trim', explode(";\n", str_replace("\r\n", "\n", $sql)))) as $statement)
		{
			$this->db->query($statement);
		}
	}

	public function down()
	{
		// The baseline is never rolled back automatically: that would destroy live data.
	}
}

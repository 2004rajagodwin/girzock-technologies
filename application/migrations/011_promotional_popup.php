<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings for the promotional popup, stored in website_settings with the other site settings.
 * Only missing keys are added, so running this again never overwrites what an admin has saved.
 */
class Migration_Promotional_popup extends CI_Migration {

	public function up()
	{
		$this->load->model('settings_model');
		$sql = 'INSERT IGNORE INTO website_settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?)';
		foreach (Settings_model::popup_defaults() as $key => $value)
		{
			$this->db->query($sql, array($key, $value, 'popup'));
		}
	}

	public function down()
	{
		// Settings are ordinary admin content and are not removed automatically.
	}
}

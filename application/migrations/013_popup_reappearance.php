<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Popup reappearance settings: how the popup behaves after a visitor closes it or sends the form.
 * Only missing keys are added. The older frequency setting is no longer used and is left in place.
 */
class Migration_Popup_reappearance extends CI_Migration {

	public function up()
	{
		$sql = 'INSERT IGNORE INTO website_settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?)';
		foreach (array('popup_reappear' => 'days', 'popup_dismiss_days' => '7', 'popup_submit_days' => '30', 'popup_visitor_version' => '1') as $key => $value)
		{
			$this->db->query($sql, array($key, $value, 'popup'));
		}
	}

	public function down()
	{
		// Settings are ordinary admin content and are not removed automatically.
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Website settings, social links, SEO metadata and the service lists used by the shared
 * header and footer. Each list is read once per request.
 */
class Settings_model extends CI_Model {

	/** Settings that may never be shown to a browser, including in the admin panel. */
	const SECRET_KEYS = array('smtp_password');

	private $settings = NULL;
	private $socials = NULL;
	private $services = NULL;

	public function __construct()
	{
		parent::__construct();
		// created_at defaults come from the database clock, so it must agree with PHP.
		$this->db->query("SET time_zone = ?", array(date("P")));
	}

	public function all()
	{
		if ($this->settings === NULL)
		{
			$this->settings = array();
			foreach ($this->db->get('website_settings')->result_array() as $row)
			{
				$this->settings[$row['setting_key']] = $row['setting_value'];
			}
		}
		return $this->settings;
	}

	/** Settings of the promotional popup, as first installed and as restored by Reset. */
	public static function popup_defaults()
	{
		return array(
			'popup_enabled' => '1',
			'popup_title' => 'Send Us a Message',
			'popup_description' => 'Fill out the form below and we\'ll get back to you as soon as possible.',
			'popup_image_alt' => 'GIRZOCK Technologies Diwali offer: 20% off website, software and CRM tools',
			'popup_delay' => '5',
			'popup_reappear' => 'days',
			'popup_dismiss_days' => '7',
			'popup_submit_days' => '30',
			'popup_visitor_version' => '1',
			'popup_start_date' => '',
			'popup_end_date' => '',
			'popup_show_desktop' => '1',
			'popup_show_mobile' => '1',
			'popup_desktop_image' => 'assets/images/popup/diwalipopup-left-desktop.webp',
			'popup_mobile_image' => 'assets/images/popup/diwalipopup-mobile.webp',
		);
	}

	/**
	 * What the popup needs on a public page, or NULL when it should not appear.
	 * @param bool $preview an admin preview ignores the on/off switch and the dates
	 */
	public function popup($preview = FALSE)
	{
		$all = $this->all();
		if ( ! array_key_exists('popup_enabled', $all))
		{
			return NULL;
		}
		if ( ! $preview)
		{
			$today = date('Y-m-d');
			$start = $this->get('popup_start_date');
			$end = $this->get('popup_end_date');
			if ($all['popup_enabled'] !== '1' OR ($start !== '' && $today < $start) OR ($end !== '' && $today > $end))
			{
				return NULL;
			}
		}
		$image = function ($key) {
			$path = $this->get($key);
			$file = FCPATH.ltrim($path, '/');
			$info = ($path !== '' && strpos($path, '..') === FALSE && is_file($file)) ? @getimagesize($file) : FALSE;
			return $info ? array('url' => base_url($path).'?v='.filemtime($file), 'width' => $info[0], 'height' => $info[1]) : array('url' => '', 'width' => 0, 'height' => 0);
		};
		return array(
			'title' => $this->get('popup_title', 'Send Us a Message'),
			'description' => $this->get('popup_description'),
			'alt' => $this->get('popup_image_alt'),
			'delay' => (int) $this->get('popup_delay', '5'),
			'reappear' => $this->get('popup_reappear', 'days'),
			'dismiss_days' => (int) $this->get('popup_dismiss_days', '7'),
			'submit_days' => (int) $this->get('popup_submit_days', '30'),
			'version' => $this->get('popup_visitor_version', '1'),
			'show_desktop' => $this->get('popup_show_desktop') === '1',
			'show_mobile' => $this->get('popup_show_mobile') === '1',
			'desktop' => $image('popup_desktop_image'),
			'mobile' => $image('popup_mobile_image'),
			'preview' => (bool) $preview,
		);
	}

	public function get($key, $default = '')
	{
		$all = $this->all();
		return (isset($all[$key]) && $all[$key] !== '') ? $all[$key] : $default;
	}

	public function save_many(array $values, $group = 'general')
	{
		$this->db->trans_start();
		foreach ($values as $key => $value)
		{
			$sql = 'INSERT INTO website_settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?)
				ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)';
			$this->db->query($sql, array($key, $value, $group));
		}
		$this->db->trans_complete();
		$this->settings = NULL;
		return $this->db->trans_status();
	}

	public function socials()
	{
		if ($this->socials === NULL)
		{
			$this->socials = $this->db->order_by('sort_order', 'ASC')->get('social_links')->result_array();
		}
		return $this->socials;
	}

	/** Only the profiles with a valid address, in display order. Used by the footer and the structured data. */
	public function public_socials()
	{
		return array_values(array_filter($this->socials(), function ($link) {
			return valid_social_url($link['platform'], $link['url']);
		}));
	}

	public function social_url($platform)
	{
		foreach ($this->public_socials() as $link)
		{
			if ($link['platform'] === $platform)
			{
				return (string) $link['url'];
			}
		}
		return '';
	}

	public function save_social($platform, $url)
	{
		$this->db->where('platform', $platform)->update('social_links', array('url' => $url === '' ? NULL : $url));
		$this->socials = NULL;
	}

	public function active_services()
	{
		if ($this->services === NULL)
		{
			$this->services = $this->db->where('status', 'active')->where('deleted_at IS NULL', NULL, FALSE)
				->order_by('page_order', 'ASC')->get('services')->result_array();
		}
		return $this->services;
	}

	/** Active services with a positive value in an ordering column (menu_order, footer_order...). */
	public function services_by($order_column)
	{
		$list = array_values(array_filter($this->active_services(), function ($row) use ($order_column) {
			return (int) $row[$order_column] > 0;
		}));
		usort($list, function ($a, $b) use ($order_column) {
			return (int) $a[$order_column] - (int) $b[$order_column];
		});
		return $list;
	}

	/**
	 * Names for the enquiry and contact forms: every active service, so a new one appears without
	 * further setup. Ordered services come first; a repeated name is listed once.
	 */
	public function form_services()
	{
		$list = $this->active_services();
		usort($list, function ($a, $b) {
			$x = (int) $a['form_order'] > 0 ? (int) $a['form_order'] : PHP_INT_MAX;
			$y = (int) $b['form_order'] > 0 ? (int) $b['form_order'] : PHP_INT_MAX;
			return $x === $y ? strcasecmp($a['title'], $b['title']) : $x - $y;
		});
		$labels = array();
		foreach ($list as $service)
		{
			$label = trim((string) ($service['form_label'] ? $service['form_label'] : $service['title']));
			$labels[mb_strtolower($label)] = isset($labels[mb_strtolower($label)]) ? $labels[mb_strtolower($label)] : $label;
		}
		return array_values($labels);
	}

	public function seo($entity_type, $entity_key)
	{
		$row = $this->db->get_where('seo_metadata', array('entity_type' => $entity_type, 'entity_key' => (string) $entity_key), 1)->row_array();
		return $row ? $row : array();
	}

	public function save_seo($entity_type, $entity_key, array $data)
	{
		$sql = 'INSERT INTO seo_metadata (entity_type, entity_key, meta_title, meta_description, focus_keyword, og_title, og_description, canonical_url, og_image, robots)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE meta_title = VALUES(meta_title), meta_description = VALUES(meta_description),
			focus_keyword = VALUES(focus_keyword), og_title = VALUES(og_title), og_description = VALUES(og_description),
			canonical_url = VALUES(canonical_url), og_image = VALUES(og_image), robots = VALUES(robots)';
		return $this->db->query($sql, array(
			$entity_type, (string) $entity_key,
			$this->nullable($data, 'meta_title'), $this->nullable($data, 'meta_description'),
			$this->nullable($data, 'focus_keyword'), $this->nullable($data, 'og_title'), $this->nullable($data, 'og_description'),
			$this->nullable($data, 'canonical_url'), $this->nullable($data, 'og_image'), $this->nullable($data, 'robots'),
		));
	}

	private function nullable(array $data, $key)
	{
		return (isset($data[$key]) && trim($data[$key]) !== '') ? trim($data[$key]) : NULL;
	}

	/** Records that a public path moved, and repoints earlier redirects to avoid chains. */
	public function add_redirect($old_path, $new_path, $code = 301)
	{
		$old_path = trim($old_path, '/');
		$new_path = $new_path === NULL ? NULL : trim($new_path, '/');
		if ($old_path === $new_path)
		{
			return;
		}
		$this->db->where('old_path', $new_path)->delete('url_redirects');
		if ($new_path !== NULL)
		{
			$this->db->where('new_path', $old_path)->update('url_redirects', array('new_path' => $new_path));
		}
		$sql = 'INSERT INTO url_redirects (old_path, new_path, status_code) VALUES (?, ?, ?)
			ON DUPLICATE KEY UPDATE new_path = VALUES(new_path), status_code = VALUES(status_code)';
		$this->db->query($sql, array($old_path, $new_path, (int) $code));
	}

	public function find_redirect($path)
	{
		return $this->db->get_where('url_redirects', array('old_path' => trim($path, '/')), 1)->row_array();
	}

	public function log_activity($admin_id, $module, $action, $entity_id = NULL, $description = NULL)
	{
		$this->db->insert('activity_logs', array(
			'admin_id' => $admin_id ? (int) $admin_id : NULL,
			'module' => $module,
			'action' => $action,
			'entity_id' => $entity_id ? (int) $entity_id : NULL,
			'description' => $description === NULL ? NULL : mb_substr($description, 0, 255),
			'ip_address' => $this->input->ip_address(),
		));
	}

	/** Sliding-window limiter for public forms. Returns FALSE once the limit is reached. */
	public function throttle($scope, $limit, $window_seconds)
	{
		$ip = $this->input->ip_address();
		$since = date('Y-m-d H:i:s', time() - $window_seconds);
		$this->db->where('created_at <', date('Y-m-d H:i:s', time() - 86400))->delete('submission_throttle');
		$count = $this->db->where(array('scope' => $scope, 'ip_address' => $ip, 'created_at >=' => $since))->count_all_results('submission_throttle');
		if ($count >= $limit)
		{
			return FALSE;
		}
		$this->db->insert('submission_throttle', array('scope' => $scope, 'ip_address' => $ip));
		return TRUE;
	}
}

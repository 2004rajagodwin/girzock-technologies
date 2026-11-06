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

	public function social_url($platform)
	{
		foreach ($this->socials() as $link)
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

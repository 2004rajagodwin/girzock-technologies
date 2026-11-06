<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

	protected $table = 'admin_users';
	protected $search_columns = array('admin_users.username', 'admin_users.full_name', 'admin_users.email');
	protected $default_order = array('admin_users.created_at' => 'ASC');

	public function list_filtered(array $filters, $limit, $offset)
	{
		$this->db->select('admin_users.*, admin_roles.name AS role_name, admin_roles.slug AS role_slug')
			->join('admin_roles', 'admin_roles.id = admin_users.role_id');
		return parent::list_filtered($filters, $limit, $offset);
	}

	public function find_with_role($id)
	{
		$row = $this->db->select('admin_users.*, admin_roles.name AS role_name, admin_roles.slug AS role_slug')
			->join('admin_roles', 'admin_roles.id = admin_users.role_id')
			->where('admin_users.deleted_at IS NULL', NULL, FALSE)
			->where('admin_users.id', (int) $id)->get($this->table, 1)->row_array();
		return $row ? $row : NULL;
	}

	/** Finds an account by username or email. */
	public function find_for_login($identifier)
	{
		$row = $this->db->where('deleted_at IS NULL', NULL, FALSE)
			->group_start()->where('username', $identifier)->or_where('email', $identifier)->group_end()
			->get($this->table, 1)->row_array();
		return $row ? $row : NULL;
	}

	public function is_taken($column, $value, $ignore_id = NULL)
	{
		$this->db->where($column, $value);
		if ($ignore_id)
		{
			$this->db->where('id !=', (int) $ignore_id);
		}
		return $this->db->count_all_results($this->table) > 0;
	}

	public function active_options()
	{
		return $this->db->select('id, full_name')->where('deleted_at IS NULL', NULL, FALSE)->where('status', 'active')
			->order_by('full_name', 'ASC')->get($this->table)->result_array();
	}

	public function active_super_admin_count()
	{
		return (int) $this->db->join('admin_roles', 'admin_roles.id = admin_users.role_id')
			->where('admin_roles.slug', 'super_admin')->where('admin_users.status', 'active')
			->where('admin_users.deleted_at IS NULL', NULL, FALSE)->count_all_results($this->table);
	}

	/* ---------- roles and permissions ---------- */

	public function roles()
	{
		return $this->db->order_by('id', 'ASC')->get('admin_roles')->result_array();
	}

	public function role($id)
	{
		$row = $this->db->get_where('admin_roles', array('id' => (int) $id), 1)->row_array();
		return $row ? $row : NULL;
	}

	public function permissions_for_role($role_id)
	{
		$out = array();
		foreach ($this->db->get_where('admin_permissions', array('role_id' => (int) $role_id))->result_array() as $row)
		{
			$out[$row['module']] = $row;
		}
		return $out;
	}

	public function save_permissions($role_id, array $matrix, array $modules)
	{
		$this->db->trans_start();
		$this->db->where('role_id', (int) $role_id)->delete('admin_permissions');
		foreach ($modules as $module => $label)
		{
			$flags = isset($matrix[$module]) && is_array($matrix[$module]) ? $matrix[$module] : array();
			$this->db->insert('admin_permissions', array(
				'role_id' => (int) $role_id, 'module' => $module,
				'can_view' => empty($flags['view']) ? 0 : 1, 'can_create' => empty($flags['create']) ? 0 : 1,
				'can_edit' => empty($flags['edit']) ? 0 : 1, 'can_delete' => empty($flags['delete']) ? 0 : 1,
			));
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	/* ---------- login attempts ---------- */

	public function failures_since($identifier, $ip, $since)
	{
		$by_pair = (int) $this->db->where(array('identifier' => $identifier, 'ip_address' => $ip, 'success' => 0, 'attempted_at >=' => $since))->count_all_results('login_attempts');
		$by_ip = (int) $this->db->where(array('ip_address' => $ip, 'success' => 0, 'attempted_at >=' => $since))->count_all_results('login_attempts');
		return array($by_pair, $by_ip);
	}

	public function record_attempt($identifier, $ip, $success)
	{
		$this->db->insert('login_attempts', array('identifier' => mb_substr($identifier, 0, 190), 'ip_address' => $ip, 'success' => $success ? 1 : 0));
		if ($success)
		{
			$this->db->where(array('identifier' => $identifier, 'ip_address' => $ip, 'success' => 0))->delete('login_attempts');
		}
		$this->db->where('attempted_at <', date('Y-m-d H:i:s', time() - 2592000))->delete('login_attempts');
	}

	/* ---------- password resets ---------- */

	public function create_reset($user_id, $ip)
	{
		$token = bin2hex(random_bytes(32));
		$this->db->where(array('user_id' => (int) $user_id))->where('used_at IS NULL', NULL, FALSE)->delete('password_resets');
		$this->db->insert('password_resets', array(
			'user_id' => (int) $user_id, 'token_hash' => hash('sha256', $token),
			'expires_at' => date('Y-m-d H:i:s', time() + 3600), 'request_ip' => $ip,
		));
		return $token;
	}

	public function find_valid_reset($token)
	{
		if ( ! preg_match('/^[a-f0-9]{64}$/', (string) $token))
		{
			return NULL;
		}
		$row = $this->db->where('token_hash', hash('sha256', $token))->where('used_at IS NULL', NULL, FALSE)
			->where('expires_at >', date('Y-m-d H:i:s'))->get('password_resets', 1)->row_array();
		return $row ? $row : NULL;
	}

	public function set_password($user_id, $password, $must_change = 0)
	{
		return $this->db->where('id', (int) $user_id)->update($this->table, array(
			'password_hash' => password_hash($password, PASSWORD_DEFAULT),
			'must_change_password' => (int) $must_change,
			'password_changed_at' => date('Y-m-d H:i:s'),
		));
	}

	public function complete_reset($reset, $password)
	{
		$this->db->trans_start();
		$this->set_password($reset['user_id'], $password, 0);
		$this->db->where('id', (int) $reset['id'])->update('password_resets', array('used_at' => date('Y-m-d H:i:s')));
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Admin authentication, rate limiting and role-based permissions. */
class Admin_auth {

	const LOCKED = 'locked';
	const FAILED = 'failed';
	const OK = 'ok';

	private $CI;
	private $user = NULL;
	private $permissions = NULL;
	private $resolved = FALSE;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->model('user_model');
		$this->CI->config->load('girzock', FALSE, TRUE);
	}

	public function attempt($identifier, $password)
	{
		$identifier = mb_substr(trim((string) $identifier), 0, 190);
		$ip = $this->CI->input->ip_address();
		$since = date('Y-m-d H:i:s', time() - (int) $this->CI->config->item('gz_login_window'));
		list($pair, $by_ip) = $this->CI->user_model->failures_since($identifier, $ip, $since);
		if ($pair >= $this->CI->config->item('gz_login_max_failures') OR $by_ip >= $this->CI->config->item('gz_login_max_ip_failures'))
		{
			return self::LOCKED;
		}

		$user = $identifier === '' ? NULL : $this->CI->user_model->find_for_login($identifier);
		// Verify against a dummy hash when the account is missing, so response time reveals nothing.
		$hash = $user ? $user['password_hash'] : '$2y$10$usesomesillystringforeKBK5OEnbqW1Xj3n3wHsT5EnE/bpP6fHe';
		$valid = password_verify((string) $password, $hash);

		if ( ! $user OR ! $valid OR $user['status'] !== 'active')
		{
			$this->CI->user_model->record_attempt($identifier, $ip, FALSE);
			return self::FAILED;
		}

		$this->CI->user_model->record_attempt($identifier, $ip, TRUE);
		if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT))
		{
			$this->CI->user_model->update_by_id($user['id'], array('password_hash' => password_hash((string) $password, PASSWORD_DEFAULT)));
		}
		$this->CI->user_model->update_by_id($user['id'], array('last_login_at' => date('Y-m-d H:i:s'), 'last_login_ip' => $ip));
		$this->establish($user['id']);
		$this->CI->settings_model->log_activity($user['id'], 'auth', 'login', $user['id'], 'Signed in');
		return self::OK;
	}

	/** New session ID, tied to the current password so a password change ends other sessions. */
	public function establish($user_id)
	{
		$this->CI->session->sess_regenerate(TRUE);
		$fresh = $this->CI->user_model->find($user_id);
		$this->CI->session->set_userdata(array('gz_admin_id' => (int) $user_id, 'gz_pw_stamp' => hash('sha256', $fresh['password_hash'])));
		$this->resolved = FALSE;
		$this->permissions = NULL;
	}

	public function logout()
	{
		$this->CI->session->unset_userdata(array('gz_admin_id', 'gz_pw_stamp'));
		$this->CI->session->sess_destroy();
		$this->user = NULL;
		$this->resolved = TRUE;
	}

	public function user()
	{
		if ($this->resolved)
		{
			return $this->user;
		}
		$this->resolved = TRUE;
		$this->user = NULL;
		$id = $this->CI->session->userdata('gz_admin_id');
		if ( ! $id)
		{
			return NULL;
		}
		$user = $this->CI->user_model->find_with_role($id);
		if ( ! $user OR $user['status'] !== 'active' OR ! hash_equals((string) $this->CI->session->userdata('gz_pw_stamp'), hash('sha256', $user['password_hash'])))
		{
			$this->logout();
			return NULL;
		}
		$this->user = $user;
		return $user;
	}

	public function is_super()
	{
		$user = $this->user();
		return $user && $user['role_slug'] === 'super_admin';
	}

	/** @param string $action view, create, edit or delete */
	public function can($module, $action = 'view')
	{
		$user = $this->user();
		if ( ! $user)
		{
			return FALSE;
		}
		if ($user['role_slug'] === 'super_admin')
		{
			return TRUE;
		}
		if ($this->permissions === NULL)
		{
			$this->permissions = $this->CI->user_model->permissions_for_role($user['role_id']);
		}
		return ! empty($this->permissions[$module]['can_'.$action]);
	}

	/** At least 12 characters, with a letter and a digit. Returns an error message or NULL. */
	public function password_problem($password, $username = '')
	{
		if (strlen((string) $password) < 12)
		{
			return 'The password must be at least 12 characters long.';
		}
		if (strlen((string) $password) > 200)
		{
			return 'The password is too long.';
		}
		if ( ! preg_match('/[A-Za-z]/', $password) OR ! preg_match('/[0-9]/', $password))
		{
			return 'The password must contain at least one letter and one number.';
		}
		if ($username !== '' && stripos($password, $username) !== FALSE)
		{
			return 'The password must not contain the username.';
		}
		return NULL;
	}
}

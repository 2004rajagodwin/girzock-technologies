<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Command-line only.
 *
 *   php index.php setup admin [username] [email]   Creates the first Super Admin with a random one-time password.
 *   php index.php setup migrate                    Runs pending database migrations.
 *   php index.php setup retry_emails               Retries failed or skipped notifications (suitable for cron).
 */
class Setup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ( ! is_cli())
		{
			show_404();
		}
	}

	public function admin($username = 'girzock2026', $email = '')
	{
		$role = $this->db->get_where('admin_roles', array('slug' => 'super_admin'), 1)->row_array();
		if ( ! $role)
		{
			echo "The admin_roles table has no Super Admin role. Import database/girzock_technologies.sql first.\n";
			exit(1);
		}
		if ($this->db->where('deleted_at IS NULL', NULL, FALSE)->where('role_id', $role['id'])->count_all_results('admin_users') > 0)
		{
			echo "A Super Admin already exists, so nothing was changed. Use the password reset page if access is lost.\n";
			exit(1);
		}
		$email = $email !== '' ? $email : setting('contact_email');
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			echo "That email address is not valid.\n";
			exit(1);
		}
		$password = rtrim(strtr(base64_encode(random_bytes(15)), '+/', 'Az'), '=');
		$this->db->insert('admin_users', array(
			'role_id' => $role['id'], 'username' => $username, 'email' => $email, 'full_name' => 'Super Admin',
			'password_hash' => password_hash($password, PASSWORD_DEFAULT), 'must_change_password' => 1, 'status' => 'active',
		));
		echo "\nSuper Admin created.\n  Username: {$username}\n  One-time password: {$password}\n\n";
		echo "This password is shown once and is not stored anywhere in plain text.\nYou must choose a new password on first login.\n\n";
	}

	public function migrate()
	{
		$this->load->library('migration');
		if ($this->migration->current() === FALSE)
		{
			echo $this->migration->error_string()."\n";
			exit(1);
		}
		echo "Migrations are up to date.\n";
	}

	public function retry_emails()
	{
		$this->load->model('enquiry_model');
		$this->load->library('enquiry_mailer');
		$rows = $this->db->where('entity_type', 'enquiry')->where_in('status', array('failed', 'skipped'))->where('attempts <', 10)->get('email_log', 100)->result_array();
		$done = array();
		foreach ($rows as $row)
		{
			if (isset($done[$row['entity_id']]))
			{
				continue;
			}
			$done[$row['entity_id']] = TRUE;
			$enquiry = $this->enquiry_model->find($row['entity_id']);
			if ($enquiry)
			{
				$this->enquiry_mailer->notify($enquiry);
			}
		}
		echo 'Retried '.count($done)." enquiries.\n";
	}
}

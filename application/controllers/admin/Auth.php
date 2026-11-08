<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_auth', NULL, 'auth');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('X-Robots-Tag: noindex, nofollow');
		$this->output->set_header('X-Frame-Options: DENY');
	}

	public function login()
	{
		if ($this->auth->user())
		{
			redirect('admin/dashboard');
		}
		$error = NULL;
		$identifier = '';
		if ($this->input->method() === 'post')
		{
			$identifier = trim((string) $this->input->post('username'));
			$password = (string) $this->input->post('password');
			if ($identifier === '' OR $password === '')
			{
				// Checked in the browser too; this covers requests that skip it. No sign-in attempt is made.
				$this->output->set_status_header(422);
				$this->load->view('admin/auth/login', array('error' => 'Enter your username or email and your password.', 'identifier' => $identifier, 'notice' => NULL));
				return;
			}
			$result = $this->auth->attempt($identifier, $password);
			if ($result === Admin_auth::OK)
			{
				redirect('admin/dashboard');
			}
			$error = $result === Admin_auth::LOCKED
				? 'Too many failed attempts. Please wait 15 minutes and try again.'
				: 'The username or password is incorrect.';
			$this->output->set_status_header($result === Admin_auth::LOCKED ? 429 : 401);
		}
		$this->load->view('admin/auth/login', array('error' => $error, 'identifier' => $identifier, 'notice' => $this->session->flashdata('gz_success')));
	}

	/** Sign-out only accepts POST with a CSRF token, so another site cannot sign a user out. */
	public function logout()
	{
		if ($this->input->method() !== 'post')
		{
			redirect('admin/dashboard');
		}
		$user = $this->auth->user();
		if ($user)
		{
			$this->settings_model->log_activity($user['id'], 'auth', 'logout', $user['id'], 'Signed out');
		}
		$this->auth->logout();
		redirect('admin/login');
	}

	/** The reply never reveals whether an account exists. */
	public function forgot()
	{
		$sent = FALSE;
		if ($this->input->method() === 'post')
		{
			$sent = TRUE;
			$identifier = trim((string) $this->input->post('email'));
			if ($this->settings_model->throttle('password_reset', 5, 3600))
			{
				$user = $identifier === '' ? NULL : $this->user_model->find_for_login($identifier);
				if ($user && $user['status'] === 'active')
				{
					$token = $this->user_model->create_reset($user['id'], $this->input->ip_address());
					$this->load->library('mailer');
					$html = $this->load->view('emails/password_reset', array('name' => $user['full_name'], 'link' => site_url('admin/reset-password/'.$token)), TRUE);
					if ( ! $this->mailer->send($user['email'], 'Reset your '.setting('company_name').' admin password', $html))
					{
						log_message('error', 'Password reset email failed for user #'.$user['id']);
					}
				}
			}
		}
		$this->load->view('admin/auth/forgot', array('sent' => $sent));
	}

	public function reset($token = '')
	{
		$reset = $this->user_model->find_valid_reset($token);
		$error = NULL;
		if ($reset && $this->input->method() === 'post')
		{
			$password = (string) $this->input->post('password');
			$user = $this->user_model->find($reset['user_id']);
			$error = $this->auth->password_problem($password, $user ? $user['username'] : '');
			if ($error === NULL && ! hash_equals($password, (string) $this->input->post('password_confirm')))
			{
				$error = 'The two passwords do not match.';
			}
			if ($error === NULL && $user && password_verify($password, $user['password_hash']))
			{
				$error = 'Please choose a password you have not just been using.';
			}
			if ($error === NULL && $this->user_model->complete_reset($reset, $password))
			{
				$this->settings_model->log_activity($reset['user_id'], 'auth', 'password_reset', $reset['user_id'], 'Password reset by email link');
				$this->session->set_flashdata('gz_success', 'Your password was changed. Please sign in.');
				redirect('admin/login');
			}
		}
		if ( ! $reset)
		{
			$this->output->set_status_header(410);
		}
		$this->load->view('admin/auth/reset', array('valid' => (bool) $reset, 'token' => $token, 'error' => $error));
	}
}

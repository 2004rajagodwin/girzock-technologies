<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_Controller {

	public function index($errors = array())
	{
		$this->render('admin/profile/index', array('page_title' => 'Profile', 'errors' => $errors));
	}

	public function save()
	{
		$this->require_post();
		$full_name = trim(strip_tags((string) $this->input->post('full_name')));
		$email = trim((string) $this->input->post('email'));
		$errors = array();
		if ($full_name === '' OR mb_strlen($full_name) > 120) { $errors['full_name'] = 'Enter your name.'; }
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) OR mb_strlen($email) > 190) { $errors['email'] = 'Enter a valid email address.'; }
		elseif ($this->user_model->is_taken('email', $email, $this->user['id'])) { $errors['email'] = 'That email is already in use.'; }
		$data = array('full_name' => $full_name, 'email' => $email);
		if ( ! empty($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE)
		{
			$this->load->library('media_manager');
			$stored = $this->media_manager->store_image($_FILES['avatar'], $this->user['id']);
			if ($stored) { $data['avatar'] = $stored['file_path']; }
			else { $errors['avatar'] = $this->media_manager->error; }
		}
		if ($errors)
		{
			$this->output->set_status_header(422);
			$this->user = array_merge($this->user, array('full_name' => $full_name, 'email' => $email));
			$this->index($errors);
			return;
		}
		$this->user_model->update_by_id($this->user['id'], $data);
		$this->log_action('update', $this->user['id'], 'Profile updated', 'profile');
		$this->flash_success('Profile saved.');
		redirect('admin/profile');
	}

	/** Also the forced first-login step: every other admin page redirects here until it is done. */
	public function password()
	{
		$error = NULL;
		$forced = (int) $this->user['must_change_password'] === 1;
		if ($this->input->method() === 'post')
		{
			$current = (string) $this->input->post('current_password');
			$new = (string) $this->input->post('new_password');
			if ( ! password_verify($current, $this->user['password_hash']))
			{
				$error = 'Your current password is incorrect.';
			}
			elseif (($problem = $this->auth->password_problem($new, $this->user['username'])) !== NULL)
			{
				$error = $problem;
			}
			elseif ( ! hash_equals($new, (string) $this->input->post('new_password_confirm')))
			{
				$error = 'The two new passwords do not match.';
			}
			elseif (password_verify($new, $this->user['password_hash']))
			{
				$error = 'The new password must be different from the current one.';
			}
			if ($error === NULL)
			{
				$this->user_model->set_password($this->user['id'], $new, 0);
				$this->auth->establish($this->user['id']); // new session ID; other sessions end
				$this->log_action('password_change', $this->user['id'], 'Password changed', 'profile');
				$this->flash_success('Your password has been changed.');
				redirect('admin/dashboard');
			}
			$this->output->set_status_header(422);
		}
		$this->render('admin/profile/password', array('page_title' => 'Change Password', 'error' => $error, 'forced' => $forced));
	}
}

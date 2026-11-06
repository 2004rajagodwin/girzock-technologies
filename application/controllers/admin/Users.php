<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

	protected $module = 'users';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->config->load('girzock', FALSE, TRUE);
	}

	public function index()
	{
		$this->render('admin/users/index', array(
			'page_title' => 'Admin Users',
			'rows' => $this->user_model->list_filtered(array(), 200, 0),
			'can_create' => $this->auth->can('users', 'create'),
			'can_edit' => $this->auth->can('users', 'edit'),
			'can_delete' => $this->auth->can('users', 'delete'),
			'is_super' => $this->auth->is_super(),
		));
	}

	/** Only a Super Admin can change a Super Admin account or grant that role. */
	private function assert_can_manage($target)
	{
		if ($target && $target['role_slug'] === 'super_admin' && ! $this->auth->is_super())
		{
			$this->flash_error('Only a Super Admin can change this account.');
			redirect('admin/users');
		}
	}

	private function role_options()
	{
		$options = array();
		foreach ($this->user_model->roles() as $role)
		{
			if ($role['slug'] !== 'super_admin' OR $this->auth->is_super())
			{
				$options[$role['id']] = $role;
			}
		}
		return $options;
	}

	public function create()
	{
		$this->require_can('create');
		$this->show_form(NULL, array('status' => 'active'));
	}

	public function edit($id = 0)
	{
		$this->require_can('edit');
		$target = $this->user_model->find_with_role($id);
		if ( ! $target)
		{
			show_404();
		}
		$this->assert_can_manage($target);
		$this->show_form($target['id'], $target);
	}

	private function show_form($id, array $values, array $errors = array())
	{
		$this->render('admin/users/form', array(
			'page_title' => $id ? 'Edit Admin User' : 'Add Admin User',
			'id' => $id, 'values' => $values, 'errors' => $errors, 'roles' => $this->role_options(),
		));
	}

	public function save($id = 0)
	{
		$this->require_post();
		$id = (int) $id;
		$this->require_can($id ? 'edit' : 'create');
		$target = NULL;
		if ($id)
		{
			$target = $this->user_model->find_with_role($id);
			if ( ! $target)
			{
				show_404();
			}
			$this->assert_can_manage($target);
		}

		$data = array(
			'username' => trim((string) $this->input->post('username')),
			'email' => trim((string) $this->input->post('email')),
			'full_name' => trim(strip_tags((string) $this->input->post('full_name'))),
			'role_id' => (int) $this->input->post('role_id'),
			'status' => $this->input->post('status') === 'disabled' ? 'disabled' : 'active',
		);
		$password = (string) $this->input->post('password');
		$errors = array();
		if ( ! preg_match('/^[A-Za-z0-9_.-]{3,60}$/', $data['username'])) { $errors['username'] = 'Use 3 to 60 letters, numbers, dots, dashes or underscores.'; }
		elseif ($this->user_model->is_taken('username', $data['username'], $id)) { $errors['username'] = 'That username is taken.'; }
		if ( ! filter_var($data['email'], FILTER_VALIDATE_EMAIL) OR mb_strlen($data['email']) > 190) { $errors['email'] = 'Enter a valid email address.'; }
		elseif ($this->user_model->is_taken('email', $data['email'], $id)) { $errors['email'] = 'That email is already in use.'; }
		if ($data['full_name'] === '' OR mb_strlen($data['full_name']) > 120) { $errors['full_name'] = 'Enter a name.'; }
		$roles = $this->role_options();
		if ( ! isset($roles[$data['role_id']])) { $errors['role_id'] = 'Choose a role.'; }
		if ( ! $id OR $password !== '')
		{
			$problem = $this->auth->password_problem($password, $data['username']);
			if ($problem) { $errors['password'] = $problem; }
		}
		if ($target && $target['role_slug'] === 'super_admin' && ($data['status'] !== 'active' OR ! isset($roles[$data['role_id']]) OR $roles[$data['role_id']]['slug'] !== 'super_admin') && $this->user_model->active_super_admin_count() <= 1)
		{
			$errors['role_id'] = 'This is the last active Super Admin, so it must stay active with that role.';
		}
		if ($errors)
		{
			$this->output->set_status_header(422);
			$this->show_form($id ? $id : NULL, array_merge($data, array('id' => $id)), $errors);
			return;
		}

		if ($id)
		{
			$this->user_model->update_by_id($id, $data);
			if ($password !== '')
			{
				$this->user_model->set_password($id, $password, 1);
			}
		}
		else
		{
			$data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
			$data['must_change_password'] = 1;
			$id = $this->user_model->create($data);
		}
		$this->log_action($target ? 'update' : 'create', $id, $data['username']);
		$this->flash_success('User saved.');
		redirect('admin/users');
	}

	public function delete($id = 0)
	{
		$this->require_post();
		$this->require_can('delete');
		$target = $this->user_model->find_with_role($id);
		if ( ! $target)
		{
			show_404();
		}
		$this->assert_can_manage($target);
		if ((int) $target['id'] === (int) $this->user['id'])
		{
			$this->flash_error('You cannot delete your own account.');
		}
		elseif ($target['role_slug'] === 'super_admin' && $this->user_model->active_super_admin_count() <= 1)
		{
			$this->flash_error('The last active Super Admin cannot be deleted.');
		}
		else
		{
			// Soft delete; the username and email stay reserved so history stays unambiguous.
			$this->user_model->update_by_id($target['id'], array('deleted_at' => date('Y-m-d H:i:s'), 'status' => 'disabled'));
			$this->log_action('delete', $target['id'], $target['username']);
			$this->flash_success('User deleted.');
		}
		redirect('admin/users');
	}

	/* ---------- roles ---------- */

	public function roles($id = 0)
	{
		if ( ! $this->auth->is_super())
		{
			$this->require_can('edit', '__super_only__');
		}
		$roles = $this->user_model->roles();
		$role = $id ? $this->user_model->role($id) : NULL;
		if ( ! $role)
		{
			foreach ($roles as $candidate)
			{
				if ($candidate['slug'] !== 'super_admin')
				{
					$role = $candidate;
					break;
				}
			}
		}
		$this->render('admin/users/roles', array(
			'page_title' => 'Roles and Permissions',
			'roles' => $roles,
			'role' => $role,
			'modules' => $this->config->item('gz_modules'),
			'permissions' => $role ? $this->user_model->permissions_for_role($role['id']) : array(),
		));
	}

	public function role_save($id = 0)
	{
		$this->require_post();
		if ( ! $this->auth->is_super())
		{
			$this->require_can('edit', '__super_only__');
		}
		$role = $this->user_model->role($id);
		if ( ! $role OR $role['slug'] === 'super_admin')
		{
			$this->flash_error('The Super Admin role always has full access.');
			redirect('admin/users/roles');
		}
		$matrix = $this->input->post('permissions');
		$this->user_model->save_permissions($role['id'], is_array($matrix) ? $matrix : array(), $this->config->item('gz_modules'));
		$this->log_action('update', $role['id'], 'Permissions for '.$role['name']);
		$this->flash_success('Permissions saved.');
		redirect('admin/users/roles/'.$role['id']);
	}

	public function role_create()
	{
		$this->require_post();
		if ( ! $this->auth->is_super())
		{
			$this->require_can('edit', '__super_only__');
		}
		$name = trim(strip_tags((string) $this->input->post('name')));
		$slug = make_slug($name);
		if ($name === '' OR mb_strlen($name) > 80 OR $this->db->where('slug', $slug)->count_all_results('admin_roles') > 0)
		{
			$this->flash_error('Enter a new, unique role name.');
			redirect('admin/users/roles');
		}
		$this->db->insert('admin_roles', array('name' => $name, 'slug' => $slug));
		$id = $this->db->insert_id();
		$this->log_action('create', $id, 'Role '.$name);
		redirect('admin/users/roles/'.$id);
	}
}

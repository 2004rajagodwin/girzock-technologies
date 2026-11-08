<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Every admin controller except Auth extends this. The constructor enforces sign-in and the
 * forced first-login password change, so no route can be reached without them.
 */
class Admin_Controller extends MY_Controller {

	protected $module = '';
	protected $user = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_auth', NULL, 'auth');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('X-Robots-Tag: noindex, nofollow');
		$this->output->set_header('X-Frame-Options: DENY');

		$this->user = $this->auth->user();
		if ( ! $this->user)
		{
			if ($this->wants_json())
			{
				$this->json(array('ok' => FALSE, 'message' => 'Please sign in again.'), 401);
				$this->output->_display();
				exit;
			}
			redirect('admin/login');
		}
		$is_password_page = strtolower($this->router->class) === 'profile' && $this->router->method === 'password';
		if ((int) $this->user['must_change_password'] === 1 && ! $is_password_page)
		{
			redirect('admin/profile/password');
		}
		if ($this->module !== '')
		{
			$this->require_can('view');
		}
	}

	/** Stops the request with 403 when the role lacks a permission. */
	protected function require_can($action, $module = NULL)
	{
		$module = $module === NULL ? $this->module : $module;
		if ($this->auth->can($module, $action))
		{
			return;
		}
		if ($this->wants_json())
		{
			$this->json(array('ok' => FALSE, 'message' => 'You do not have permission for this action.'), 403);
		}
		else
		{
			$this->output->set_status_header(403);
			$this->render('admin/layouts/forbidden', array('page_title' => 'Access denied'));
		}
		$this->output->_display();
		exit;
	}

	protected function require_post()
	{
		if ($this->input->method() !== 'post')
		{
			show_error('This action requires a form submission.', 405);
		}
	}

	protected function render($view, array $data = array())
	{
		$this->load->model('enquiry_model');
		$this->config->load('girzock', FALSE, TRUE);
		$data['content_view'] = $view;
		$data['admin'] = $this->user;
		$data['unread_enquiries'] = $this->auth->can('enquiries') ? $this->enquiry_model->unread_count() : 0;
		$data['flash_success'] = $this->session->flashdata('gz_success');
		$data['flash_error'] = $this->session->flashdata('gz_error');
		$this->load->view('admin/layouts/main', $data);
	}

	protected function flash_success($message)
	{
		$this->session->set_flashdata('gz_success', $message);
	}

	protected function flash_error($message)
	{
		$this->session->set_flashdata('gz_error', $message);
	}

	protected function log_action($action, $entity_id = NULL, $description = NULL, $module = NULL)
	{
		$this->settings_model->log_activity($this->user['id'], $module === NULL ? $this->module : $module, $action, $entity_id, $description);
	}

	protected function page_number()
	{
		return max(1, (int) $this->input->get('page'));
	}

	/** Pagination links that keep the current filters. */
	protected function pagination($total, $per_page, $page)
	{
		$pages = (int) ceil($total / max(1, $per_page));
		if ($pages <= 1)
		{
			return '';
		}
		$query = $this->input->get();
		$query = is_array($query) ? $query : array();
		$html = '<nav class="gz-pages" aria-label="Pagination">';
		$window = array();
		for ($n = 1; $n <= $pages; $n++)
		{
			if ($n === 1 OR $n === $pages OR abs($n - $page) <= 2)
			{
				$window[] = $n;
			}
		}
		$last = 0;
		foreach ($window as $n)
		{
			if ($n - $last > 1)
			{
				$html .= '<span class="gz-pages-gap">...</span>';
			}
			$query['page'] = $n;
			$html .= $n === $page ? '<span class="current" aria-current="page">'.$n.'</span>' : '<a href="'.e(current_url().'?'.http_build_query($query)).'">'.$n.'</a>';
			$last = $n;
		}
		return $html.'</nav>';
	}
	/**
	 * The social sharing image from an SEO form: a new upload (stored in the media library as WebP), or the path of
	 * an existing image chosen in the picker. Empty means "no image". Returns NULL and sets $error when invalid.
	 */
	protected function social_image_value($name, &$error)
	{
		$this->load->library('media_manager');
		if ( ! empty($_FILES[$name]) && ! is_array($_FILES[$name]['name']) && $_FILES[$name]['error'] !== UPLOAD_ERR_NO_FILE)
		{
			$stored = $this->media_manager->store_image($_FILES[$name], $this->user['id']);
			if ( ! $stored)
			{
				$error = 'Social sharing image: '.$this->media_manager->error;
				return NULL;
			}
			return $stored['file_path'];
		}
		$path = trim((string) $this->input->post($name));
		if ($path === '')
		{
			return '';
		}
		if ( ! valid_social_image_path($path))
		{
			$error = 'Social sharing image: choose an existing JPG, PNG, WebP or GIF from the media library, or upload one.';
			return NULL;
		}
		return $path;
	}
}

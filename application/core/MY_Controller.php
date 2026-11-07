<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/** JSON response helper for AJAX endpoints. */
	protected function json($payload, $status = 200)
	{
		$this->output->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($payload, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES));
	}

	protected function wants_json()
	{
		return $this->input->is_ajax_request() OR strpos((string) $this->input->server('HTTP_ACCEPT'), 'application/json') !== FALSE;
	}
}

/** Base for every public page: renders inside the shared site layout with SEO data. */
class Public_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('seo');
		$this->output->set_header('X-Frame-Options: SAMEORIGIN');
	}

	/** The popup for this page, if any. ?gz_popup_preview shows it to a signed-in admin with access. */
	public function popup_state()
	{
		$mode = $this->input->get('gz_popup_preview');
		if ($mode === 'desktop' OR $mode === 'mobile')
		{
			$this->load->library('admin_auth', NULL, 'auth');
			if ($this->auth->user() && $this->auth->can('popup'))
			{
				$this->output->set_header('Cache-Control: no-store');
				$this->output->set_header('X-Robots-Tag: noindex, nofollow');
				return $this->settings_model->popup(TRUE);
			}
		}
		return $this->settings_model->popup();
	}

	/**
	 * Lets a signed-in admin with access to the module see an unpublished record at ?preview=1.
	 * Visitors never reach this: the session and auth libraries load only for a preview request.
	 */
	protected function preview_allowed($module)
	{
		if ( ! $this->input->get('preview'))
		{
			return FALSE;
		}
		$this->load->library('admin_auth', NULL, 'auth');
		$allowed = $this->auth->user() && $this->auth->can($module);
		if ($allowed)
		{
			$this->output->set_header('Cache-Control: no-store');
			$this->output->set_header('X-Robots-Tag: noindex, nofollow');
		}
		return $allowed;
	}

	protected function render($view, array $data = array())
	{
		$data['content_view'] = $view;
		if (empty($data['seo']))
		{
			$data['seo'] = $this->seo->build();
		}
		$this->load->view('frontend/layouts/main', $data);
	}

	/**
	 * Shows the branded 404 page. It stops the request here so a missing record can never
	 * fall through to a template with no data.
	 */
	protected function not_found()
	{
		// A renamed slug answers 301 and deleted content answers 410, wherever the request was routed.
		$redirect = $this->settings_model->find_redirect(uri_string());
		if ($redirect)
		{
			if ((int) $redirect['status_code'] === 410 OR $redirect['new_path'] === NULL)
			{
				$this->output->set_status_header(410);
				$seo = $this->seo->build(array('title' => 'Page Removed | '.setting('company_name'), 'description' => setting('default_meta_description'), 'robots' => 'noindex, follow'));
				$this->render('frontend/errors/404', array('seo' => $seo, 'gone' => TRUE));
				$this->output->_display();
				exit;
			}
			redirect(site_url($redirect['new_path']), 'location', 301);
		}
		$this->output->set_status_header(404);
		$seo = $this->seo->build(array('title' => 'Page Not Found | '.setting('company_name'), 'description' => setting('default_meta_description'), 'robots' => 'noindex, follow'));
		$this->render('frontend/errors/404', array('seo' => $seo));
		$this->output->_display();
		exit;
	}
}

require_once APPPATH.'core/Admin_Controller.php';
require_once APPPATH.'core/Admin_Crud_Controller.php';

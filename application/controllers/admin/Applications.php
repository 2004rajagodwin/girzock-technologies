<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applications extends Admin_Controller {

	protected $module = 'applications';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('application_model');
		$this->config->load('girzock', FALSE, TRUE);
	}

	public function index()
	{
		$status = $this->input->get('status');
		$filters = array(
			'q' => mb_substr(trim((string) $this->input->get('q')), 0, 100),
			'status' => in_array($status, $this->config->item('gz_application_statuses'), TRUE) ? $status : '',
		);
		$per_page = (int) $this->config->item('gz_admin_per_page');
		$page = $this->page_number();
		$total = $this->application_model->count_filtered($filters);
		$this->render('admin/applications/index', array(
			'page_title' => 'Job Applications',
			'filters' => $filters,
			'statuses' => $this->config->item('gz_application_statuses'),
			'rows' => $this->application_model->list_filtered($filters, $per_page, ($page - 1) * $per_page),
			'total' => $total,
			'pagination' => $this->pagination($total, $per_page, $page),
			'can_delete' => $this->auth->can('applications', 'delete'),
		));
	}

	private function load_row($id)
	{
		$row = $this->application_model->find($id);
		if ( ! $row)
		{
			show_404();
		}
		return $row;
	}

	public function view($id = 0)
	{
		$row = $this->load_row($id);
		if ( ! $row['is_read'])
		{
			$this->application_model->update_by_id($row['id'], array('is_read' => 1));
		}
		$this->render('admin/applications/view', array(
			'page_title' => 'Application '.$row['reference_no'],
			'application' => $row,
			'emails' => $this->db->select('recipient_type, status, attempts, sent_at, updated_at')->where(array('entity_type' => 'application', 'entity_id' => (int) $row['id']))->get('email_log')->result_array(),
			'statuses' => $this->config->item('gz_application_statuses'),
			'can_edit' => $this->auth->can('applications', 'edit'),
			'can_delete' => $this->auth->can('applications', 'delete'),
		));
	}

	public function update($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$row = $this->load_row($id);
		$status = (string) $this->input->post('status');
		$notes = trim((string) $this->input->post('internal_notes'));
		if ( ! in_array($status, $this->config->item('gz_application_statuses'), TRUE) OR mb_strlen($notes) > 10000)
		{
			$this->flash_error('Please check the status and notes.');
		}
		else
		{
			$this->application_model->update_by_id($row['id'], array('status' => $status, 'internal_notes' => $notes === '' ? NULL : $notes));
			$this->log_action('update', $row['id'], $row['reference_no'].' set to '.$status);
			$this->flash_success('Application updated.');
		}
		redirect('admin/job-applications/view/'.$row['id']);
	}

	/** Resumes live outside the web root and are only reachable through this check. */
	public function resume($id = 0)
	{
		$row = $this->load_row($id);
		$this->load->library('media_manager');
		$path = $this->media_manager->resume_path($row['resume_path']);
		if ( ! $path)
		{
			log_message('error', 'Resume file missing for application #'.$row['id']);
			show_404();
		}
		$this->log_action('download', $row['id'], 'Downloaded resume for '.$row['reference_no']);
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		$safe_name = preg_replace('/[^A-Za-z0-9_-]+/', '-', $row['full_name']).'-resume.'.$extension;
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$safe_name.'"');
		header('Content-Length: '.filesize($path));
		header('X-Content-Type-Options: nosniff');
		readfile($path);
		exit;
	}

	/**
	 * Permanently deletes an application, its email log and its resume file. The file is removed only after the
	 * database row is gone, only if no other application uses it, and only from the private resumes folder.
	 */
	public function delete($id = 0)
	{
		$this->require_post();
		$this->require_can('delete');
		$ajax = $this->input->is_ajax_request();
		$failed = 'Unable to delete application. Please try again.';
		$row = $this->application_model->find_any($id);
		if ( ! $row)
		{
			if ($ajax) { return $this->json(array('ok' => FALSE, 'message' => $failed), 404); }
			show_404();
		}
		if ( ! $this->application_model->delete_forever($row['id']))
		{
			log_message('error', 'Application #'.$row['id'].' could not be deleted.');
			if ($ajax) { return $this->json(array('ok' => FALSE, 'message' => $failed), 500); }
			$this->flash_error($failed);
			redirect('admin/job-applications/view/'.(int) $row['id']);
		}
		if ($row['resume_path'] !== NULL && $row['resume_path'] !== '' && ! $this->application_model->resume_shared($row['resume_path'], $row['id']))
		{
			$this->load->library('media_manager');
			if ( ! $this->media_manager->delete_resume($row['resume_path']))
			{
				// The record is gone either way; a leftover file is only logged, never shown to visitors.
				log_message('error', 'Resume file for deleted application #'.$row['id'].' was missing or could not be removed.');
			}
		}
		$this->log_action('delete', $row['id'], $row['reference_no'].' deleted');
		if ($ajax)
		{
			return $this->json(array('ok' => TRUE, 'message' => 'Application deleted successfully.', 'total' => $this->application_model->count_filtered(array())));
		}
		$this->flash_success('Application deleted successfully.');
		redirect('admin/job-applications');
	}

	public function archive($id = 0)
	{
		$this->require_post();
		$this->require_can('delete');
		$row = $this->load_row($id);
		$this->application_model->update_by_id($row['id'], array('archived_at' => date('Y-m-d H:i:s')));
		$this->log_action('archive', $row['id'], $row['reference_no']);
		$this->flash_success('Application archived.');
		redirect('admin/job-applications');
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiries extends Admin_Controller {

	protected $module = 'enquiries';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('enquiry_model');
		$this->config->load('girzock', FALSE, TRUE);
	}

	private function filters()
	{
		$status = $this->input->get('status');
		return array(
			'q' => mb_substr(trim((string) $this->input->get('q')), 0, 100),
			'status' => in_array($status, $this->config->item('gz_enquiry_statuses'), TRUE) ? $status : '',
			'from' => preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $this->input->get('from')) ? $this->input->get('from') : '',
			'to' => preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $this->input->get('to')) ? $this->input->get('to') : '',
			'archived' => $this->input->get('archived') ? 1 : 0,
		);
	}

	public function index()
	{
		$filters = $this->filters();
		$per_page = (int) $this->config->item('gz_admin_per_page');
		$page = $this->page_number();
		$total = $this->enquiry_model->count_filtered($filters);
		$this->render('admin/enquiries/index', array(
			'page_title' => 'Enquiries',
			'filters' => $filters,
			'statuses' => $this->config->item('gz_enquiry_statuses'),
			'rows' => $this->enquiry_model->list_filtered($filters, $per_page, ($page - 1) * $per_page)->result_array(),
			'total' => $total,
			'pagination' => $this->pagination($total, $per_page, $page),
			'export_query' => http_build_query(array_filter($filters)),
			'can_delete' => $this->auth->can('enquiries', 'delete'),
		));
	}

	private function load_enquiry($id)
	{
		$enquiry = $this->enquiry_model->find($id);
		if ( ! $enquiry)
		{
			show_404();
		}
		return $enquiry;
	}

	public function view($id = 0)
	{
		$enquiry = $this->load_enquiry($id);
		if ( ! $enquiry['is_read'])
		{
			$this->enquiry_model->mark_read($enquiry['id']);
			$this->enquiry_model->history($enquiry['id'], $this->user['id'], 'viewed');
		}
		$this->load->model('user_model');
		$this->render('admin/enquiries/view', array(
			'page_title' => 'Enquiry '.$enquiry['reference_no'],
			'enquiry' => $enquiry,
			'statuses' => $this->config->item('gz_enquiry_statuses'),
			'assignees' => $this->user_model->active_options(),
			'notes' => $this->enquiry_model->notes($enquiry['id']),
			'history' => $this->enquiry_model->history_for($enquiry['id']),
			'emails' => $this->enquiry_model->email_log($enquiry['id']),
			'can_edit' => $this->auth->can('enquiries', 'edit'),
			'can_delete' => $this->auth->can('enquiries', 'delete'),
		));
	}

	public function status($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$enquiry = $this->load_enquiry($id);
		$new = (string) $this->input->post('status');
		if ( ! in_array($new, $this->config->item('gz_enquiry_statuses'), TRUE))
		{
			$this->flash_error('Choose a valid status.');
		}
		elseif ($new !== $enquiry['status'])
		{
			$this->enquiry_model->update_status($enquiry['id'], $enquiry['status'], $new, $this->user['id']);
			$this->log_action('status', $enquiry['id'], $enquiry['reference_no'].' set to '.$new);
			$this->flash_success('Status updated.');
		}
		redirect('admin/enquiries/view/'.$enquiry['id']);
	}

	public function assign($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$enquiry = $this->load_enquiry($id);
		$this->load->model('user_model');
		$user_id = (int) $this->input->post('assigned_to');
		$new_name = 'Unassigned';
		if ($user_id)
		{
			$target = $this->user_model->find($user_id);
			if ( ! $target OR $target['status'] !== 'active')
			{
				$this->flash_error('Choose an active admin user.');
				redirect('admin/enquiries/view/'.$enquiry['id']);
			}
			$new_name = $target['full_name'];
		}
		$this->enquiry_model->assign($enquiry['id'], $enquiry['assigned_name'], $user_id, $new_name, $this->user['id']);
		$this->log_action('assign', $enquiry['id'], $enquiry['reference_no'].' assigned to '.$new_name);
		$this->flash_success('Assignment updated.');
		redirect('admin/enquiries/view/'.$enquiry['id']);
	}

	public function note($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$enquiry = $this->load_enquiry($id);
		$note = trim((string) $this->input->post('note'));
		if ($note === '' OR mb_strlen($note) > 5000)
		{
			$this->flash_error('A note must be between 1 and 5000 characters.');
		}
		else
		{
			$this->enquiry_model->add_note($enquiry['id'], $this->user['id'], $note);
			$this->flash_success('Note added.');
		}
		redirect('admin/enquiries/view/'.$enquiry['id']);
	}

	public function archive($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$enquiry = $this->load_enquiry($id);
		$this->enquiry_model->set_archived($enquiry['id'], ! $enquiry['archived_at'], $this->user['id']);
		$this->log_action($enquiry['archived_at'] ? 'restore' : 'archive', $enquiry['id'], $enquiry['reference_no']);
		$this->flash_success($enquiry['archived_at'] ? 'Enquiry restored.' : 'Enquiry archived.');
		redirect('admin/enquiries');
	}

	public function delete($id = 0)
	{
		$this->require_post();
		$this->require_can('delete');
		$ajax = $this->input->is_ajax_request();
		$enquiry = $this->enquiry_model->find($id);
		if ( ! $enquiry)
		{
			if ($ajax)
			{
				return $this->json(array('ok' => FALSE, 'message' => 'That enquiry no longer exists.'), 404);
			}
			show_404();
		}
		$deleted = $this->enquiry_model->delete_forever($enquiry['id']);
		if ($deleted)
		{
			$this->log_action('delete', $enquiry['id'], $enquiry['reference_no'].' deleted');
		}
		else
		{
			log_message('error', 'Enquiry #'.$enquiry['id'].' could not be deleted.');
		}
		$message = $deleted ? 'Enquiry '.$enquiry['reference_no'].' was deleted.' : 'The enquiry could not be deleted. Please try again.';
		if ($ajax)
		{
			return $this->json(array('ok' => $deleted, 'message' => $message, 'total' => $this->enquiry_model->count_filtered($this->filters()), 'unread' => $this->enquiry_model->unread_count()), $deleted ? 200 : 500);
		}
		$deleted ? $this->flash_success($message) : $this->flash_error($message);
		redirect('admin/enquiries'.($enquiry['archived_at'] ? '?archived=1' : ''));
	}

	/** Sends whichever notifications have not been delivered yet. */
	public function resend($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$enquiry = $this->load_enquiry($id);
		$this->load->library('enquiry_mailer');
		$result = $this->enquiry_mailer->notify($enquiry);
		if ($result['company'] && $result['client'])
		{
			$this->flash_success('Both notifications have been delivered.');
		}
		else
		{
			$this->flash_error('Delivery failed. See the email log on this page.');
		}
		redirect('admin/enquiries/view/'.$enquiry['id']);
	}

	/** CSV of the current filter, streamed row by row. */
	public function export()
	{
		$filters = $this->filters();
		$this->log_action('export', NULL, 'Exported enquiries to CSV');
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="girzock-enquiries-'.date('Y-m-d').'.csv"');
		header('X-Content-Type-Options: nosniff');
		$out = fopen('php://output', 'w');
		fwrite($out, "\xEF\xBB\xBF");
		fputcsv($out, array('Reference', 'Client Name', 'Email', 'Phone', 'Company', 'Service Required', 'Project Description', 'Status', 'Assigned Admin', 'Submitted Date'));
		$query = $this->enquiry_model->list_filtered($filters);
		while ($row = $query->unbuffered_row('array'))
		{
			fputcsv($out, array_map(array($this, 'csv_safe'), array($row['reference_no'], $row['full_name'], $row['email'], $row['phone'], $row['company'], $row['service_required'], $row['message'], humanize_status($row['status']), $row['assigned_name'], $row['created_at'])));
		}
		fclose($out);
		exit;
	}

	/** Stops a spreadsheet from running visitor-supplied text as a formula. */
	private function csv_safe($value)
	{
		$value = (string) $value;
		return ($value !== '' && strpos("=+-@\t\r", $value[0]) !== FALSE) ? "'".$value : $value;
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry_model extends CI_Model {

	const TABLE = 'contact_enquiries';

	/** A repeat of the same enquiry within this many seconds is treated as a double submit. */
	const DUPLICATE_WINDOW = 600;

	/* ---------- public submission ---------- */

	public function content_hash(array $d)
	{
		return hash('sha256', strtolower(trim($d['email'])).'|'.trim($d['service_required']).'|'.trim($d['message']));
	}

	public function find_recent_duplicate($hash)
	{
		return $this->db->where('content_hash', $hash)->where('created_at >=', date('Y-m-d H:i:s', time() - self::DUPLICATE_WINDOW))
			->order_by('id', 'DESC')->get(self::TABLE, 1)->row_array();
	}

	/**
	 * Saves the enquiry, its unique reference and first history entry in one transaction.
	 * @return array|FALSE the stored row
	 */
	public function create(array $data)
	{
		$data['content_hash'] = $this->content_hash($data);
		$data['reference_no'] = 'TMP-'.bin2hex(random_bytes(8));

		$this->db->trans_start();
		$this->db->insert(self::TABLE, $data);
		$id = (int) $this->db->insert_id();
		$reference = sprintf('GZ-ENQ-%s-%05d', date('Y'), $id);
		$this->db->where('id', $id)->update(self::TABLE, array('reference_no' => $reference));
		$this->db->insert('enquiry_history', array('enquiry_id' => $id, 'action' => 'created', 'new_value' => 'new'));
		$this->db->trans_complete();

		if ( ! $this->db->trans_status())
		{
			log_message('error', 'Enquiry could not be saved.');
			return FALSE;
		}
		$data['id'] = $id;
		$data['reference_no'] = $reference;
		return $data;
	}

	/* ---------- admin ---------- */

	private function filter(array $f)
	{
		if ( ! empty($f['archived']))
		{
			$this->db->where('contact_enquiries.archived_at IS NOT NULL', NULL, FALSE);
		}
		else
		{
			$this->db->where('contact_enquiries.archived_at IS NULL', NULL, FALSE);
		}
		if ( ! empty($f['status']))
		{
			$this->db->where('contact_enquiries.status', $f['status']);
		}
		if ( ! empty($f['from']) && strtotime($f['from']))
		{
			$this->db->where('contact_enquiries.created_at >=', date('Y-m-d 00:00:00', strtotime($f['from'])));
		}
		if ( ! empty($f['to']) && strtotime($f['to']))
		{
			$this->db->where('contact_enquiries.created_at <=', date('Y-m-d 23:59:59', strtotime($f['to'])));
		}
		if ( ! empty($f['q']))
		{
			$this->db->group_start()
				->like('contact_enquiries.full_name', $f['q'])->or_like('contact_enquiries.email', $f['q'])
				->or_like('contact_enquiries.phone', $f['q'])->or_like('contact_enquiries.company', $f['q'])
				->or_like('contact_enquiries.reference_no', $f['q'])->or_like('contact_enquiries.message', $f['q'])
				->group_end();
		}
	}

	public function count_filtered(array $f)
	{
		$this->filter($f);
		return (int) $this->db->count_all_results(self::TABLE);
	}

	public function list_filtered(array $f, $limit = NULL, $offset = 0)
	{
		$this->db->select('contact_enquiries.*, admin_users.full_name AS assigned_name')
			->join('admin_users', 'admin_users.id = contact_enquiries.assigned_to', 'left');
		$this->filter($f);
		$this->db->order_by('contact_enquiries.created_at', 'DESC')->order_by('contact_enquiries.id', 'DESC');
		if ($limit !== NULL)
		{
			$this->db->limit((int) $limit, (int) $offset);
		}
		return $this->db->get(self::TABLE);
	}

	public function find($id)
	{
		$row = $this->db->select('contact_enquiries.*, admin_users.full_name AS assigned_name')
			->join('admin_users', 'admin_users.id = contact_enquiries.assigned_to', 'left')
			->where('contact_enquiries.id', (int) $id)->get(self::TABLE, 1)->row_array();
		return $row ? $row : NULL;
	}

	public function mark_read($id)
	{
		$this->db->where(array('id' => (int) $id, 'is_read' => 0))->update(self::TABLE, array('is_read' => 1, 'read_at' => date('Y-m-d H:i:s')));
	}

	public function update_status($id, $old, $new, $admin_id)
	{
		$this->db->trans_start();
		$this->db->where('id', (int) $id)->update(self::TABLE, array('status' => $new));
		$this->history($id, $admin_id, 'status_changed', $old, $new);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function assign($id, $old_name, $user_id, $new_name, $admin_id)
	{
		$this->db->trans_start();
		$this->db->where('id', (int) $id)->update(self::TABLE, array('assigned_to' => $user_id ? (int) $user_id : NULL));
		$this->history($id, $admin_id, 'assigned', $old_name, $new_name);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function add_note($id, $admin_id, $note)
	{
		$this->db->trans_start();
		$this->db->insert('enquiry_notes', array('enquiry_id' => (int) $id, 'admin_id' => (int) $admin_id, 'note' => $note));
		$this->history($id, $admin_id, 'note_added', NULL, NULL);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function set_archived($id, $archived, $admin_id)
	{
		$this->db->trans_start();
		$this->db->where('id', (int) $id)->update(self::TABLE, array('archived_at' => $archived ? date('Y-m-d H:i:s') : NULL));
		$this->history($id, $admin_id, $archived ? 'archived' : 'restored', NULL, NULL);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	/** Permanent delete, with notes and history (by cascade) and the email log, in one transaction. */
	public function delete_forever($id)
	{
		$this->db->trans_start();
		$this->db->where(array('entity_type' => 'enquiry', 'entity_id' => (int) $id))->delete('email_log');
		$this->db->where('id', (int) $id)->delete(self::TABLE);
		$deleted = $this->db->affected_rows() === 1;
		$this->db->trans_complete();
		return $deleted && $this->db->trans_status();
	}

	public function history($id, $admin_id, $action, $old = NULL, $new = NULL)
	{
		$this->db->insert('enquiry_history', array('enquiry_id' => (int) $id, 'admin_id' => $admin_id ? (int) $admin_id : NULL, 'action' => $action, 'old_value' => $old, 'new_value' => $new));
	}

	public function notes($id)
	{
		return $this->db->select('enquiry_notes.*, admin_users.full_name AS author')
			->join('admin_users', 'admin_users.id = enquiry_notes.admin_id', 'left')
			->where('enquiry_id', (int) $id)->order_by('enquiry_notes.created_at', 'DESC')->order_by('enquiry_notes.id', 'DESC')->get('enquiry_notes')->result_array();
	}

	public function history_for($id)
	{
		return $this->db->select('enquiry_history.*, admin_users.full_name AS author')
			->join('admin_users', 'admin_users.id = enquiry_history.admin_id', 'left')
			->where('enquiry_id', (int) $id)->order_by('enquiry_history.created_at', 'DESC')->order_by('enquiry_history.id', 'DESC')->get('enquiry_history')->result_array();
	}

	public function email_log($id)
	{
		return $this->db->where(array('entity_type' => 'enquiry', 'entity_id' => (int) $id))->get('email_log')->result_array();
	}

	public function unread_count()
	{
		return (int) $this->db->where('is_read', 0)->where('archived_at IS NULL', NULL, FALSE)->count_all_results(self::TABLE);
	}

	public function unread_latest($limit = 5)
	{
		return $this->db->where('is_read', 0)->where('archived_at IS NULL', NULL, FALSE)->order_by('created_at', 'DESC')->get(self::TABLE, (int) $limit)->result_array();
	}

	/** Counts per status for active enquiries. */
	public function status_counts()
	{
		$out = array_fill_keys($this->config->item('gz_enquiry_statuses'), 0);
		$rows = $this->db->select('status, COUNT(*) AS total')->where('archived_at IS NULL', NULL, FALSE)->group_by('status')->get(self::TABLE)->result_array();
		foreach ($rows as $row)
		{
			$out[$row['status']] = (int) $row['total'];
		}
		return $out;
	}
}

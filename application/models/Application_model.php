<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_model extends CI_Model {

	const TABLE = 'job_applications';

	private function filter(array $f)
	{
		$this->db->where('archived_at IS NULL', NULL, FALSE);
		if ( ! empty($f['status']))
		{
			$this->db->where('status', $f['status']);
		}
		if ( ! empty($f['career_id']))
		{
			$this->db->where('career_id', (int) $f['career_id']);
		}
		if ( ! empty($f['q']))
		{
			$this->db->group_start()->like('full_name', $f['q'])->or_like('email', $f['q'])->or_like('position_title', $f['q'])->or_like('reference_no', $f['q'])->group_end();
		}
	}

	public function count_filtered(array $f)
	{
		$this->filter($f);
		return (int) $this->db->count_all_results(self::TABLE);
	}

	public function list_filtered(array $f, $limit, $offset)
	{
		$this->filter($f);
		return $this->db->order_by('created_at', 'DESC')->get(self::TABLE, (int) $limit, (int) $offset)->result_array();
	}

	public function find($id)
	{
		$row = $this->db->where('archived_at IS NULL', NULL, FALSE)->get_where(self::TABLE, array('id' => (int) $id), 1)->row_array();
		return $row ? $row : NULL;
	}

	/** The same person applying for the same position with the same details in the last 30 days. */
	public function find_duplicate($hash)
	{
		return $this->db->where('content_hash', $hash)->where('created_at >=', date('Y-m-d H:i:s', time() - 2592000))->get(self::TABLE, 1)->row_array();
	}

	/** @return array|FALSE the stored row */
	public function create(array $data)
	{
		$this->db->trans_start();
		$data['reference_no'] = 'TMP-'.bin2hex(random_bytes(8));
		$this->db->insert(self::TABLE, $data);
		$id = $this->db->insert_id();
		$reference = sprintf('GZ-JOB-%s-%05d', date('Y'), $id);
		$this->db->where('id', $id)->update(self::TABLE, array('reference_no' => $reference));
		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			return FALSE;
		}
		$data['id'] = $id;
		$data['reference_no'] = $reference;
		return $data;
	}

	public function update_by_id($id, array $data)
	{
		return $this->db->where('id', (int) $id)->update(self::TABLE, $data);
	}

	public function unread_count()
	{
		return (int) $this->db->where(array('is_read' => 0))->where('archived_at IS NULL', NULL, FALSE)->count_all_results(self::TABLE);
	}

	public function latest($limit)
	{
		return $this->db->where('archived_at IS NULL', NULL, FALSE)->order_by('created_at', 'DESC')->get(self::TABLE, (int) $limit)->result_array();
	}
}

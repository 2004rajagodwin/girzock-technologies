<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	protected $module = 'dashboard';

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('enquiry_model', 'application_model', 'blog_model'));
		$this->config->load('girzock', FALSE, TRUE);
	}

	public function index()
	{
		$can_enquiries = $this->auth->can('enquiries');
		$can_applications = $this->auth->can('applications');
		$this->render('admin/dashboard/index', array(
			'page_title' => 'Dashboard',
			'can_enquiries' => $can_enquiries,
			'can_applications' => $can_applications,
			'stats' => $this->stats_data(),
			'latest_enquiries' => $can_enquiries ? $this->enquiry_model->list_filtered(array(), 5)->result_array() : array(),
			'latest_applications' => $can_applications ? $this->application_model->latest(5) : array(),
			'latest_posts' => $this->blog_model->list_public(array(), 5),
			'activities' => $this->auth->is_super() ? $this->recent_activity() : array(),
		));
	}

	private function count_live($table, array $where)
	{
		return (int) $this->db->where($where)->where('deleted_at IS NULL', NULL, FALSE)->count_all_results($table);
	}

	private function stats_data()
	{
		$status = $this->enquiry_model->status_counts();
		$pending = $status['contacted'] + $status['in_progress'] + $status['follow_up'];
		return array(
			'total_enquiries' => array_sum($status),
			'new_enquiries' => $status['new'],
			'pending_enquiries' => $pending,
			'completed_enquiries' => $status['converted'] + $status['closed'],
			'services' => $this->count_live('services', array('status' => 'active')),
			'products' => $this->count_live('products', array('status' => 'published')),
			'portfolio' => $this->count_live('portfolio_projects', array('status' => 'published')),
			'blog_posts' => $this->blog_model->count_public(),
			'careers' => $this->count_live('career_openings', array('status' => 'active')),
			'applications' => $this->application_model->count_filtered(array()),
		);
	}

	/** Twelve consecutive months ending this month, so empty months appear as zero. */
	private function month_keys()
	{
		$keys = array();
		for ($i = 11; $i >= 0; $i--)
		{
			$keys[date('Y-m', strtotime('first day of -'.$i.' months'))] = date('M Y', strtotime('first day of -'.$i.' months'));
		}
		return $keys;
	}

	/** JSON for the dashboard charts and stat tiles. Every figure comes from a live query. */
	public function chart_data()
	{
		$months = $this->month_keys();
		$start = array_keys($months)[0].'-01 00:00:00';
		$fill = array_fill_keys(array_keys($months), 0);

		$enquiries = $fill;
		$converted = $fill;
		$rows = $this->db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS total, SUM(status = 'converted') AS converted
			FROM contact_enquiries WHERE created_at >= ? AND archived_at IS NULL GROUP BY month", array($start))->result_array();
		foreach ($rows as $row)
		{
			$enquiries[$row['month']] = (int) $row['total'];
			$converted[$row['month']] = (int) $row['converted'];
		}

		$posts = $fill;
		$rows = $this->db->query("SELECT DATE_FORMAT(published_at, '%Y-%m') AS month, COUNT(*) AS total FROM blog_posts
			WHERE published_at >= ? AND published_at <= ? AND status IN ('published', 'scheduled') AND deleted_at IS NULL GROUP BY month", array($start, date('Y-m-d H:i:s')))->result_array();
		foreach ($rows as $row)
		{
			$posts[$row['month']] = (int) $row['total'];
		}

		$status = $this->enquiry_model->status_counts();
		$status_labels = array();
		foreach (array_keys($status) as $key)
		{
			$status_labels[] = humanize_status($key);
		}
		$total = array_sum($status);

		$this->json(array(
			'stats' => $this->stats_data(),
			'months' => array_values($months),
			'enquiries' => array_values($enquiries),
			'converted' => array_values($converted),
			'posts' => array_values($posts),
			'status_labels' => $status_labels,
			'status_values' => array_values($status),
			'conversion_rate' => $total ? round($status['converted'] / $total * 100, 1) : NULL,
			'conversion_total' => $total,
			'conversion_converted' => $status['converted'],
		));
	}

	/** Polled by the top bar for the unread enquiry badge. */
	public function notifications()
	{
		if ( ! $this->auth->can('enquiries'))
		{
			return $this->json(array('count' => 0, 'items' => array()));
		}
		$items = array();
		foreach ($this->enquiry_model->unread_latest(5) as $row)
		{
			$items[] = array('name' => $row['full_name'], 'service' => $row['service_required'], 'time' => admin_date($row['created_at']), 'url' => site_url('admin/enquiries/view/'.$row['id']));
		}
		$this->json(array('count' => $this->enquiry_model->unread_count(), 'items' => $items));
	}

	private function recent_activity()
	{
		return $this->db->select('activity_logs.*, admin_users.full_name')->join('admin_users', 'admin_users.id = activity_logs.admin_id', 'left')
			->order_by('activity_logs.id', 'DESC')->get('activity_logs', 8)->result_array();
	}

	/** Top-bar search across the modules this role can see. */
	public function search()
	{
		$term = mb_substr(trim((string) $this->input->get('q')), 0, 100);
		$results = array();
		if (mb_strlen($term) >= 2)
		{
			$sources = array(
				array('services', 'Services', 'services', 'services', 'title'),
				array('products', 'Products', 'products', 'products', 'title'),
				array('portfolio', 'Portfolio', 'portfolio_projects', 'portfolio', 'title'),
				array('case_studies', 'Case Studies', 'case_studies', 'case-studies', 'title'),
				array('blog', 'Blog', 'blog_posts', 'blog', 'title'),
				array('careers', 'Careers', 'career_openings', 'careers', 'title'),
			);
			foreach ($sources as $s)
			{
				if ( ! $this->auth->can($s[0]))
				{
					continue;
				}
				$rows = $this->db->select('id, title')->where('deleted_at IS NULL', NULL, FALSE)->like('title', $term)->get($s[2], 10)->result_array();
				foreach ($rows as $row)
				{
					$results[] = array('type' => $s[1], 'title' => $row['title'], 'url' => site_url('admin/'.$s[3].'/edit/'.$row['id']));
				}
			}
			if ($this->auth->can('enquiries'))
			{
				foreach ($this->enquiry_model->list_filtered(array('q' => $term), 10)->result_array() as $row)
				{
					$results[] = array('type' => 'Enquiry', 'title' => $row['reference_no'].' - '.$row['full_name'], 'url' => site_url('admin/enquiries/view/'.$row['id']));
				}
			}
			if ($this->auth->can('applications'))
			{
				foreach ($this->application_model->list_filtered(array('q' => $term), 10, 0) as $row)
				{
					$results[] = array('type' => 'Application', 'title' => $row['reference_no'].' - '.$row['full_name'], 'url' => site_url('admin/job-applications/view/'.$row['id']));
				}
			}
		}
		$this->render('admin/dashboard/search', array('page_title' => 'Search', 'term' => $term, 'results' => $results));
	}
}

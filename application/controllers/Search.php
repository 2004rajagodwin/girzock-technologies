<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Site search behind the search popup in the header. */
class Search extends Public_Controller {

	public function index()
	{
		$term = mb_substr(trim((string) $this->input->get('q')), 0, 100);
		$results = array();
		if (mb_strlen($term) >= 2)
		{
			$sources = array(
				array('Service', 'services', 'title', 'short_description', 'services', array('status' => 'active')),
				array('Product', 'products', 'title', 'short_description', 'products', array('status' => 'published')),
				array('Portfolio', 'portfolio_projects', 'title', 'short_description', 'portfolio', array('status' => 'published')),
				array('Case Study', 'case_studies', 'title', 'summary', 'case-studies', array('status' => 'published')),
				array('Career', 'career_openings', 'title', 'summary', 'careers', array('status' => 'active')),
			);
			foreach ($sources as $source)
			{
				list($type, $table, $title, $summary, $prefix, $where) = $source;
				$rows = $this->db->select($title.' AS title, '.$summary.' AS summary, slug')
					->where($where)->where('deleted_at IS NULL', NULL, FALSE)
					->group_start()->like($title, $term)->or_like($summary, $term)->group_end()
					->get($table, 10)->result_array();
				foreach ($rows as $row)
				{
					$results[] = array('type' => $type, 'title' => $row['title'], 'summary' => $row['summary'], 'url' => site_url($prefix.'/'.$row['slug']));
				}
			}
			$this->load->model('blog_model');
			foreach ($this->blog_model->list_public(array('q' => $term), 10) as $post)
			{
				$results[] = array('type' => 'Article', 'title' => $post['title'], 'summary' => $post['excerpt'], 'url' => site_url('blog/'.$post['slug']));
			}
		}
		$this->render('frontend/errors/search', array(
			'term' => $term,
			'results' => $results,
			'seo' => $this->seo->build(array('title' => 'Search | '.setting('company_name'), 'description' => setting('default_meta_description'), 'path' => 'search', 'robots' => 'noindex, follow')),
		));
	}
}

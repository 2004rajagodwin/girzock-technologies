<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends MY_Controller {

	public function index()
	{
		$this->load->library('seo');
		$this->load->model('blog_model');
		$urls = array();
		$add = function ($path, $modified = NULL) use (&$urls) {
			$urls[] = array('loc' => $this->seo->canonical($path), 'lastmod' => $modified ? date('Y-m-d', strtotime($modified)) : NULL);
		};
		$noindex = array();
		foreach ($this->db->select('entity_type, entity_key')->like('robots', 'noindex', 'after')->get('seo_metadata')->result_array() as $row)
		{
			$noindex[$row['entity_type'].':'.$row['entity_key']] = TRUE;
		}
		foreach (array('home' => '', 'about' => 'about', 'services' => 'services', 'products' => 'products', 'portfolio' => 'portfolio', 'case-studies' => 'case-studies', 'blog' => 'blog', 'careers' => 'careers', 'contact' => 'contact', 'areas-we-serve' => 'areas-we-serve', 'privacy-policy' => 'privacy-policy', 'terms' => 'terms', 'cookie-policy' => 'cookie-policy') as $key => $path)
		{
			if ( ! isset($noindex['page:'.$key]))
			{
				$add($path);
			}
		}
		$tables = array(
			array('services', 'services', 'active', 'service'),
			array('products', 'products', 'published', 'product'),
			array('portfolio_projects', 'portfolio', 'published', 'portfolio'),
			array('case_studies', 'case-studies', 'published', 'case_study'),
			array('career_openings', 'careers', 'active', 'career'),
		);
		foreach ($tables as $source)
		{
			$rows = $this->db->select('id, slug, updated_at')->where('status', $source[2])->where('deleted_at IS NULL', NULL, FALSE)->get($source[0])->result_array();
			foreach ($rows as $row)
			{
				if ( ! isset($noindex[$source[3].':'.$row['id']]))
				{
					$add($source[1].'/'.$row['slug'], $row['updated_at']);
				}
			}
		}
		foreach ($this->blog_model->list_public(array(), 5000) as $post)
		{
			if ( ! isset($noindex['blog:'.$post['id']]))
			{
				$add('blog/'.$post['slug'], $post['updated_at']);
			}
		}
		foreach ($this->blog_model->categories() as $category)
		{
			if ($this->blog_model->count_public(array('category_id' => $category['id'])) > 0)
			{
				$add('blog/category/'.$category['slug']);
			}
		}

		$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
		foreach ($urls as $url)
		{
			$xml .= '  <url><loc>'.htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc>';
			$xml .= $url['lastmod'] ? '<lastmod>'.$url['lastmod'].'</lastmod>' : '';
			$xml .= "</url>\n";
		}
		$xml .= '</urlset>'."\n";
		$this->output->set_content_type('application/xml', 'utf-8')->set_output($xml);
	}

	public function robots()
	{
		$this->load->library('seo');
		$lines = array('User-agent: *', 'Disallow: /admin/', 'Disallow: /search', 'Disallow: /contact/submit', 'Disallow: /careers/apply', '', 'Sitemap: '.$this->seo->canonical('sitemap.xml'), '');
		$this->output->set_content_type('text/plain', 'utf-8')->set_output(implode("\n", $lines));
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends MY_Controller {

	public function index()
	{
		$this->load->library('seo');
		$this->load->model(array('blog_model', 'case_study_model'));
		$urls = array();
		$seen = array();
		$add = function ($path, $modified = NULL) use (&$urls, &$seen) {
			$loc = $this->seo->canonical_for($path);
			if (isset($seen[$loc]))
			{
				return;
			}
			$seen[$loc] = TRUE;
			$urls[] = array('loc' => $loc, 'lastmod' => $modified ? date('Y-m-d', strtotime($modified)) : NULL);
		};
		// Left out: pages set to noindex, and pages whose canonical URL points at another address (that address is listed itself).
		$noindex = array();
		$forced_index = array();   // "index, follow" chosen explicitly in the admin overrides the sample/thin defaults below
		foreach ($this->db->select('entity_type, entity_key, robots, canonical_url')->group_start()->like('robots', 'noindex', 'after')->or_like('robots', 'index', 'after')->or_where('canonical_url IS NOT NULL', NULL, FALSE)->group_end()->get('seo_metadata')->result_array() as $row)
		{
			if (stripos((string) $row['robots'], 'index') === 0)
			{
				$forced_index[$row['entity_type'].':'.$row['entity_key']] = TRUE;
			}
			if (stripos((string) $row['robots'], 'noindex') === 0)
			{
				$noindex[$row['entity_type'].':'.$row['entity_key']] = TRUE;
			}
			elseif (trim((string) $row['canonical_url']) !== '')
			{
				$noindex[$row['entity_type'].':'.$row['entity_key']] = $row['canonical_url'];
			}
		}
		$skip = function ($key, $path) use (&$noindex) {
			if ( ! isset($noindex[$key]))
			{
				return FALSE;
			}
			if ($noindex[$key] === TRUE)
			{
				return TRUE;
			}
			// Compared by path, so the live-domain value saved for the homepage also matches on a local copy.
			$target = rtrim((string) parse_url($this->seo->resolve_canonical($path, $noindex[$key]), PHP_URL_PATH), '/');
			return $path === '' ? ! seo_is_home_url($this->seo->resolve_canonical($path, $noindex[$key])) : substr($target, -strlen('/'.$path)) !== '/'.$path;
		};
		foreach (array('home' => '', 'about' => 'about', 'services' => 'services', 'products' => 'products', 'portfolio' => 'portfolio', 'case-studies' => 'case-studies', 'blog' => 'blog', 'careers' => 'careers', 'contact' => 'contact', 'areas-we-serve' => 'areas-we-serve', 'privacy-policy' => 'privacy-policy', 'terms' => 'terms', 'cookie-policy' => 'cookie-policy') as $key => $path)
		{
			if ( ! $skip('page:'.$key, $path))
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
			$rows = $this->db->select($source[0] === 'case_studies' ? 'id, slug, updated_at, card_label, status_label' : 'id, slug, updated_at')->where('status', $source[2])->where('deleted_at IS NULL', NULL, FALSE)->get($source[0])->result_array();
			foreach ($rows as $row)
			{
				// Sample case studies are noindex by default, the same rule the page itself uses.
				$sample = $source[0] === 'case_studies' && Case_study_model::is_sample($row) && ! isset($forced_index['case_study:'.$row['id']]);
				if ( ! $sample && ! $skip($source[3].':'.$row['id'], $source[1].'/'.$row['slug']))
				{
					$add($source[1].'/'.$row['slug'], $row['updated_at']);
				}
			}
		}
		foreach ($this->blog_model->list_public(array(), 5000) as $post)
		{
			if ( ! $skip('blog:'.$post['id'], 'blog/'.$post['slug']))
			{
				$add('blog/'.$post['slug'], $post['updated_at']);
			}
		}
		foreach ($this->blog_model->categories() as $category)
		{
			// Categories with fewer than two articles are noindex by default, the same rule the page itself uses.
			$articles = $this->blog_model->count_public(array('category_id' => $category['id']));
			if (($articles >= 2 OR ($articles > 0 && isset($forced_index['blog_category:'.$category['id']]))) && ! $skip('blog_category:'.$category['id'], 'blog/category/'.$category['slug']))
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

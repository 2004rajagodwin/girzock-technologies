<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog_model');
		$this->config->load('girzock', FALSE, TRUE);
	}

	/** /blog, /blog/page/2 and /blog?q=term */
	public function index($page = 1)
	{
		$search = $this->search_term();
		$filters = $search !== '' ? array('q' => $search) : array();
		$this->listing($filters, (int) $page, 'blog', array(
			'heading' => $search !== '' ? 'Search' : 'Technology Blog',
			'banner' => 'Articles',
			'crumb' => $search !== '' ? 'Search: '.$search : 'Blog',
			'entity' => $page == 1 && $search === '' ? array('page', 'blog') : NULL,
			'title' => $search !== '' ? 'Search results for "'.$search.'" | '.setting('company_name') : 'Blog, page '.(int) $page.' | '.setting('company_name'),
			'description' => setting('default_meta_description'),
			'robots' => $search !== '' ? 'noindex, follow' : NULL,
		), $search);
	}

	public function category($slug = '', $page = 1)
	{
		$category = $this->blog_model->category_by_slug($slug);
		if ( ! $category)
		{
			$this->not_found();
		}
		$this->listing(array('category_id' => $category['id']), (int) $page, 'blog/category/'.$category['slug'], array(
			'heading' => $category['name'],
			'banner' => 'Articles',
			'crumb' => $category['name'],
			'title' => $category['name'].' Articles | '.setting('company_name'),
			'description' => $category['description'] ? $category['description'] : 'Articles about '.$category['name'].' from '.setting('company_name').'.',
			'active_category' => $category['slug'],
			'entity' => array('blog_category', $category['id']),
			// A category with fewer than two published articles mostly repeats one article, so it stays reachable
			// but out of search results. An explicit "index, follow" saved in the admin still wins.
			'robots' => $this->blog_model->count_public(array('category_id' => $category['id'])) >= 2 ? NULL : 'noindex, follow',
		));
	}

	public function tag($slug = '', $page = 0)
	{
		$tag = $this->blog_model->tag_by_slug($slug);
		if ( ! $tag)
		{
			$this->not_found();
		}
		$page = max(1, (int) $page, (int) $this->input->get('page'));
		$this->listing(array('tag_id' => $tag['id']), $page, 'blog/tag/'.$tag['slug'], array(
			'heading' => 'Tagged: '.$tag['name'],
			'banner' => 'Articles',
			'crumb' => $tag['name'],
			// Worded differently from category pages, so a tag and a category with the same name never share a title.
			'title' => 'Posts Tagged '.$tag['name'].' | '.setting('company_name'),
			'description' => 'Articles tagged '.$tag['name'].' from '.setting('company_name').'.',
			'robots' => 'noindex, follow',
		));
	}

	private function search_term()
	{
		return mb_substr(trim((string) $this->input->get('q')), 0, 100);
	}

	private function listing(array $filters, $page, $base_path, array $meta, $search = '')
	{
		$page = max(1, $page);
		$per_page = (int) $this->config->item('gz_blog_per_page');
		$total = $this->blog_model->count_public($filters);
		$pages = max(1, (int) ceil($total / $per_page));
		if ($page > $pages)
		{
			$this->not_found();
		}
		if ($page > 1 && $search === '')
		{
			// Later pages list different articles, so they get their own title, description and heading.
			$meta['title'] = $meta['heading'].', page '.$page.' | '.setting('company_name');
			$meta['description'] = 'Page '.$page.' of '.$meta['heading'].' articles from '.setting('company_name').', with practical guides on websites, software and running a business online.';
			$meta['heading'] .= ': Page '.$page;
			unset($meta['entity']);
		}
		$posts = $this->blog_model->list_public($filters, $per_page, ($page - 1) * $per_page);

		$query = $search !== '' ? '?q='.rawurlencode($search) : '';
		$page_url = function ($n) use ($base_path, $query) {
			return $n === 1 ? $base_path.$query : $base_path.'/page/'.$n.$query;
		};
		$seo_options = array('webpage_type' => 'CollectionPage', 
			'title' => $meta['title'],
			'description' => $meta['description'],
			'path' => $page === 1 ? $base_path : $page_url($page),
			'breadcrumbs' => array('Home' => '', 'Blog' => 'blog', $meta['crumb'] => NULL),
			'prev' => $page > 1 ? $this->seo->canonical($page_url($page - 1)) : NULL,
			'next' => $page < $pages ? $this->seo->canonical($page_url($page + 1)) : NULL,
		);
		if ($base_path === 'blog' && $meta['crumb'] === 'Blog')
		{
			$seo_options['breadcrumbs'] = array('Home' => '', 'Blog' => NULL);
		}
		if ( ! empty($meta['entity']))
		{
			$seo_options['entity'] = $meta['entity'];
		}
		if ( ! empty($meta['robots']))
		{
			$seo_options['robots'] = $meta['robots'];
		}

		$pagination = '';
		if ($pages > 1)
		{
			for ($n = 1; $n <= $pages; $n++)
			{
				$pagination .= $n === $page
					? '<span class="current" aria-current="page">'.$n.'</span>'
					: '<a href="'.e(site_url($page_url($n))).'">'.$n.'</a>';
			}
		}
		$crumb_tail = $meta['crumb'] === 'Blog'
			? '<li>Blog</li>'
			: '<li><a href="'.site_url('blog').'">Blog</a></li><li>/</li><li>'.e($meta['crumb']).'</li>';

		$this->render('frontend/blog/index', array(
			'seo' => $this->seo->build($seo_options),
			'posts' => $posts,
			'show_featured' => $page === 1 && $search === '' && $base_path === 'blog',
			'search' => $search,
			'pagination' => $pagination,
			'blog_categories' => $this->blog_model->categories(),
			'active_category' => isset($meta['active_category']) ? $meta['active_category'] : NULL,
			'page_heading' => $meta['heading'],
			'banner_label' => $meta['banner'],
			'breadcrumb_tail' => $crumb_tail,
		));
	}

	public function detail($slug = '')
	{
		$post = $this->blog_model->find_public($slug);
		$is_preview = FALSE;
		if ( ! $post && $this->preview_allowed('blog'))
		{
			$post = $this->blog_model->find_for_preview($slug);
			$is_preview = (bool) $post;
		}
		if ( ! $post)
		{
			$this->not_found();
		}
		$related = $this->blog_model->related($post, 3);
		$exclude = array_merge(array($post['id']), array_column($related, 'id'));
		$path = 'blog/'.$post['slug'];
		// One canonical for the link tag, og:url, sharing links and the BlogPosting markup: the post's own slug URL,
		// or a valid manual override saved in the admin.
		$stored = $this->settings_model->seo('blog', $post['id']);
		$noindex = $is_preview OR (isset($stored['robots']) && stripos((string) $stored['robots'], 'noindex') === 0);
		$canonical = $this->seo->resolve_canonical($path, isset($stored['canonical_url']) ? $stored['canonical_url'] : '', $noindex);
		$description = $post['excerpt'] ? $post['excerpt'] : plain_excerpt($post['content']);
		$image = $this->seo->absolute_media($post['featured_image']);
		$this->render('frontend/blog/detail', array(
			'post' => $post,
			'is_preview' => $is_preview,
			'related' => $related,
			'latest' => $this->blog_model->latest_excluding($exclude, 4),
			'categories' => $this->blog_model->categories(),
			'previous' => $this->blog_model->neighbour($post, 'previous'),
			'next' => $this->blog_model->neighbour($post, 'next'),
			'share_url' => $canonical,
			'seo' => $this->seo->build(array(
				'entity' => array('blog', $post['id']),
				'is_preview' => $is_preview,
				'title' => $post['title'].' | '.setting('company_name'),
				'description' => $description,
				'path' => $path,
				'image' => $post['featured_image'],
				'og_type' => 'article',
				'breadcrumbs' => array('Home' => '', 'Blog' => 'blog', $post['title'] => NULL),
				'schema' => array(array('@context' => 'https://schema.org', '@type' => 'BlogPosting', 'headline' => $post['title'], 'description' => $description, 'image' => $image,
					'datePublished' => date('c', strtotime($post['published_at'])), 'dateModified' => date('c', strtotime($post['updated_at'])),
					'author' => array('@type' => 'Organization', 'name' => $post['author_name']), 'publisher' => $this->seo->provider(),
					'url' => $canonical, 'mainEntityOfPage' => $canonical)),
			)),
		));
	}
}

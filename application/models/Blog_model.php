<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * A post is public when it is "published" or "scheduled" and its publish time has passed, so
 * scheduled posts go live on time with no cron job.
 */
class Blog_model extends MY_Model {

	protected $table = 'blog_posts';
	protected $search_columns = array('blog_posts.title', 'blog_posts.excerpt');
	protected $default_order = array('blog_posts.created_at' => 'DESC');

	private function select_public()
	{
		$this->db->select('blog_posts.*, blog_categories.name AS category_name, blog_categories.slug AS category_slug')
			->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
			->where('blog_posts.deleted_at IS NULL', NULL, FALSE)
			->where_in('blog_posts.status', array('published', 'scheduled'))
			->where('blog_posts.published_at <=', date('Y-m-d H:i:s'));
		return $this->db;
	}

	private function apply_public_filters(array $filters)
	{
		if ( ! empty($filters['category_id']))
		{
			$this->db->where('blog_posts.category_id', (int) $filters['category_id']);
		}
		if ( ! empty($filters['tag_id']))
		{
			$this->db->join('blog_post_tags', 'blog_post_tags.post_id = blog_posts.id')->where('blog_post_tags.tag_id', (int) $filters['tag_id']);
		}
		if ( ! empty($filters['q']))
		{
			$this->db->group_start()
				->like('blog_posts.title', $filters['q'])
				->or_like('blog_posts.excerpt', $filters['q'])
				->or_like('blog_posts.content', $filters['q'])
				->group_end();
		}
	}

	public function count_public(array $filters = array())
	{
		$this->select_public();
		$this->apply_public_filters($filters);
		return (int) $this->db->count_all_results($this->table);
	}

	public function list_public(array $filters, $limit, $offset = 0)
	{
		$this->select_public();
		$this->apply_public_filters($filters);
		$this->db->order_by('blog_posts.published_at', 'DESC')->order_by('blog_posts.id', 'DESC');
		$posts = $this->db->get($this->table, (int) $limit, (int) $offset)->result_array();
		return $this->attach_tags($posts);
	}

	public function find_public($slug)
	{
		$this->select_public();
		$this->db->where('blog_posts.slug', $slug);
		$post = $this->db->get($this->table, 1)->row_array();
		if ( ! $post)
		{
			return NULL;
		}
		$posts = $this->attach_tags(array($post));
		return $posts[0];
	}

	public function find_for_preview($slug)
	{
		$post = $this->db->select('blog_posts.*, blog_categories.name AS category_name, blog_categories.slug AS category_slug')
			->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
			->where('blog_posts.deleted_at IS NULL', NULL, FALSE)->where('blog_posts.slug', $slug)
			->get($this->table, 1)->row_array();
		if ( ! $post)
		{
			return NULL;
		}
		$post['published_at'] = $post['published_at'] ? $post['published_at'] : date('Y-m-d H:i:s');
		$posts = $this->attach_tags(array($post));
		return $posts[0];
	}

	/** Adds tag_names and tags to each post with a single extra query. */
	private function attach_tags(array $posts)
	{
		if ( ! $posts)
		{
			return $posts;
		}
		$map = array();
		$rows = $this->db->select('blog_post_tags.post_id, blog_tags.name, blog_tags.slug')
			->join('blog_tags', 'blog_tags.id = blog_post_tags.tag_id')
			->where_in('blog_post_tags.post_id', array_column($posts, 'id'))
			->order_by('blog_post_tags.sort_order', 'ASC')
			->get('blog_post_tags')->result_array();
		foreach ($rows as $row)
		{
			$map[$row['post_id']][] = $row;
		}
		foreach ($posts as &$post)
		{
			$post['tags'] = isset($map[$post['id']]) ? $map[$post['id']] : array();
			$post['tag_names'] = array_column($post['tags'], 'name');
		}
		return $posts;
	}

	/** Same category first, then the newest of the rest. */
	public function related(array $post, $limit = 3)
	{
		$this->select_public();
		$this->db->where('blog_posts.id !=', (int) $post['id']);
		$this->db->order_by('(blog_posts.category_id = '.(int) $post['category_id'].')', 'DESC', FALSE)->order_by('blog_posts.published_at', 'DESC');
		return $this->attach_tags($this->db->get($this->table, (int) $limit)->result_array());
	}

	public function latest_excluding(array $exclude_ids, $limit = 3)
	{
		$this->select_public();
		if ($exclude_ids)
		{
			$this->db->where_not_in('blog_posts.id', array_map('intval', $exclude_ids));
		}
		$this->db->order_by('blog_posts.published_at', 'DESC');
		return $this->db->get($this->table, (int) $limit)->result_array();
	}

	public function neighbour(array $post, $direction)
	{
		$this->select_public();
		$older = $direction === 'previous';
		$this->db->where('blog_posts.id !=', (int) $post['id'])
			->where('blog_posts.published_at '.($older ? '<=' : '>='), $post['published_at'])
			->order_by('blog_posts.published_at', $older ? 'DESC' : 'ASC');
		return $this->db->get($this->table, 1)->row_array();
	}

	public function categories()
	{
		return $this->db->order_by('sort_order', 'ASC')->order_by('name', 'ASC')->get('blog_categories')->result_array();
	}

	public function category_by_slug($slug)
	{
		return $this->db->get_where('blog_categories', array('slug' => $slug), 1)->row_array();
	}

	public function tag_by_slug($slug)
	{
		return $this->db->get_where('blog_tags', array('slug' => $slug), 1)->row_array();
	}

	public function all_tags()
	{
		return $this->db->order_by('name', 'ASC')->get('blog_tags')->result_array();
	}

	public function post_tag_names($post_id)
	{
		$rows = $this->db->select('blog_tags.name')->join('blog_tags', 'blog_tags.id = blog_post_tags.tag_id')
			->where('blog_post_tags.post_id', (int) $post_id)->order_by('blog_post_tags.sort_order', 'ASC')->get('blog_post_tags')->result_array();
		return array_column($rows, 'name');
	}

	/** Replaces a post's tags from a list of names, creating new tags as needed. */
	public function sync_tags($post_id, array $names)
	{
		$this->db->trans_start();
		$this->db->where('post_id', (int) $post_id)->delete('blog_post_tags');
		$seen = array();
		foreach (array_values($names) as $order => $name)
		{
			$name = trim(strip_tags($name));
			if ($name === '' OR mb_strlen($name) > 80)
			{
				continue;
			}
			$slug = make_slug($name);
			if (isset($seen[$slug]))
			{
				continue;
			}
			$seen[$slug] = TRUE;
			$tag = $this->tag_by_slug($slug);
			if ($tag)
			{
				$tag_id = $tag['id'];
			}
			else
			{
				$this->db->insert('blog_tags', array('name' => $name, 'slug' => $slug));
				$tag_id = $this->db->insert_id();
			}
			$this->db->insert('blog_post_tags', array('post_id' => (int) $post_id, 'tag_id' => (int) $tag_id, 'sort_order' => $order));
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}

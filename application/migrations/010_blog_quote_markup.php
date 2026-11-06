<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * A pull quote in six older articles was marked up as a heading, which made the article's headings
 * jump from H1 to H4. The words and the look stay the same; only the tag changes. A quote an admin
 * has already edited differently is left alone, and each article's modified date is kept.
 */
class Migration_Blog_quote_markup extends CI_Migration {

	public function up()
	{
		$posts = $this->db->select('id, content')->like('content', '<div class="quote-box">', 'both', FALSE)->get('blog_posts')->result_array();
		$this->db->trans_start();
		foreach ($posts as $post)
		{
			$content = preg_replace('#(<div class="quote-box">\s*<img[^>]*>\s*)<h4 class="title">(.*?)</h4>#s', '$1<p class="title">$2</p>', $post['content'], -1, $count);
			if ($count && $content !== NULL)
			{
				$this->db->set('content', $content)->set('updated_at', 'updated_at', FALSE)->where('id', $post['id'])->update('blog_posts');
			}
		}
		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The article quote migration could not be applied, and no changes were kept.');
		}
	}

	public function down()
	{
		// Only a tag changes and nothing depends on the old one, so this is not reverted automatically.
	}
}

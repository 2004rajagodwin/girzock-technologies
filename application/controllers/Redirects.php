<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** 301 redirects from the old static .html URLs to their clean equivalents. */
class Redirects extends MY_Controller {

	public function legacy($page = 'home')
	{
		$allowed = array('about', 'services', 'products', 'portfolio', 'case-studies', 'blog', 'careers', 'contact');
		$target = in_array($page, $allowed, TRUE) ? $page : '';
		$query = (string) $this->input->server('QUERY_STRING');
		redirect(site_url($target).($query !== '' ? '?'.$query : ''), 'location', 301);
	}
}

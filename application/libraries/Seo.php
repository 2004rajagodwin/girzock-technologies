<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Builds page metadata and JSON-LD. Business facts come only from Website Settings, so the
 * structured data can never state something the company has not entered.
 */
class Seo {

	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/** The public origin used for canonical URLs; PUBLIC_URL in .env or the base URL. */
	public function canonical($path = '')
	{
		return seo_public_url($path);
	}

	/** The clean, indexable address for a path. See seo_canonical_for() in the girzock helper. */
	public function canonical_for($path)
	{
		return seo_canonical_for($path);
	}

	public function canonical_error($url, $is_home = FALSE)
	{
		return seo_canonical_error($url, $is_home);
	}

	public function resolve_canonical($path, $stored_url = '', $noindex = FALSE)
	{
		return seo_resolve_canonical($path, $stored_url, $noindex);
	}

	public function absolute_media($path)
	{
		if (preg_match('#^https?://#i', (string) $path))
		{
			// A saved address on this website (local, http, www) is rewritten to the public origin; other sites are kept.
			$own = seo_first_party_path($path);
			return $own === NULL ? $path : $this->canonical($own);
		}
		return $this->canonical(ltrim((string) $path, '/'));
	}

	/**
	 * @param array $opts title, description, path, image, og_type, robots, entity (array(type, key)),
	 *                    breadcrumbs (label => path), schema (extra JSON-LD), prev, next
	 */
	public function build(array $opts = array())
	{
		$settings = $this->CI->settings_model;
		$stored = array();
		if ( ! empty($opts['entity']))
		{
			$stored = $settings->seo($opts['entity'][0], $opts['entity'][1]);
		}
		$pick = function ($stored_key, $opt_key, $default) use ($stored, $opts) {
			if ( ! empty($stored[$stored_key])) { return $stored[$stored_key]; }
			return empty($opts[$opt_key]) ? $default : $opts[$opt_key];
		};

		$path = trim(preg_replace('/[?#].*$/s', '', isset($opts['path']) ? (string) $opts['path'] : uri_string()), '/');
		$robots_value = empty($opts['is_preview']) ? $pick('robots', 'robots', 'index, follow') : 'noindex, nofollow';
		$indexable = stripos($robots_value, 'noindex') === FALSE;
		$canonical = $this->resolve_canonical($path, isset($stored['canonical_url']) ? $stored['canonical_url'] : '', ! $indexable);
		$image = $pick('og_image', 'image', $settings->get('default_og_image'));
		$title = $pick('meta_title', 'title', $settings->get('default_meta_title'));
		$description = $pick('meta_description', 'description', $settings->get('default_meta_description'));
		$og_title = empty($stored['og_title']) ? $title : $stored['og_title'];
		$og_description = empty($stored['og_description']) ? $description : $stored['og_description'];

		$schema = array($this->organization());
		if ($path === '' OR $path === '/')
		{
			$schema[] = $this->website();
		}
		$schema[] = array('@context' => 'https://schema.org', '@type' => empty($opts['webpage_type']) ? 'WebPage' : $opts['webpage_type'], 'name' => $title, 'description' => $description, 'url' => $canonical);
		if ( ! empty($opts['breadcrumbs']))
		{
			$schema[] = $this->breadcrumbs($opts['breadcrumbs']);
		}
		if ( ! empty($opts['schema']))
		{
			foreach ($opts['schema'] as $extra)
			{
				$schema[] = $extra;
			}
		}

		$is_home = ($path === '' OR $path === '/');
		$robots = $robots_value;
		$size = $this->image_size($image);
		$image_alt = ! empty($opts['image_alt']) ? $opts['image_alt'] : ($is_home && $settings->get('home_og_image_alt') ? $settings->get('home_og_image_alt') : $og_title);

		return array(
			'title' => $title,
			'description' => $description,
			'og_title' => $og_title,
			'og_description' => $og_description,
			'twitter_title' => $is_home && $settings->get('home_twitter_title') ? $settings->get('home_twitter_title') : $og_title,
			'twitter_description' => $is_home && $settings->get('home_twitter_description') ? $settings->get('home_twitter_description') : $og_description,
			'canonical' => $canonical,
			// Only indexable pages print a canonical link; a noindex page with a canonical sends mixed signals.
			'indexable' => $indexable,
			'image' => $this->absolute_media($image),
			'image_alt' => $image_alt,
			'image_width' => $size ? $size[0] : NULL,
			'image_height' => $size ? $size[1] : NULL,
			'og_type' => empty($opts['og_type']) ? 'website' : $opts['og_type'],
			'twitter_card' => $image === $settings->get('default_og_image') ? 'summary' : 'summary_large_image',
			// Indexable pages also allow large image previews and full snippets in Google
			'robots' => $robots === 'index, follow' ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' : $robots,
			'keywords' => $is_home ? (string) $settings->get('home_meta_keywords') : '',
			'is_home' => $is_home,
			'prev' => empty($opts['prev']) ? NULL : $opts['prev'],
			'next' => empty($opts['next']) ? NULL : $opts['next'],
			'schema' => $schema,
		);
	}

	/** Width and height of a local sharing image, so social sites can lay out the preview before loading it. */
	private function image_size($path)
	{
		$path = (string) $path;
		if ($path === '' OR preg_match('#^https?://#i', $path) OR strpos($path, '..') !== FALSE)
		{
			return NULL;
		}
		$file = FCPATH.ltrim(preg_replace('/\?.*$/', '', $path), '/');
		$info = is_file($file) ? @getimagesize($file) : FALSE;
		return $info ? array($info[0], $info[1]) : NULL;
	}

	/** Organization plus LocalBusiness, using verified settings only. */
	public function organization()
	{
		$s = $this->CI->settings_model;
		$same_as = array();
		foreach ($s->public_socials() as $link)
		{
			if ($link['platform'] !== 'whatsapp')
			{
				$same_as[] = $link['url'];
			}
		}
		// The square-ish brand logo at the site root, kept at the same address as on the current live site
		$logo = is_file(FCPATH.'girzock-logo.png') ? 'girzock-logo.png' : $s->get('default_og_image');
		$org = array(
			'@context' => 'https://schema.org',
			'@type' => array('Organization', 'ProfessionalService'),
			'name' => $s->get('company_name'),
			'url' => $this->canonical(),
			'logo' => $this->absolute_media($logo),
			'image' => $this->absolute_media($logo),
			'description' => 'GIRZOCK Technologies provides software development, website design, web application development, cloud computing and AWS cloud solutions.',
			'email' => $s->get('contact_email'),
			'telephone' => preg_replace('/[^\d+]/', '', (string) $s->get('phone')),
			'slogan' => $s->get('tagline'),
			'address' => array('@type' => 'PostalAddress', 'addressLocality' => $s->get('address_locality'), 'addressRegion' => $s->get('address_region'), 'addressCountry' => $s->get('address_country')),
			'areaServed' => $this->area_served(),
		);
		if ($same_as)
		{
			$org['sameAs'] = $same_as;
		}
		return $org;
	}

	/** Places served. The business has one location; these are service areas, not offices. */
	public function area_served()
	{
		// Thisaiyanvilai and Sattankulam are towns (Place); the rest are cities. Kerala's capital is a nearby service area.
		$areas = array(array('@type' => 'Place', 'name' => 'Thisaiyanvilai'), array('@type' => 'City', 'name' => 'Tirunelveli'), array('@type' => 'Place', 'name' => 'Sattankulam'));
		foreach (array('Thoothukudi', 'Nagercoil', 'Kanniyakumari', 'Thiruvananthapuram') as $place)
		{
			$areas[] = array('@type' => 'City', 'name' => $place);
		}
		$areas[] = array('@type' => 'State', 'name' => 'Tamil Nadu');
		$areas[] = array('@type' => 'Country', 'name' => 'India');
		return $areas;
	}

	public function website()
	{
		return array(
			'@context' => 'https://schema.org', '@type' => 'WebSite',
			'name' => setting('company_name'), 'url' => $this->canonical(),
			'potentialAction' => array('@type' => 'SearchAction', 'target' => $this->canonical('search').'?q={search_term_string}', 'query-input' => 'required name=search_term_string'),
		);
	}

	/** @param array $crumbs label => path; a NULL path is the current page. */
	public function breadcrumbs(array $crumbs)
	{
		$items = array();
		$position = 1;
		foreach ($crumbs as $label => $path)
		{
			$item = array('@type' => 'ListItem', 'position' => $position++, 'name' => $label);
			if ($path !== NULL)
			{
				$item['item'] = $this->canonical($path);
			}
			$items[] = $item;
		}
		return array('@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items);
	}

	public function provider()
	{
		return array('@type' => 'Organization', 'name' => setting('company_name'), 'url' => $this->canonical());
	}
}

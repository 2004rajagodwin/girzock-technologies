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
		$public = trim((string) girzock_env('PUBLIC_URL', ''));
		$path = ltrim($path, '/');
		return $public !== '' ? rtrim($public, '/').'/'.$path : site_url($path);
	}

	public function absolute_media($path)
	{
		if (preg_match('#^https?://#i', (string) $path))
		{
			return $path;
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

		$path = isset($opts['path']) ? $opts['path'] : uri_string();
		$canonical = ! empty($stored['canonical_url']) ? $stored['canonical_url'] : $this->canonical($path);
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

		return array(
			'title' => $title,
			'description' => $description,
			'og_title' => $og_title,
			'og_description' => $og_description,
			'canonical' => $canonical,
			'image' => $this->absolute_media($image),
			'og_type' => empty($opts['og_type']) ? 'website' : $opts['og_type'],
			'twitter_card' => $image === $settings->get('default_og_image') ? 'summary' : 'summary_large_image',
			'robots' => empty($opts['is_preview']) ? $pick('robots', 'robots', 'index, follow') : 'noindex, nofollow',
			'prev' => empty($opts['prev']) ? NULL : $opts['prev'],
			'next' => empty($opts['next']) ? NULL : $opts['next'],
			'schema' => $schema,
		);
	}

	/** Organization plus LocalBusiness, using verified settings only. */
	public function organization()
	{
		$s = $this->CI->settings_model;
		$same_as = array();
		foreach ($s->socials() as $link)
		{
			if ($link['url'] && $link['platform'] !== 'whatsapp')
			{
				$same_as[] = $link['url'];
			}
		}
		$org = array(
			'@context' => 'https://schema.org',
			'@type' => array('Organization', 'ProfessionalService'),
			'name' => $s->get('company_name'),
			'url' => $this->canonical(),
			'logo' => $this->absolute_media($s->get('default_og_image')),
			'email' => $s->get('contact_email'),
			'telephone' => $s->get('phone'),
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
		$areas = array();
		foreach (array('Thisaiyanvilai', 'Tirunelveli', 'Thoothukudi', 'Nagercoil', 'Kanyakumari', 'Thiruvananthapuram') as $place)
		{
			$areas[] = array('@type' => 'City', 'name' => $place);
		}
		$areas[] = array('@type' => 'State', 'name' => 'Tamil Nadu');
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

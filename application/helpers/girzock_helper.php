<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* -------------------------------------------------------------------------
 * Output
 * ---------------------------------------------------------------------- */

/** HTML-escapes a value for output. Every dynamic value in a view goes through this. */
function e($value)
{
	return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Public URL for a file under the web root. */
function asset($path)
{
	$path = ltrim((string) $path, '/');
	if (preg_match('/\.(css|js)$/', $path) && is_file(FCPATH.$path))
	{
		return base_url($path).'?v='.filemtime(FCPATH.$path);
	}
	return base_url($path);
}

/** Resolves a stored media value: an absolute http(s) URL or a path relative to the web root. */
function media_url($path)
{
	$path = trim((string) $path);
	if ($path === '')
	{
		return '';
	}
	return preg_match('#^https?://#i', $path) ? $path : base_url(ltrim($path, '/'));
}

/**
 * The browser icon: the one uploaded in the admin panel when it exists, otherwise the default file.
 * The file's date is added to the address, so a browser notices when the icon changes.
 */
function site_favicon()
{
	$default = 'assets/logos/girzock-favv.webp';
	$path = trim((string) setting('favicon'));
	$remote = (bool) preg_match('#^https?://#i', $path);
	if ($path === '' OR ( ! $remote && ! is_file(FCPATH.ltrim($path, '/'))))
	{
		$path = $default;
	}
	$types = array('png' => 'image/png', 'webp' => 'image/webp', 'ico' => 'image/x-icon', 'svg' => 'image/svg+xml', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg');
	$extension = strtolower(pathinfo(parse_url($path, PHP_URL_PATH), PATHINFO_EXTENSION));
	$file = FCPATH.ltrim($path, '/');
	return array(
		'url' => media_url($path).( ! $remote && is_file($file) ? '?v='.filemtime($file) : ''),
		'type' => isset($types[$extension]) ? $types[$extension] : 'image/png',
	);
}

/** srcset and sizes attributes for a WebP image that has -NNNw.webp copies beside it; empty otherwise. */
function media_srcset($path, $sizes)
{
	static $sets = array();
	$path = ltrim(trim((string) $path), '/');
	if ( ! isset($sets[$path]))
	{
		$sets[$path] = array();
		if (preg_match('#^assets/[\w./-]+\.webp$#', $path) && strpos($path, '..') === FALSE && is_file(FCPATH.$path))
		{
			$base = substr($path, 0, -5);
			$size = @getimagesize(FCPATH.$path);
			if ($size)
			{
				$sets[$path][$size[0]] = $path;
			}
			foreach ((array) glob(FCPATH.$base.'-*w.webp') as $file)
			{
				if (preg_match('/-(\d+)w\.webp$/', $file, $match))
				{
					$sets[$path][(int) $match[1]] = $base.'-'.$match[1].'w.webp';
				}
			}
			ksort($sets[$path]);
		}
	}
	if (count($sets[$path]) < 2)
	{
		return '';
	}
	$parts = array();
	foreach ($sets[$path] as $width => $file)
	{
		$parts[] = media_url($file).' '.$width.'w';
	}
	return ' srcset="'.e(implode(', ', $parts)).'" sizes="'.e($sizes).'"';
}

/** Prints trusted, already-sanitised rich text and makes relative asset paths absolute. */
function rich_text($html)
{
	$html = str_replace(array('src="assets/', "src='assets/"), array('src="'.base_url('assets/'), "src='".base_url('assets/')), (string) $html);
	// Internal links are stored as site:path so that they work on any domain.
	return preg_replace_callback('/href="site:([a-z0-9\/-]*)"/', function ($m) { return 'href="'.site_url($m[1]).'"'; }, $html);
}

/** Splits a one-item-per-line text field into a clean array. */
function text_lines($text)
{
	return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $text)), 'strlen'));
}

function setting($key, $default = '')
{
	return get_instance()->settings_model->get($key, $default);
}

/** The hidden CSRF field for a form. */
function csrf_field()
{
	$CI =& get_instance();
	return '<input type="hidden" name="'.e($CI->security->get_csrf_token_name()).'" value="'.e($CI->security->get_csrf_hash()).'">';
}

/* -------------------------------------------------------------------------
 * Navigation
 * ---------------------------------------------------------------------- */

/** class="active" output for the current top-level section of the inner-page menu. */
function nav_active($section)
{
	$CI =& get_instance();
	return ($CI->uri->segment(1) === $section) ? " class='active'" : '';
}

/**
 * URL of the service that owns an old in-page anchor, such as #web-design. Falls back to
 * the listing page, so links in the page copy survive a service being renamed or disabled.
 */
function service_link($anchor)
{
	$CI =& get_instance();
	foreach ($CI->settings_model->active_services() as $service)
	{
		if ($service['legacy_anchor'] === $anchor)
		{
			return site_url('services/'.$service['slug']);
		}
	}
	return site_url('services').'#'.rawurlencode($anchor);
}

/* -------------------------------------------------------------------------
 * Text and identifiers
 * ---------------------------------------------------------------------- */

function make_slug($text)
{
	$text = html_entity_decode((string) $text, ENT_QUOTES, 'UTF-8');
	$text = strtolower(trim($text));
	if (function_exists('iconv'))
	{
		$converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
		$text = ($converted !== FALSE) ? $converted : $text;
	}
	$text = preg_replace('/[^a-z0-9]+/', '-', $text);
	$text = trim($text, '-');
	return $text === '' ? 'item' : substr($text, 0, 170);
}

/** Estimates reading time at 200 words a minute. */
function reading_minutes($html)
{
	$words = str_word_count(strip_tags((string) $html));
	return max(1, (int) ceil($words / 200));
}

/** Plain text excerpt from rich text. */
function plain_excerpt($html, $limit = 160)
{
	$text = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $html), ENT_QUOTES, 'UTF-8')));
	if (mb_strlen($text) <= $limit)
	{
		return $text;
	}
	$cut = mb_substr($text, 0, $limit);
	$space = mb_strrpos($cut, ' ');
	return rtrim($space ? mb_substr($cut, 0, $space) : $cut, " ,.;:").'...';
}

/** Splits one-per-line "Title | Text" content into pairs. */
function pipe_rows($text)
{
	$rows = array();
	foreach (text_lines($text) as $line)
	{
		$parts = array_map('trim', explode('|', $line, 2));
		$rows[] = array($parts[0], isset($parts[1]) ? $parts[1] : '');
	}
	return $rows;
}

/** Validates a stored file path: relative to the web root, inside assets/, no traversal. */
function is_safe_asset_path($path)
{
	$path = (string) $path;
	return strpos($path, '..') === FALSE && (bool) preg_match('#^assets/[A-Za-z0-9_\-./]+$#', $path);
}

function is_safe_http_url($url)
{
	return (bool) filter_var($url, FILTER_VALIDATE_URL) && (bool) preg_match('#^https?://#i', (string) $url);
}

/** Removes characters that could inject email headers. */
function clean_header_value($value)
{
	return trim(str_replace(array("\r", "\n", "\0", '%0a', '%0d', '%0A', '%0D'), ' ', (string) $value));
}

function humanize_status($status)
{
	return ucwords(str_replace(array('_', '-'), ' ', (string) $status));
}

/* -------------------------------------------------------------------------
 * Secrets stored in the database (SMTP password)
 * ---------------------------------------------------------------------- */

function secret_encrypt($plain)
{
	$key = girzock_key_bytes('SECRET_BOX_KEY');
	if (strlen($key) !== 32)
	{
		return FALSE;
	}
	$iv = random_bytes(12);
	$tag = '';
	$cipher = openssl_encrypt($plain, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
	return $cipher === FALSE ? FALSE : base64_encode($iv.$tag.$cipher);
}

function secret_decrypt($stored)
{
	$key = girzock_key_bytes('SECRET_BOX_KEY');
	$raw = base64_decode((string) $stored, TRUE);
	if (strlen($key) !== 32 OR $raw === FALSE OR strlen($raw) < 29)
	{
		return '';
	}
	$plain = openssl_decrypt(substr($raw, 28), 'aes-256-gcm', $key, OPENSSL_RAW_DATA, substr($raw, 0, 12), substr($raw, 12, 16));
	return $plain === FALSE ? '' : $plain;
}

/* -------------------------------------------------------------------------
 * Admin UI
 * ---------------------------------------------------------------------- */

function status_badge($status)
{
	$map = array(
		'new' => 'info', 'contacted' => 'primary', 'in_progress' => 'warning', 'follow_up' => 'purple',
		'converted' => 'success', 'closed' => 'muted', 'active' => 'success', 'published' => 'success',
		'draft' => 'muted', 'disabled' => 'muted', 'archived' => 'muted', 'scheduled' => 'info',
		'unpublished' => 'warning', 'reviewing' => 'primary', 'shortlisted' => 'purple', 'interview' => 'warning',
		'offered' => 'info', 'hired' => 'success', 'rejected' => 'danger', 'sent' => 'success',
		'failed' => 'danger', 'skipped' => 'warning', 'pending' => 'muted',
	);
	$tone = isset($map[$status]) ? $map[$status] : 'muted';
	return '<span class="gz-badge gz-badge-'.$tone.'">'.e(humanize_status($status)).'</span>';
}

function admin_date($datetime, $format = 'd M Y, H:i')
{
	return $datetime ? date($format, strtotime($datetime)) : '-';
}

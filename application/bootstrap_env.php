<?php
/**
 * Loads secrets from a .env file that lives OUTSIDE the public web root, and checks that
 * the configuration is usable before CodeIgniter starts.
 *
 * Lookup order:
 *   1. the GIRZOCK_PRIVATE_DIR server environment variable
 *   2. a "girzock-private" folder next to the project folder
 *
 * Nothing in this file holds a credential. See docs/env.example for the keys.
 * Log messages name settings but never contain their values.
 */
defined('GIRZOCK_BOOT') OR exit('No direct script access allowed');

/** The GIRZOCK_PRIVATE_DIR setting. Apache can prefix variables with REDIRECT_ after a rewrite. */
function girzock_private_dir_setting()
{
	$value = getenv('GIRZOCK_PRIVATE_DIR');
	if ($value)
	{
		return $value;
	}
	foreach (array('GIRZOCK_PRIVATE_DIR', 'REDIRECT_GIRZOCK_PRIVATE_DIR') as $name)
	{
		if ( ! empty($_SERVER[$name]))
		{
			return $_SERVER[$name];
		}
	}
	return '';
}

$girzock_private = girzock_private_dir_setting();
if ( ! $girzock_private)
{
	$girzock_private = dirname(dirname(realpath(__FILE__))).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'girzock-private';
}
$girzock_resolved = realpath($girzock_private);
define('GIRZOCK_PRIVATE_DIR', rtrim($girzock_resolved ? $girzock_resolved : $girzock_private, '/\\'));

$GLOBALS['girzock_env'] = array();
$GLOBALS['girzock_env_file_state'] = 'missing';
$girzock_env_file = GIRZOCK_PRIVATE_DIR.DIRECTORY_SEPARATOR.'.env';
if (is_file($girzock_env_file))
{
	$girzock_lines = is_readable($girzock_env_file) ? @file($girzock_env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : FALSE;
	$GLOBALS['girzock_env_file_state'] = ($girzock_lines === FALSE) ? 'unreadable' : 'ok';
	foreach ((array) $girzock_lines as $girzock_line)
	{
		$girzock_line = trim($girzock_line);
		if ($girzock_line === '' OR $girzock_line[0] === '#' OR strpos($girzock_line, '=') === FALSE)
		{
			continue;
		}
		list($girzock_key, $girzock_value) = explode('=', $girzock_line, 2);
		$GLOBALS['girzock_env'][trim($girzock_key)] = trim(trim($girzock_value), "\"'");
	}
}

/**
 * Reads one value from the private .env file, then the server environment.
 */
function girzock_env($key, $default = NULL)
{
	if (isset($GLOBALS['girzock_env'][$key]))
	{
		return $GLOBALS['girzock_env'][$key];
	}
	$value = getenv($key);
	return ($value === FALSE) ? $default : $value;
}

/** A 32-byte key from its 64-character hex setting, or an empty string if missing or malformed. */
function girzock_key_bytes($name)
{
	$hex = (string) girzock_env($name, '');
	return preg_match('/^[a-f0-9]{64}$/i', $hex) ? hex2bin($hex) : '';
}

/** Writes one configuration problem to the application log, at most once per day. */
function girzock_boot_log($message)
{
	$line = 'ERROR - '.date('Y-m-d H:i:s').' --> Environment: '.$message."\n";
	$folder = GIRZOCK_PRIVATE_DIR.DIRECTORY_SEPARATOR.'logs';
	if (is_dir(GIRZOCK_PRIVATE_DIR) && ! is_dir($folder))
	{
		@mkdir($folder, 0750);
	}
	$file = $folder.DIRECTORY_SEPARATOR.'log-'.date('Y-m-d').'.php';
	if (is_file($file) && strpos((string) @file_get_contents($file), 'Environment: '.$message) !== FALSE)
	{
		return;
	}
	$header = is_file($file) ? '' : "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
	if (@file_put_contents($file, $header.$line, FILE_APPEND | LOCK_EX) === FALSE)
	{
		error_log('GIRZOCK '.trim($line));
	}
}

/** Is $child the same as, or inside, $parent? Compares resolved paths. */
function girzock_path_is_inside($child, $parent)
{
	$normalise = function ($path) {
		$real = realpath($path);
		$path = rtrim(str_replace('\\', '/', $real ? $real : $path), '/').'/';
		return DIRECTORY_SEPARATOR === '\\' ? strtolower($path) : $path;
	};
	return strpos($normalise($child), $normalise($parent)) === 0;
}

/**
 * Finds configuration problems. Returns array('fatal' => [...], 'errors' => [...]).
 * Fatal problems mean the site cannot run safely. Other errors leave it running, so that
 * visitors can still browse and enquiries are still saved.
 */
function girzock_environment_problems($environment)
{
	$fatal = array();
	$errors = array();
	$env_file = GIRZOCK_PRIVATE_DIR.DIRECTORY_SEPARATOR.'.env';
	$file_state = $GLOBALS['girzock_env_file_state'];

	// Values can also come from real server variables, so a missing file is fatal only without them.
	if ($file_state === 'unreadable')
	{
		$fatal[] = 'The .env file exists but cannot be read: '.$env_file;
	}
	elseif ($file_state === 'missing')
	{
		$message = 'The .env file was not found: '.$env_file;
		if ((string) girzock_env('DB_USER', '') === '')
		{
			$fatal[] = $message;
		}
		else
		{
			$errors[] = $message.' (using server environment variables instead)';
		}
	}

	if ($file_state === 'ok' OR empty($fatal))
	{
		foreach (array('SECRET_BOX_KEY' => 'The saved SMTP password cannot be used.', 'ENCRYPTION_KEY' => '') as $name => $effect)
		{
			if ((string) girzock_env($name, '') === '')
			{
				$errors[] = trim($name.' is missing. '.$effect);
			}
			elseif (girzock_key_bytes($name) === '')
			{
				$errors[] = trim($name.' is invalid: it must be exactly 64 hexadecimal characters. '.$effect);
			}
		}
	}

	if ($environment === 'production')
	{
		foreach (array('BASE_URL', 'DB_HOST', 'DB_NAME', 'DB_USER') as $name)
		{
			if ((string) girzock_env($name, '') === '')
			{
				$fatal[] = 'Required production setting '.$name.' is missing.';
			}
		}
		$base_url = (string) girzock_env('BASE_URL', '');
		if ($base_url !== '' && ! preg_match('#^https://#i', $base_url))
		{
			$errors[] = 'BASE_URL should use https:// in production.';
		}
		if ((string) girzock_env('DB_PASS', '') === '')
		{
			$errors[] = 'DB_PASS is empty in production. Use a dedicated database user with a strong password.';
		}
		if ( ! girzock_env('COOKIE_SECURE', 0))
		{
			$errors[] = 'COOKIE_SECURE should be 1 in production.';
		}
	}

	// The private folder must not be reachable by browsers.
	$web_roots = array(dirname(dirname(realpath(__FILE__))));
	if ( ! empty($_SERVER['DOCUMENT_ROOT']))
	{
		$web_roots[] = $_SERVER['DOCUMENT_ROOT'];
	}
	foreach ($web_roots as $root)
	{
		if (girzock_path_is_inside(GIRZOCK_PRIVATE_DIR, $root))
		{
			if (is_file(GIRZOCK_PRIVATE_DIR.DIRECTORY_SEPARATOR.'.htaccess'))
			{
				$errors[] = 'The private folder is inside the web root and relies on its .htaccess. Move it, or set GIRZOCK_PRIVATE_DIR.';
			}
			elseif ($environment === 'production')
			{
				$fatal[] = 'The private folder is inside the web root with no .htaccess protection. Move it, or set GIRZOCK_PRIVATE_DIR.';
			}
			else
			{
				$errors[] = 'The private folder is inside the web root with no .htaccess protection. Move it, or set GIRZOCK_PRIVATE_DIR.';
			}
			break;
		}
	}

	return array('fatal' => $fatal, 'errors' => $errors);
}

/**
 * Logs configuration problems and stops the request when the site cannot run safely.
 * Visitors see only a generic message: no paths, setting names, values or stack traces.
 */
function girzock_validate_environment($environment)
{
	$problems = girzock_environment_problems($environment);
	foreach (array_merge($problems['fatal'], $problems['errors']) as $message)
	{
		girzock_boot_log($message);
	}
	if ( ! $problems['fatal'])
	{
		return;
	}
	if (PHP_SAPI === 'cli')
	{
		echo 'Configuration problem:'.PHP_EOL.'  '.implode(PHP_EOL.'  ', $problems['fatal']).PHP_EOL;
		exit(1);
	}
	if ( ! headers_sent())
	{
		http_response_code(503);
		header('Content-Type: text/html; charset=UTF-8');
		header('Retry-After: 300');
		header('Cache-Control: no-store');
		header('X-Robots-Tag: noindex');
	}
	echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="robots" content="noindex"><title>Temporarily unavailable</title></head><body style="font-family:Arial,Helvetica,sans-serif;text-align:center;padding:64px 16px;"><h1>Temporarily unavailable</h1><p>This website is temporarily unavailable. Please try again shortly.</p></body></html>';
	exit;
}

// One clock for the whole application. Settings_model applies the same offset to the database session.
date_default_timezone_set((string) girzock_env('APP_TIMEZONE', 'Asia/Kolkata'));

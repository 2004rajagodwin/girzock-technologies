<?php
/**
 * Creates a .webp copy beside each large PNG or JPEG in assets/images, for example
 * hero.png.webp beside hero.png. The originals are never changed. Apache serves the copy
 * to browsers that accept WebP (see .htaccess), so no HTML or CSS has to change.
 *
 *   php database/tools/build_webp.php
 *
 * Safe to run again: only missing or out-of-date copies are made.
 */
if (PHP_SAPI !== 'cli') { exit("CLI only\n"); }
if ( ! function_exists('imagewebp')) { exit("GD with WebP support is required.\n"); }

$root = dirname(dirname(__DIR__)).'/assets/images';
$made = 0; $skipped = 0; $before = 0; $after = 0;
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)) as $file)
{
	$path = $file->getPathname();
	if ( ! preg_match('/\.(png|jpe?g)$/i', $path) OR $file->getSize() < 5000)
	{
		continue;
	}
	$webp = $path.'.webp';
	if (is_file($webp) && filemtime($webp) >= $file->getMTime())
	{
		$skipped++;
		continue;
	}
	$image = preg_match('/\.png$/i', $path) ? @imagecreatefrompng($path) : @imagecreatefromjpeg($path);
	if ( ! $image)
	{
		echo "Could not read: $path\n";
		continue;
	}
	imagepalettetotruecolor($image);
	imagealphablending($image, TRUE);
	imagesavealpha($image, TRUE);
	$ok = imagewebp($image, $webp, 86);
	imagedestroy($image);
	clearstatcache();
	// Keep the copy only if it really is smaller.
	if ( ! $ok OR filesize($webp) >= $file->getSize())
	{
		@unlink($webp);
		continue;
	}
	$made++;
	$before += $file->getSize();
	$after += filesize($webp);
}
printf("Created %d, already current %d. Those images: %.1f MB as originals, %.1f MB as WebP.\n", $made, $skipped, $before / 1048576, $after / 1048576);

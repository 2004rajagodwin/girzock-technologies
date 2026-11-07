<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Hollow text with a colour gradient flowing through its outline. Used inside an element with the
 * class gz-flow-text. $flow_id must be unique on the page; $lines holds one entry per line of text.
 * The source span keeps the space and the words for search engines and screen readers.
 */
foreach ($lines as $i => $line):
	$key = 'gz-flow-'.$flow_id.'-'.$i;
?>
<span class="gz-flow-line"><span class="gz-flow-source"><?= e($line) ?></span><svg aria-hidden="true" focusable="false"><defs><linearGradient id="<?= $key ?>-paint" gradientUnits="userSpaceOnUse" x1="0" y1="0" x2="800" y2="0" spreadMethod="repeat"><stop offset="0" stop-color="#1769ff"/><stop offset="0.33" stop-color="#19d5e5"/><stop offset="0.66" stop-color="#8b5cf6"/><stop offset="1" stop-color="#1769ff"/></linearGradient><mask id="<?= $key ?>-mask" maskUnits="userSpaceOnUse" x="-20" y="-400" width="3000" height="800"><text class="gz-flow-letters" x="0" y="0.34em" letter-spacing="-0.05em"><?= e($line) ?></text></mask></defs><g mask="url(#<?= $key ?>-mask)"><rect class="gz-flow-paint" x="-800" y="-400" width="4800" height="800" fill="url(#<?= $key ?>-paint)"/></g></svg></span>
<?php endforeach; ?>

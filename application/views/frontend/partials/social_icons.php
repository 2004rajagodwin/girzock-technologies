<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Social profile links. A platform appears only once a valid address for it is saved in Website Settings > Social links. */
?>
<ul class="social-icon">
    <?php foreach ($this->settings_model->public_socials() as $link): ?>
    <li><a class="girzock-social" href="<?= e($link['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e(setting('company_name')) ?> on <?= e($link['label']) ?> (opens in a new tab)" title="<?= e($link['label']) ?>"><i class="<?= e($link['icon']) ?>" aria-hidden="true"></i></a></li>
    <?php endforeach; ?>
</ul>

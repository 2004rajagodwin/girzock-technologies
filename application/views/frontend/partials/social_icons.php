<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<ul class="social-icon">
    <?php foreach ($this->settings_model->socials() as $link): ?>
    <?php if ($link['url']): ?>
    <li><a class="girzock-social" href="<?= e($link['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e(setting('company_name')) ?> on <?= e($link['label']) ?>" title="<?= e($link['label']) ?>"><i class="<?= e($link['icon']) ?>" aria-hidden="true"></i></a></li>
    <?php else: ?>
    <li><a class="girzock-social" data-social="<?= e($link['platform']) ?>" aria-disabled="true" aria-label="<?= e($link['label']) ?>, coming soon" title="<?= e($link['label']) ?> (coming soon)"><i class="<?= e($link['icon']) ?>" aria-hidden="true"></i></a></li>
    <?php endif; ?>
    <?php endforeach; ?>
</ul>

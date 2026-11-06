<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-card">
    <?php if ($term === ''): ?><p class="gz-muted">Enter a search term in the top bar.</p>
    <?php else: ?>
    <p class="gz-muted"><?= count($results) ?> result<?= count($results) === 1 ? '' : 's' ?> for &ldquo;<?= e($term) ?>&rdquo;</p>
    <ul class="gz-feed">
        <?php foreach ($results as $result): ?><li><a href="<?= e($result['url']) ?>"><?= e($result['title']) ?></a><small><?= e($result['type']) ?></small></li><?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>

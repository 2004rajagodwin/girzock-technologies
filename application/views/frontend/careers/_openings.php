<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($openings as $i => $job): ?>
<div class="faq-block5"<?= $job['legacy_anchor'] ? ' id="'.e($job['legacy_anchor']).'"' : '' ?>>
    <h3 class="title2 h4"><span><?= $i + 1 ?>.</span><a href="<?= site_url('careers/'.$job['slug']) ?>" class="gz-inherit-link"><?= e($job['title']) ?></a></h3>
    <p><?= e($job['summary']) ?></p>
</div>
<?php endforeach; ?>

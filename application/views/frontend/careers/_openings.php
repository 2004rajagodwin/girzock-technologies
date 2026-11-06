<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($openings as $i => $job): ?>
<div class="faq-block5"<?= $job['legacy_anchor'] ? ' id="'.e($job['legacy_anchor']).'"' : '' ?>>
    <h4 class="title2"><span><?= $i + 1 ?>.</span><a href="<?= site_url('careers/'.$job['slug']) ?>" class="gz-inherit-link"><?= e($job['title']) ?></a></h4>
    <p><?= e($job['summary']) ?></p>
</div>
<?php endforeach; ?>

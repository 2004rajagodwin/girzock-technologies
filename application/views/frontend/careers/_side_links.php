<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($openings as $job): ?>
<a href="<?= site_url('careers/'.$job['slug']) ?>"><?= e($job['title']) ?></a>
<?php endforeach; ?>

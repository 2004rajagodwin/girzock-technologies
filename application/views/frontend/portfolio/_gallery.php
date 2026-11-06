<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($projects as $project): $image = media_url($project['image']); ?>
<div class="col-lg-4 col-md-6 col-sm-12 isotope-item item<?= (int) $project['category_id'] ?>" data-src="<?= e($image) ?>">
    <div class="project-block8">
        <img src="<?= e($image) ?>" alt="<?= e($project['image_alt'] ? $project['image_alt'] : $project['title']) ?>">
        <div class="architecture2"><a href="<?= site_url('portfolio/'.$project['slug']) ?>" data-gz-nav><?= e($project['title']) ?></a></div>
    </div>
</div>
<?php endforeach; ?>

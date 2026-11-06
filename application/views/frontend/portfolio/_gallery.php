<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($projects as $i => $project):
	$link = site_url('portfolio/'.$project['slug']);
	$label = trim(preg_replace('/:\s*sample concept$/i', '', $project['title'])); ?>
<div class="col-lg-4 col-md-6 col-sm-12 isotope-item item<?= (int) $project['category_id'] ?>">
    <article class="gz-show-card">
        <a href="<?= $link ?>" class="gz-show-img gz-show-img-project" tabindex="-1" aria-hidden="true">
            <img src="<?= e(media_url($project['image'])) ?>"<?= media_srcset($project['image'], '(max-width: 767px) 92vw, (max-width: 991px) 46vw, 430px') ?> width="606" height="412"<?= $i > 2 ? ' loading="lazy" decoding="async"' : '' ?> alt="<?= e($project['image_alt'] ? $project['image_alt'] : $project['title']) ?>">
            <span class="gz-show-badge">Sample concept</span>
        </a>
        <div class="gz-show-body">
            <?php if ($project['category_name']): ?><span class="gz-show-cat"><?= e($project['category_name']) ?></span><?php endif; ?>
            <h3 class="title h4"><a href="<?= $link ?>"><?= e($label) ?></a></h3>
            <p><?= e($project['short_description']) ?></p>
            <a class="gz-show-link" href="<?= $link ?>">View Concept<span aria-hidden="true"> &rarr;</span></a>
        </div>
    </article>
</div>
<?php endforeach; ?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* The looping slider needs at least two sets of slides, as in the original markup. The card backgrounds come from the stylesheet variants. */
$variants = array(' girzock-show', ' v2', ' v3 girzock-show', ' v4');
for ($set = 0; $set < 2; $set++):
	foreach ($featured_projects as $i => $project):
		$link = site_url('portfolio/'.$project['slug']); ?>
<div class="swiper-slide">
    <div class="project-card<?= $variants[$i % 4] ?>">
        <div class="empty">
            <span><?= e($project['card_label']) ?></span>
            <div class="projec-content">
                <h3 class="title h4"><?= e($project['title']) ?></h3>
                <p><?= e($project['short_description']) ?></p>
                <a class='ser-btn3' href="<?= $link ?>" aria-label="View project: <?= e($project['title']) ?>">View Project</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; endfor; ?>

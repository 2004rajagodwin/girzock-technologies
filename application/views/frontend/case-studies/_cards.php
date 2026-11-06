<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($studies as $i => $study):
	$link = site_url('case-studies/'.$study['slug']);
	$is_sample = stripos((string) $study['card_label'], 'sample') !== FALSE; ?>
<div class="col-lg-4 col-md-6" id="study-<?= $i + 1 ?>">
    <article class="gz-show-card">
        <a href="<?= $link ?>" class="gz-show-img" tabindex="-1" aria-hidden="true">
            <?php if ($study['image']): ?><img src="<?= e(media_url($study['image'])) ?>"<?= media_srcset($study['image'], '(max-width: 767px) 92vw, 420px') ?> width="1200" height="900" loading="lazy" decoding="async" alt="<?= e($study['image_alt'] ? $study['image_alt'] : $study['title']) ?>"><?php endif; ?>
            <?php if ($is_sample): ?><span class="gz-show-badge"><?= e($study['card_label']) ?></span><?php endif; ?>
        </a>
        <div class="gz-show-body">
            <span class="gz-show-cat"><?= e($study['service_label']) ?></span>
            <h3 class="title h4"><a href="<?= $link ?>"><?= e($study['card_title'] ? $study['card_title'] : $study['title']) ?></a></h3>
            <p><?= e($study['summary']) ?></p>
            <a class="gz-show-link" href="<?= $link ?>">View Case Study<span aria-hidden="true"> &rarr;</span></a>
        </div>
    </article>
</div>
<?php endforeach; ?>

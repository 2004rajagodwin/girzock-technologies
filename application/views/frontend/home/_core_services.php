<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($core_services as $service):
	$link = site_url('services/'.$service['slug']);
	$title = $service['home_core_title'] ? $service['home_core_title'] : $service['title']; ?>
<div class="swiper-slide">
    <div class="ser-card15">
        <div class="ser-img15">
            <a href="<?= $link ?>">
                <img src="<?= e(media_url($service['home_core_image'])) ?>" width="380" height="388" loading="lazy" decoding="async" alt="">
                <span><?= e($service['home_core_label']) ?></span>
            </a>
        </div>
        <div class="ser-content15">
            <h3 class="title h4"><a href="<?= $link ?>"><?= e($title) ?></a></h3>
        </div>
        <a class='ser-btn' href="<?= $link ?>" aria-label="<?= e($title) ?>">
            <i class="icon fontello icon-button-arrow"></i>
            <i class="icon2 fontello icon-button-arrow"></i>
        </a>
    </div>
</div>
<?php endforeach; ?>

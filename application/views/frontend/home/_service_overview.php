<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* The original five-slot layout: slots 1 and 2 full cards, slots 3 and 4 stacked in one column, slot 5 full card. */
$slots = array_slice($overview_services, 0, 5);
$card = function ($service, $content_class, $card_class = '', $size = array(456, 561)) {
	$link = site_url('services/'.$service['slug']);
	$title = $service['home_overview_title'] ? $service['home_overview_title'] : $service['title'];
	?>
	<div class="ser-card<?= $card_class ?>">
		<img src="<?= e(media_url($service['home_overview_image'])) ?>" width="<?= $size[0] ?>" height="<?= $size[1] ?>" loading="lazy" decoding="async" alt="">
		<div class="ser-content<?= $content_class ?>">
			<h3 class="title h4"><a href="<?= $link ?>"><?= e($title) ?></a></h3>
			<p><?= e($service['home_overview_text']) ?></p>
		</div>
		<a href="<?= $link ?>" class="ser-btn" aria-label="<?= e($title) ?>">
			<i class="icon fontello icon-button-arrow"></i>
			<i class="icon2 fontello icon-button-arrow"></i>
		</a>
	</div>
	<?php
};
?>
<?php if (isset($slots[0])): ?><div class="col-xl-3 col-lg-6 col-md-6"><?php $card($slots[0], ''); ?></div><?php endif; ?>
<?php if (isset($slots[1])): ?><div class="col-xl-3 col-lg-6 col-md-6"><?php $card($slots[1], ' v2'); ?></div><?php endif; ?>
<?php if (isset($slots[2])): ?>
<div class="col-xl-3 col-lg-6 col-md-6">
    <div class="ser-card v3">
        <img src="<?= e(media_url($slots[2]['home_overview_image'])) ?>" width="420" height="191" loading="lazy" decoding="async" alt="">
        <h3 class="title"><a href="<?= site_url('services/'.$slots[2]['slug']) ?>"><?= e($slots[2]['home_overview_title'] ? $slots[2]['home_overview_title'] : $slots[2]['title']) ?></a></h3>
    </div>
    <?php if (isset($slots[3])): $s = $slots[3]; $t = $s['home_overview_title'] ? $s['home_overview_title'] : $s['title']; ?>
    <div class="ser-card v4">
        <div class="ser-content">
            <img src="<?= e(media_url($s['home_overview_image'])) ?>" width="57" height="57" loading="lazy" decoding="async" alt="">
            <h3 class="title h4"><a href="<?= site_url('services/'.$s['slug']) ?>"><?= e($t) ?></a></h3>
            <p><?= e($s['home_overview_text']) ?></p>
        </div>
        <a href="<?= site_url('services/'.$s['slug']) ?>" class="ser-btn" aria-label="<?= e($t) ?>">
            <i class="icon fontello icon-button-arrow"></i>
            <i class="icon2 fontello icon-button-arrow"></i>
        </a>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if (isset($slots[4])): ?><div class="col-xl-3 col-lg-6 col-md-6"><?php $card($slots[4], ' v2', ' v5', array(490, 561)); ?></div><?php endif; ?>

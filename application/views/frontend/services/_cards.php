<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* The original five-slot card layout on the services page. */
$slots = array_slice($card_services, 0, 5);
$card = function ($s, $card_class, $content_class) {
	$link = site_url('services/'.$s['slug']); ?>
	<div class="ser-card<?= $card_class ?>"<?= $s['legacy_anchor'] ? ' id="'.e($s['legacy_anchor']).'"' : '' ?>>
		<img src="<?= e(media_url($s['image'])) ?>" alt="">
		<div class="ser-content<?= $content_class ?>">
			<h3 class="title h4"><a href="<?= $link ?>"><?= e($s['title']) ?></a></h3>
			<p><?= e($s['short_description']) ?></p>
		</div>
		<a href="<?= $link ?>" class="ser-btn" aria-label="Learn about <?= e($s['title']) ?>">
			<i class="icon fontello icon-button-arrow"></i>
			<i class="icon2 fontello icon-button-arrow"></i>
		</a>
	</div>
<?php }; ?>
<?php if (isset($slots[0])): ?><div class="col-xl-3 col-lg-6 col-md-6"><?php $card($slots[0], '', ''); ?></div><?php endif; ?>
<?php if (isset($slots[1])): ?><div class="col-xl-3 col-lg-6 col-md-6"><?php $card($slots[1], '', ' v2'); ?></div><?php endif; ?>
<?php if (isset($slots[2])): $s = $slots[2]; ?>
<div class="col-xl-3 col-lg-6 col-md-6">
    <div class="ser-card v3"<?= $s['legacy_anchor'] ? ' id="'.e($s['legacy_anchor']).'"' : '' ?>>
        <img src="<?= e(media_url($s['image'])) ?>" alt="">
        <h3 class="title"><a href="<?= site_url('services/'.$s['slug']) ?>"><?= e($s['title']) ?></a></h3>
    </div>
    <?php if (isset($slots[3])): $s = $slots[3]; ?>
    <div class="ser-card v4"<?= $s['legacy_anchor'] ? ' id="'.e($s['legacy_anchor']).'"' : '' ?>>
        <div class="ser-content">
            <img src="<?= e(media_url($s['icon'] ? $s['icon'] : $s['image'])) ?>" alt="">
            <h3 class="title h4"><a href="<?= site_url('services/'.$s['slug']) ?>"><?= e($s['title']) ?></a></h3>
            <p><?= e($s['short_description']) ?></p>
        </div>
        <a href="<?= site_url('services/'.$s['slug']) ?>" class="ser-btn" aria-label="Learn about <?= e($s['title']) ?>">
            <i class="icon fontello icon-button-arrow"></i>
            <i class="icon2 fontello icon-button-arrow"></i>
        </a>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if (isset($slots[4])): ?><div class="col-xl-3 col-lg-6 col-md-6"><?php $card($slots[4], ' v5', ' v2'); ?></div><?php endif; ?>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($feature_services as $s): ?>
<div class="col-lg-3 col-md-6 col-sm-6"<?= $s['legacy_anchor'] ? ' id="'.e($s['legacy_anchor']).'"' : '' ?>>
    <div class="feature-card10">
        <img src="<?= e(media_url($s['icon'])) ?>" alt="">
        <h4 class="title"><a href="<?= site_url('services/'.$s['slug']) ?>" class="gz-inherit-link"><?= e($s['title']) ?></a></h4>
        <p><?= e($s['short_description']) ?></p>
    </div>
</div>
<?php endforeach; ?>

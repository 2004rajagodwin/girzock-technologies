<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$variants = array(' v1', ' v2', '', ' v3', ' v4');
foreach ($studies as $i => $study):
	$link = site_url('case-studies/'.$study['slug']); ?>
<div class="col-lg-4 col-md-6">
    <div class="ser-card21<?= $variants[$i % 5] ?>">
        <a href="<?= $link ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
            <span><?= e($study['card_label']) ?></span>
        </a>
        <div class="empty2">
            <div class="ser-content21">
                <h4 class="title"><a href="<?= $link ?>"><?= e($study['card_title'] ? $study['card_title'] : $study['title']) ?></a></h4>
                <p><?= e($study['summary']) ?></p>
                <a class='ser-btn3' href="<?= $link ?>">Read the study</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

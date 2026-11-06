<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- process-sec -->
<section class="process-sec ibt-section-gap"<?= empty($anchor) ? '' : ' id="'.e($anchor).'"' ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="process-title">
                    <h3 class="title h4"><?= e($study['category_label']) ?></h3>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="process-detail">
                    <p class="paragraph"><strong>Challenge:</strong> <?= e($study['challenge']) ?></p>
                    <p><strong>Solution:</strong> <?= e($study['solution']) ?></p>
                    <?php if ($study['results']): ?><p><strong>Outcome we would aim for:</strong> <?= e($study['results']) ?></p><?php endif; ?>
                    <?php if ($study['quote']): ?>
                    <blockquote>
                        <div class="quote-box">
                            <img src="<?= asset('assets/images/icon/comas2.svg') ?>" width="52" height="39" alt="">
                            <h3 class="title h4"><?= e($study['quote']) ?></h3>
                            <span class="sub-title"><?= e($study['quote_author']) ?></span>
                        </div>
                    </blockquote>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End process-sec -->

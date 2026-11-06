<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- project-single -->
<section class="project-single ibt-section-gap"<?= empty($anchor) ? '' : ' id="'.e($anchor).'"' ?>>
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-4">
                <div class="project-img7">
                    <?php if ($study['image']): ?>
                    <img src="<?= e(media_url($study['image'])) ?>" alt="<?= e($study['title']) ?>">
                    <?php else: ?>
                    <img src="<?= e(media_url(setting('logo_color'))) ?>" alt="<?= e(setting('company_name')) ?> logo" class="girzock-auto-logo">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-6 col-lg-8">
                <div class="project-content7">
                    <div class="sec-title mb-0">
                        <h2 class="title animated-heading"><?= e($study['title']) ?></h2>
                        <p><strong>Challenge:</strong> <?= e($study['challenge']) ?></p>
                        <p class="paragraph"><strong>Solution:</strong> <?= e($study['solution']) ?></p>
                    </div>
                    <?php if (text_lines($study['highlights'])): ?>
                    <ul class="ser-detail-list">
                        <?php foreach (text_lines($study['highlights']) as $line): ?>
                        <li><i class="fontello icon-button-arrow-down"></i><?= e($line) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <div class="project-post-meta">
                        <div class="post-meta-item">
                            <h4 class="title">Service</h4>
                            <p><?= e($study['service_label']) ?></p>
                        </div>
                        <div class="post-meta-item">
                            <h4 class="title">Approach</h4>
                            <p><?= e($study['approach']) ?></p>
                        </div>
                        <div class="post-meta-item m-0">
                            <h4 class="title">Status</h4>
                            <p><?= e($study['status_label']) ?></p>
                        </div>
                    </div>
                    <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                        <span>Discuss a similar project</span>
                        <i class="icon-arrow-top"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End project-single -->

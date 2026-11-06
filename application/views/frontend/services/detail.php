<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$problems = pipe_rows($service['problems']);
$benefits = pipe_rows($service['benefits']);
$workflow = pipe_rows($service['workflow']);
$use_cases = text_lines($service['use_cases']);
$faqs = pipe_rows($service['faqs']);
?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Services', 'heading' => $service['title'], 'crumbs' => array('Services' => 'services', $service['title'] => NULL))); ?>

<section class="project-single ibt-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-5">
                <div class="project-img7">
                    <?php $page_image = $service['detail_image'] ? $service['detail_image'] : $service['image']; ?>
                    <img src="<?= e(media_url($page_image)) ?>"<?= media_srcset($page_image, '456px') ?> width="456" height="561" alt="<?= e($service['detail_image_alt'] ? $service['detail_image_alt'] : $service['title'].' by '.setting('company_name')) ?>">
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="project-content7">
                    <div class="sec-title mb-0">
                        <h2 class="title animated-heading"><?= e($service['headline'] ? $service['headline'] : $service['title']) ?></h2>
                        <?php if ( ! $service['description']): ?><p><?= e($service['short_description']) ?></p><?php endif; ?>
                    </div>
                    <?php if ($service['description']): ?><div class="gz-rich-text"><?= rich_text($service['description']) ?></div><?php endif; ?>
                    <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                        <span>Discuss this service</span>
                        <i class="icon-arrow-top"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($problems): ?>
<section class="feature-sec10 ibt-section-gapBottom">
    <div class="container">
        <div class="sec-title">
            <span class="sub-title">problems we solve</span>
            <h2 class="title animated-heading">Problems We Solve with <?= e($service['title']) ?></h2>
        </div>
        <div class="row">
            <?php foreach ($problems as $row): ?>
            <div class="col-lg-6 col-md-6">
                <div class="feature-card10 gz-service-card">
                    <h3 class="title h4"><?= e($row[0]) ?></h3>
                    <p><?= e($row[1]) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($benefits OR $use_cases): ?>
<section class="process-sec ibt-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="process-title">
                    <h2 class="title h3">Features and Benefits</h2>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="process-detail gz-article">
                    <?php if ($benefits): ?>
                    <ul class="ser-detail-list gz-detail-list">
                        <?php foreach ($benefits as $row): ?>
                        <li><i class="fontello icon-button-arrow-down"></i><span><strong><?= e($row[0]) ?>.</strong> <?= e($row[1]) ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <?php if ($use_cases): ?>
                    <h3 class="girzock-article-title">Suitable for</h3>
                    <ul class="ser-detail-list gz-detail-list">
                        <?php foreach ($use_cases as $line): ?>
                        <li><i class="fontello icon-button-arrow-down"></i><span><?= e($line) ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($workflow): ?>
<section class="faq-sec5 ibt-section-gapBottom">
    <div class="container">
        <div class="faq-content5 gz-workflow">
            <h2 class="title">How We Deliver <?= e($service['title']) ?></h2>
            <?php $last = count($workflow) - 1; foreach ($workflow as $i => $row): ?>
            <div class="faq-block5<?= $i === $last ? ' mb-0' : '' ?>">
                <h3 class="title2 h4"><span><?= $i + 1 ?>.</span><?= e($row[0]) ?></h3>
                <p><?= e($row[1]) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($faqs): ?>
<section class="faq-sec ibt-section-gapBottom gz-detail-faq">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="faq-img">
                    <img src="<?= asset('assets/images/layers/layer2.png') ?>" width="647" height="844" loading="lazy" decoding="async" alt="">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="faq-content">
                    <div class="sec-title">
                        <span class="sub-title">faq</span>
                        <h2 class="title animated-heading">Questions About <?= e($service['title']) ?></h2>
                    </div>
                    <div class="accordion" id="accordionService">
                        <?php $last = count($faqs) - 1; foreach ($faqs as $i => $row): ?>
                        <div class="accordion-item<?= $i === $last ? ' mb-0' : '' ?>">
                            <h3 class="accordion-header" id="serviceFaqHeading<?= $i ?>">
                                <button class="accordion-button<?= $i === 0 ? '' : ' collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#serviceFaqBody<?= $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="serviceFaqBody<?= $i ?>">
                                    <?= e($row[0]) ?>
                                </button>
                            </h3>
                            <div id="serviceFaqBody<?= $i ?>" class="accordion-collapse collapse<?= $i === 0 ? ' show' : '' ?>" aria-labelledby="serviceFaqHeading<?= $i ?>" data-bs-parent="#accordionService">
                                <div class="accordion-body"><?= e($row[1]) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($related): ?>
<section class="feature-sec10 ibt-section-gapBottom">
    <div class="container">
        <div class="sec-title">
            <span class="sub-title">related services</span>
            <h2 class="title animated-heading">Services Related to <?= e($service['title']) ?></h2>
            <?php if ($service['cta_text']): ?><p><?= e($service['cta_text']) ?> <a href="<?= site_url('contact') ?>">Talk to GIRZOCK Technologies</a>.</p><?php endif; ?>
        </div>
        <div class="row">
            <?php foreach ($related as $item): ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="feature-card10">
                    <h3 class="title h4"><a href="<?= site_url('services/'.$item['slug']) ?>" class="gz-inherit-link"><?= e($item['title']) ?></a></h3>
                    <p><?= e($item['short_description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

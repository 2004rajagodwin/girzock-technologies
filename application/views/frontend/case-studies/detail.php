<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Studies', 'heading' => $study['title'], 'crumbs' => array('Case Studies' => 'case-studies', $study['title'] => NULL))); ?>

<?php
$sections = array(
	'Overview' => $study['overview'], 'Challenge' => $study['challenge'], 'Solution' => $study['solution'],
	'Implementation' => $study['implementation'],
	'Results' => $study['results'],
);
?>
<section class="process-sec ibt-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="process-title">
                    <h2 class="title h4"><?= e($study['category_label']) ?></h2>
                </div>
            </div>
            <div class="col-lg-9">
                <article class="process-detail gz-article">
                    <?php if ($study['image']): ?><img class="gz-article-image" src="<?= e(media_url($study['image'])) ?>" alt="<?= e($study['title']) ?>"><?php endif; ?>
                    <?php foreach ($sections as $label => $body): if ( ! trim((string) $body)) { continue; } ?>
                    <h3 class="girzock-article-title"><?= $label === 'Results' && stripos((string) $study['status_label'], 'sample') !== FALSE ? 'Outcome we would aim for' : e($label) ?></h3>
                    <?php if ($body !== strip_tags($body)): ?><div class="gz-rich-text"><?= rich_text($body) ?></div><?php else: ?><p><?= nl2br(e($body)) ?></p><?php endif; ?>
                    <?php endforeach; ?>
                    <?php if (text_lines($study['highlights'])): ?>
                    <ul class="ser-detail-list">
                        <?php foreach (text_lines($study['highlights']) as $line): ?>
                        <li><i class="fontello icon-button-arrow-down"></i><?= e($line) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <?php if ($study['quote']): ?>
                    <blockquote>
                        <div class="quote-box">
                            <img src="<?= asset('assets/images/icon/comas2.svg') ?>" alt="">
                            <h4 class="title"><?= e($study['quote']) ?></h4>
                            <span class="sub-title"><?= e($study['quote_author']) ?></span>
                        </div>
                    </blockquote>
                    <?php endif; ?>
                    <div class="project-post-meta">
                        <div class="post-meta-item"><h3 class="title h4">Service</h3><p><?= e($study['service_label']) ?></p></div>
                        <div class="post-meta-item"><h3 class="title h4">Approach</h3><p><?= e($study['approach']) ?></p></div>
                        <div class="post-meta-item m-0"><h3 class="title h4">Status</h3><p><?= e($study['status_label']) ?></p></div>
                    </div>
                    <?php if ($related_projects): ?>
                    <h3 class="girzock-article-title">Related projects</h3>
                    <ul class="ser-detail-list">
                        <?php foreach ($related_projects as $project): ?>
                        <li><i class="fontello icon-button-arrow-down"></i><a href="<?= site_url('portfolio/'.$project['slug']) ?>"><?= e($project['title']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                        <span>Discuss a similar project</span>
                        <i class="icon-arrow-top"></i>
                    </a>
                </article>
            </div>
        </div>
    </div>
</section>

<?php if (text_lines($study['gallery'])): ?>
<section class="project-sec8 ibt-section-gapBottom">
    <div class="custom-cursor">Zoom In</div>
    <div class="container2">
        <div id="lightgallery2" class="row">
            <?php foreach (text_lines($study['gallery']) as $image): ?>
            <div class="col-lg-4 col-md-6 col-sm-12" data-src="<?= e(media_url($image)) ?>">
                <div class="project-block8"><img src="<?= e(media_url($image)) ?>" alt="<?= e($study['title']) ?> image" loading="lazy"></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

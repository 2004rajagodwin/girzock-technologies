<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Work', 'heading' => $project['title'], 'crumbs' => array('Portfolio' => 'portfolio', $project['title'] => NULL))); ?>

<section class="project-single ibt-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-5">
                <div class="project-img7">
                    <img src="<?= e(media_url($project['image'])) ?>" alt="<?= e($project['image_alt'] ? $project['image_alt'] : $project['title']) ?>">
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="project-content7">
                    <div class="sec-title mb-0">
                        <?php if ($project['category_name']): ?><span class="sub-title"><?= e($project['category_name']) ?></span><?php endif; ?>
                        <h2 class="title animated-heading"><?= e($project['title']) ?></h2>
                        <p><?= e($project['short_description']) ?></p>
                    </div>
                    <?php if ($project['description']): ?><div class="gz-rich-text"><?= rich_text($project['description']) ?></div><?php endif; ?>
                    <?php if ($project['client_name'] OR $project['technologies'] OR $project['client_details']): ?>
                    <div class="project-post-meta">
                        <?php if ($project['client_name']): ?><div class="post-meta-item"><h3 class="title h4">Client</h3><p><?= e($project['client_name']) ?></p></div><?php endif; ?>
                        <?php if ($project['client_details']): ?><div class="post-meta-item"><h3 class="title h4">About the client</h3><p><?= e($project['client_details']) ?></p></div><?php endif; ?>
                        <?php if ($project['technologies']): ?><div class="post-meta-item m-0"><h3 class="title h4">Technologies</h3><p><?= e($project['technologies']) ?></p></div><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <div class="girzock-btn-group">
                        <?php if ($case_study): ?>
                        <a href="<?= site_url('case-studies/'.$case_study['slug']) ?>" class="ibt-btn ibt-btn-outline">
                            <span>Read the case study</span>
                            <i class="icon-arrow-top"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($project['live_url']): ?>
                        <a href="<?= e($project['live_url']) ?>" class="ibt-btn ibt-btn-outline" target="_blank" rel="noopener noreferrer">
                            <span>Visit website</span>
                            <i class="icon-arrow-top"></i>
                        </a>
                        <?php else: ?>
                        <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                            <span>Discuss a similar project</span>
                            <i class="icon-arrow-top"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (text_lines($project['gallery'])): ?>
<section class="project-sec8 ibt-section-gapBottom">
    <div class="custom-cursor">Zoom In</div>
    <div class="container2">
        <div id="lightgallery2" class="row">
            <?php foreach (text_lines($project['gallery']) as $image): ?>
            <div class="col-lg-4 col-md-6 col-sm-12" data-src="<?= e(media_url($image)) ?>">
                <div class="project-block8">
                    <img src="<?= e(media_url($image)) ?>" alt="<?= e($project['title']) ?> gallery image" loading="lazy">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

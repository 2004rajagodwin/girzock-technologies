<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Search', 'heading' => 'Search', 'crumbs' => array('Search' => NULL))); ?>

<section class="service-sec21 ibt-section-gap">
    <div class="container">
        <form class="gz-blog-search gz-search-page" action="<?= site_url('search') ?>" method="get" role="search">
            <input type="search" name="q" value="<?= e($term) ?>" placeholder="Search this website..." aria-label="Search this website" maxlength="100">
            <button type="submit" aria-label="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
        <?php if ($term !== ''): ?>
        <p class="gz-empty"><?= count($results) ?> result<?= count($results) === 1 ? '' : 's' ?> for &ldquo;<?= e($term) ?>&rdquo;</p>
        <?php endif; ?>
        <div class="row">
            <?php foreach ($results as $result): ?>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card10 gz-result">
                    <span class="sub-title"><?= e($result['type']) ?></span>
                    <h2 class="title h4"><a href="<?= e($result['url']) ?>" class="gz-inherit-link"><?= e($result['title']) ?></a></h2>
                    <p><?= e($result['summary']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

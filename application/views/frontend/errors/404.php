<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $heading = empty($gone) ? 'Page not found' : 'Page removed'; ?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => empty($gone) ? '404' : '410', 'heading' => $heading, 'crumbs' => array($heading => NULL))); ?>

<section class="service-sec21 ibt-section-gap">
    <div class="container">
        <div class="sec-title">
            <span class="sub-title"><?= empty($gone) ? 'error 404' : 'error 410' ?></span>
            <h2 class="title animated-heading"><?= empty($gone) ? 'We Could Not Find That Page' : 'That Page Is No Longer Available' ?></h2>
            <p>The link may be out of date. These pages should help you find what you need.</p>
        </div>
        <div class="girzock-btn-group">
            <a href="<?= site_url() ?>" class="ibt-btn ibt-btn-outline"><span>Home</span><i class="icon-arrow-top"></i></a>
            <a href="<?= site_url('services') ?>" class="ibt-btn ibt-btn-outline"><span>Services</span><i class="icon-arrow-top"></i></a>
            <a href="<?= site_url('blog') ?>" class="ibt-btn ibt-btn-outline"><span>Blog</span><i class="icon-arrow-top"></i></a>
            <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline"><span>Contact</span><i class="icon-arrow-top"></i></a>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

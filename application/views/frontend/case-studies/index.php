<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- page-banner6 -->
    <section class="page-banner6">
        <div class="shape"></div>
        <div class="shape3"></div>
        <div class="staff-text">Projects</div>
        <div class="container">
            <div class="page-content">
                <h1 class="title">/ Our Case Studies /</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li>/</li>
            <li>Case Studies</li>
        </ul>
    </section>
    <!-- End page-banner6 -->

    <!-- case study cards -->
    <section class="gz-showcase ibt-section-gap">
        <div class="container">
            <div class="sec-title">
                <span class="sub-title">how we solve problems</span>
                <h2 class="title animated-heading">Challenges, Solutions and the Outcomes We Aim for</h2>
                <p><?= e(setting('case_studies_intro')) ?></p>
            </div>
            <div class="row gz-showcase-row">
<?php $this->load->view('frontend/case-studies/_cards'); ?>
</div>
        </div>
    </section>
    <!-- End case study cards -->

    <!-- fun-fact-sec3 -->
    <section class="fun-fact-sec3 ibt-section-gapBottom">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-xl-3 col-lg-0">
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="fun-fact-content3">
                        <h3 class="title h4">Key Outcomes</h3>
                        <p>We agree what success looks like before a project starts, so that the results can be measured and reported honestly. These are the kinds of outcomes we plan for:</p>
                        <ul class="ser-detail-list">
                            <li><i class="fontello icon-button-arrow-down"></i>Less manual work for your team</li>
                            <li><i class="fontello icon-button-arrow-down"></i>A better experience for your customers</li>
                            <li><i class="fontello icon-button-arrow-down"></i>Systems that are easier to maintain</li>
                            <li><i class="fontello icon-button-arrow-down"></i>Technology that can grow with you</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="fun-fact3">
                        <div class="fun-fact-counter3">
                            <div class="counter-box15">
                                <span class="counter-number percent-counter2" data-target="<?= (int) $sample_count ?>">0</span>
                                <span class="counter-text"></span>
                            </div>
                            <span class="title">Sample concepts on this page</span>
                        </div>
                        <div class="fun-fact-counter3 mb-0">
                            <div class="counter-box15">
                                <span class="counter-number percent-counter2" data-target="<?= (int) $service_count ?>">0</span>
                                <span class="counter-text"></span>
                            </div>
                            <span class="title">Services we can apply</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post-navigation ibt-section-gapTop">
                <div class="post-nav-item">
                    <a href="<?= site_url('portfolio') ?>" class="post-btn">Portfolio</a>
                    <div class="post-nav-content">
                        <a href="<?= site_url('portfolio') ?>"><img src="<?= asset('assets/images/generated/pro/cards/website-development.webp') ?>" width="136" height="106" alt="" loading="lazy" decoding="async"></a>
                        <span class="designation">See more</span>
                        <h3 class="name h4"><a href="<?= site_url('portfolio') ?>">Our Portfolio</a></h3>
                    </div>
                </div>
                <a href="<?= site_url() ?>" class="toggel2" aria-label="Home"><img src="<?= asset('assets/images/icon/toggel.svg') ?>" width="20" height="20" loading="lazy" decoding="async" alt=""></a>
                <div class="post-nav-item2">
                    <a href="<?= site_url('services') ?>" class="post-btn2">Services</a>
                    <div class="post-nav-content2">
                        <span class="designation">See more</span>
                        <h3 class="name h4"><a href="<?= site_url('services') ?>">Our Services</a></h3>
                        <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/generated/pro/cards/custom-software-development.webp') ?>" width="136" height="106" alt="" loading="lazy" decoding="async"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End fun-fact-sec3 -->

    <!-- main-sec -->
    <section class="main-sec">
        <!-- contact-sec -->
        <div class="contact-sec ibt-section-gap">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="contact-content">
                                <div class="sec-title white">
                                    <span class="sub-title">get in touch</span>
                                    <h2 class="title animated-heading">Tell Us What You Want to Build Next</h2>
                                    <p>Share your idea, website or software requirement, and GIRZOCK Technologies will get back to you with clear next steps.</p>
                                </div>
                                <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="contact-info">
            <div class="call-center">
                <h3 class="title h4">Email</h3>
                <a href="mailto:<?= e(setting('contact_email')) ?>" class="gmail"><?= e(setting('contact_email')) ?></a>
            </div>
            <div class="call-center mb-0">
                <h3 class="title h4">Website</h3>
                <a href="<?= e(setting('website_url')) ?>" class="gmail"><?= e(preg_replace('#^https?://#', '', rtrim(setting('website_url'), '/'))) ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="contact-info">
            <div class="call-center">
                <h3 class="title h4">Our Location</h3>
                <p><?= str_replace("\n", ' <br>', e(setting('business_address'))) ?></p>
            </div>
            <div class="call-center mb-0">
                <h3 class="title h4">Social Network</h3>
                <?php $this->load->view('frontend/partials/social_icons'); ?>
            </div>
        </div>
    </div>
</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-form">
    <?php $this->load->view('frontend/partials/mini_form'); ?>
</div>
                        </div>
                    </div>
                </div>
            </div>

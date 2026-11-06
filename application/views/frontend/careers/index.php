<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- page-banner9 -->
    <section class="page-banner9">
        <div class="shape"></div>
        <div class="shape3"></div>
        <div class="staff-text">Careers</div>
        <div class="container">
            <div class="page-content">
                <h1 class="title">/ Careers at GIRZOCK /</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li>/</li>
            <li>Careers</li>
        </ul>
    </section>
    <!-- End page-banner9 -->

    <!-- faq-sec5 -->
    <section class="faq-sec5 ibt-section-gap">
        <button class="sidebar-toggle" aria-label="Open sidebar"></button>
        <!-- Overlay -->
        <div class="sidebar-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="side-bar2">
                        <button class="sidebar-close" aria-label="Close sidebar"></button>
                        <div class="ser-widget side-widget">
<?php $this->load->view('frontend/careers/_side_links'); ?>
</div>
                        <div class="strategy-widget side-widget">
                            <img src="<?= asset('assets/images/event/shades.png') ?>" width="304" height="385" alt="" loading="lazy" decoding="async">
                            <div class="strategy-content">
                                <h2 class="title h4">Apply to GIRZOCK</h2>
                                <p>Email your CV to <?= e(setting('contact_email')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="faq-content5">
                        <h2 class="title">Build Your Career with GIRZOCK</h2>
                        <p class="girzock-careers-note">We welcome applications in the areas below. Openings change as projects grow, so if there is no current vacancy that fits, we will keep your details for future roles. Work is based in Thisaiyanvilai, Tirunelveli.</p>
                        <?php $this->load->view('frontend/careers/_openings'); ?>
                        <div class="faq-block5 mb-0" id="apply">
                            <h3 class="title2 h4"><span><?= count($openings) + 1 ?>.</span>How to apply</h3>
                            <p>Email <a href="mailto:<?= e(setting('contact_email')) ?>?subject=Job%20application"><?= e(setting('contact_email')) ?></a> with your CV, the role you are interested in, and links to any work you would like us to see. You can also open a role in the list above and apply online.</p>
                            <a href="mailto:<?= e(setting('contact_email')) ?>?subject=Job%20application" class="ibt-btn ibt-btn-outline">
                                <span>Apply by email</span>
                                <i class="icon-arrow-top"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End faq-sec5 -->

    <!-- feature-style10 -->
    <section class="feature-sec10 ibt-section-gapBottom">
        <div class="container">
            <div class="sec-title">
                <span class="sub-title">why join</span>
                <h2 class="title animated-heading">What You Can Expect at GIRZOCK</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature1.svg') ?>" width="24" height="24" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Real Projects</h3>
                        <p>Work on websites and software that businesses rely on.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature2.svg') ?>" width="24" height="24" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Broad Exposure</h3>
                        <p>Learn across web, software, design and cloud.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature3.svg') ?>" width="28" height="28" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Room to Learn</h3>
                        <p>Build new skills as technology and projects change.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature4.svg') ?>" width="26" height="26" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Clear Ownership</h3>
                        <p>Take responsibility for your work and see its impact.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End feature-style10 -->

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

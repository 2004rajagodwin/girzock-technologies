<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- page-banner8 -->
    <section class="page-banner8">
        <div class="shape"></div>
        <div class="shape3"></div>
        <div class="staff-text">Work</div>
        <div class="container">
            <div class="page-content">
                <h1 class="title">/ Our Portfolio /</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li>/</li>
            <li>Portfolio</li>
        </ul>
    </section>
    <!-- End page-banner8 -->

    <!-- project-sec8 -->
    <section class="project-sec8 ibt-section-gap">
        <h2 class="visually-hidden">GIRZOCK Technologies Portfolio</h2>
        <div class="custom-cursor">Zoom In</div>
        <div class="container2">
            <!-- Isotope menu -->
            <ul class="menu_iso" id="custom-filter">
<?php $this->load->view('frontend/portfolio/_filters'); ?>
</ul>
            <!-- Gallery Grid -->
            <div id="lightgallery2" class="row iso-container2">
<?php $this->load->view('frontend/portfolio/_gallery'); ?>
</div>
        </div>
    </section>
    <!-- End project-sec8 -->

    <!-- service-sec21 -->
    <section class="service-sec21 ibt-section-gap">
        <div class="container">
            <div class="sec-title">
                <span class="sub-title">what we build</span>
                <h2 class="title animated-heading">The Kinds of Projects We Take on</h2>
                <p><?= e(setting('portfolio_intro')) ?></p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="ser-card21 v1">
                        <a href="<?= service_link('web-design') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                            <span>Websites</span>
                        </a>
                        <div class="empty2">
                            <div class="ser-content21">
                                <h4 class="title"><a href="<?= service_link('web-design') ?>">Business and corporate websites</a></h4>
                                <p>Responsive websites that present your business clearly and generate enquiries.</p>
                                <a class='ser-btn3' href="<?= service_link('web-design') ?>">Explore more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ser-card21 v2">
                        <a href="<?= service_link('web-apps') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                            <span>Web Apps</span>
                        </a>
                        <div class="empty2">
                            <div class="ser-content21">
                                <h4 class="title"><a href="<?= service_link('web-apps') ?>">Web applications and portals</a></h4>
                                <p>Secure, browser-based tools for your customers and your team.</p>
                                <a class='ser-btn3' href="<?= service_link('web-apps') ?>">Explore more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ser-card21">
                        <a href="<?= service_link('ecommerce') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                            <span>E-commerce</span>
                        </a>
                        <div class="empty2">
                            <div class="ser-content21">
                                <h4 class="title"><a href="<?= service_link('ecommerce') ?>">Online stores</a></h4>
                                <p>Catalogues, payments and order management for selling online.</p>
                                <a class='ser-btn3' href="<?= service_link('ecommerce') ?>">Explore more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ser-card21 v3">
                        <a href="<?= service_link('wordpress') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                            <span>WordPress</span>
                        </a>
                        <div class="empty2">
                            <div class="ser-content21">
                                <h4 class="title"><a href="<?= service_link('wordpress') ?>">WordPress websites</a></h4>
                                <p>Custom WordPress builds that your team can manage with ease.</p>
                                <a class='ser-btn3' href="<?= service_link('wordpress') ?>">Explore more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ser-card21 v1">
                        <a href="<?= service_link('custom-software') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                            <span>Software</span>
                        </a>
                        <div class="empty2">
                            <div class="ser-content21">
                                <h4 class="title"><a href="<?= service_link('custom-software') ?>">Custom business software</a></h4>
                                <p>Systems shaped around the way your business works.</p>
                                <a class='ser-btn3' href="<?= service_link('custom-software') ?>">Explore more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ser-card21 v4">
                        <a href="<?= service_link('aws') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                            <span>Cloud</span>
                        </a>
                        <div class="empty2">
                            <div class="ser-content21">
                                <h4 class="title"><a href="<?= service_link('aws') ?>">Cloud and AWS deployments</a></h4>
                                <p>Hosting and infrastructure planned for reliability and growth.</p>
                                <a class='ser-btn3' href="<?= service_link('aws') ?>">Explore more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End service-sec21 -->

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
                <h4 class="title">Email</h4>
                <a href="mailto:<?= e(setting('contact_email')) ?>" class="gmail"><?= e(setting('contact_email')) ?></a>
            </div>
            <div class="call-center mb-0">
                <h4 class="title">Website</h4>
                <a href="<?= e(setting('website_url')) ?>" class="gmail"><?= e(preg_replace('#^https?://#', '', rtrim(setting('website_url'), '/'))) ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="contact-info">
            <div class="call-center">
                <h4 class="title">Our Location</h4>
                <p><?= str_replace("\n", ' <br>', e(setting('business_address'))) ?></p>
            </div>
            <div class="call-center mb-0">
                <h4 class="title">Social Network</h4>
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

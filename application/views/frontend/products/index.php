<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- page-banner9 -->
    <section class="page-banner9">
        <div class="shape"></div>
        <div class="shape3"></div>
        <div class="staff-text">Platforms</div>
        <div class="container">
            <div class="page-content">
                <h1 class="title">/ Software Products /</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li>/</li>
            <li>Products</li>
        </ul>
    </section>
    <!-- End page-banner9 -->

    <!-- shop-sec -->
    <div class="shop-sec ibt-section-gap">
        <button class="sidebar-toggle" aria-label="Open sidebar"></button>
        <!-- Overlay -->
        <div class="sidebar-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div class="shop-product">
                        <div class="sec-title">
                            <span class="sub-title">products</span>
                            <h2 class="title animated-heading">Software Products and Digital Platforms for Your Business</h2>
                            <p>Each platform is tailored to your requirements and quoted to suit your project. Contact us to discuss which one fits your business.</p>
                        </div>
                        <div class="row">
<?php $this->load->view('frontend/products/_cards'); ?>
</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="side-bar2">
                        <button class="sidebar-close" aria-label="Close sidebar"></button>
                        <div class="ser-widget side-widget2">
<?php $this->load->view('frontend/products/_side_links'); ?>
</div>
                        <div class="post-widget side-widget2">
                            <h3 class="side-bar-title h4">Related Services</h3>
                            <div class="recent-post2">
                                <a href="<?= service_link('web-apps') ?>"><img src="<?= asset('assets/images/blog/related-1.png') ?>" width="75" height="70" alt="" loading="lazy" decoding="async"></a>
                                <h3 class="title h4"><a href="<?= service_link('web-apps') ?>">Web Applications</a></h3>
                                <span class="sub-title">/ Development /</span>
                            </div>
                            <div class="recent-post2">
                                <a href="<?= service_link('ui-ux') ?>"><img src="<?= asset('assets/images/blog/related-2.png') ?>" width="75" height="70" alt="" loading="lazy" decoding="async"></a>
                                <h3 class="title h4"><a href="<?= service_link('ui-ux') ?>">UI/UX Design</a></h3>
                                <span class="sub-title">/ Design /</span>
                            </div>
                            <div class="recent-post2 mb-0">
                                <a href="<?= service_link('aws') ?>"><img src="<?= asset('assets/images/blog/related-3.png') ?>" width="75" height="70" alt="" loading="lazy" decoding="async"></a>
                                <h3 class="title h4"><a href="<?= service_link('aws') ?>">AWS Cloud Solutions</a></h3>
                                <span class="sub-title">/ Cloud /</span>
                            </div>
                        </div>
                        <div class="tag-list-widget side-widget2">
                            <h3 class="side-bar-title h4">Tags</h3>
                            <ul class="tag-list">
                                <li><a href="<?= service_link('web-design') ?>">/ Websites /</a></li>
                                <li><a href="<?= service_link('ecommerce') ?>">/ E-commerce /</a></li>
                                <li><a href="<?= service_link('custom-software') ?>">/ Software /</a></li>
                                <li><a href="<?= service_link('wordpress') ?>">/ WordPress /</a></li>
                                <li><a href="<?= service_link('cloud') ?>">/ Cloud /</a></li>
                                <li><a href="<?= service_link('aws') ?>">/ AWS /</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End shop-sec -->

    <!-- main-sec -->
    <section class="main-sec dark">
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

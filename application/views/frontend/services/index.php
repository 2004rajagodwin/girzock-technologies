<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- page-banner -->
    <section class="page-banner3">
        <div class="shape"></div>
        <div class="shape3"></div>
        <div class="staff-text">Services</div>
        <div class="container">
            <div class="page-content">
                <h1 class="title">/ Our Services /</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li>/</li>
            <li>Services</li>
        </ul>
    </section>
    <!-- End page-banner -->

    <!-- service-sec6 -->
    <section class="service-sec6 ibt-section-gap">
        <h2 class="visually-hidden">Our core services</h2>
        <div class="container2">
            <div class="row">
<?php $this->load->view('frontend/services/_cards'); ?>
</div>
        </div>
    </section>
    <!-- End service-sec6 -->

    <!-- marquee-sec -->
    <section class="marquee-sec">
        
        <div class="marquee">
            <div class="marquee-inner">
                <span>/ Website design. Custom software. Web applications. E-commerce. WordPress. UI/UX. Cloud. AWS. IT consulting.</span>
                <span>/ Website design. Custom software. Web applications. E-commerce. WordPress. UI/UX. Cloud. AWS. IT consulting.</span>
            </div>
        </div>
    </section>
    <!-- End marquee-sec -->

    <!-- feature-style10 -->
    <section class="feature-sec10 ibt-section-gap">
        <div class="container">
            <div class="sec-title">
                <span class="sub-title">more services</span>
                <h2 class="title animated-heading">More Software, Cloud and Support Services for Your Business</h2>
            </div>
            <div class="row">
                <?php $this->load->view('frontend/services/_features'); ?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature5.svg') ?>" width="26" height="27" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Tailored Solutions</h3>
                        <p>Every project is scoped around your specific business requirements and budget.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature6.svg') ?>" width="32" height="32" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Built for Every Device</h3>
                        <p>Layouts and interactions are designed to work on phones, tablets and desktops.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature7.svg') ?>" width="26" height="26" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Deployment &amp; Integration</h3>
                        <p>We connect your new platform with the tools and services you already use.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-card10">
                        <img src="<?= asset('assets/images/feature/feature8.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                        <h3 class="title h4">Support After Launch</h3>
                        <p>Maintenance and improvements keep your website or software secure and up to date.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End feature-style10 -->

    <!-- testimonials-sec -->
    <section class="testimonials-sec v2">
        <div class="container2">
            <div class="row">
                <div class="col-lg-7">
                    <div class="testi-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="<?= asset('assets/images/icon/icon12.svg') ?>" width="55" height="55" loading="lazy" decoding="async" alt="">
                                <p>Develop: we start by understanding your business, then design and build the website or software that fits what you need today.</p>
                                <span>- Stage 1, Develop</span>
                            </div>
                            <div class="swiper-slide">
                                <img src="<?= asset('assets/images/icon/icon12.svg') ?>" width="55" height="55" loading="lazy" decoding="async" alt="">
                                <p>Expand: once your platform is live, we add features, integrations and cloud capacity as your customers and your team grow.</p>
                                <span>- Stage 2, Expand</span>
                            </div>
                            <div class="swiper-slide">
                                <img src="<?= asset('assets/images/icon/icon12.svg') ?>" width="55" height="55" loading="lazy" decoding="async" alt="">
                                <p>Transform: step by step, we help you replace manual processes with connected digital systems that change how your business runs.</p>
                                <span>- Stage 3, Transform</span>
                            </div>
                        </div>
                        <div class="slider-btn">
                            <!-- Navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="testimonial-content">
                        <img src="<?= asset('assets/images/layers/mask.png') ?>" width="740" height="792" alt="" loading="lazy" decoding="async">
                        <div class="title-area2">
                            <div class="sec-title white">
                                <span class="sub-title">our approach</span>
                                <h2 class="title animated-heading">How We Take Your Project from Idea to Growth</h2>
                            </div>
                            <div class="testi-count">
                                <h4>
                                    <span class="counter-number" data-target="3">0</span>
                                    <span class="counter-text"></span>
                                </h4>
                                <span>Stages</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End testimonials-sec -->

    <!-- pricing-sec3 -->
    <section class="pricing-sec3 ibt-section-gap">
        <div class="container">
            <div class="sec-title">
                <span class="sub-title">engagement</span>
                <h2 class="title animated-heading">Choose the Way of Working That Fits Your Needs</h2>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="price-content3">
                        <div class="price-card3">
                            <div class="price-heade3">
                                <h3 class="title h4">Project</h3>
                                <span>A defined scope and outcome</span>
                            </div>
                            <ul class="price-item2">
                                <li>Requirements and planning</li>
                                <li>Design and development</li>
                                <li>Testing and launch</li>
                                <li>Handover and guidance</li>
                            </ul>
                            <div class="price-item-price3">
                                <h3 class="price h4">Quote</h3>
                                <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                                    <span>Get started</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                        <div class="price-img3">
                            <img src="<?= asset('assets/images/layers/gradi.png') ?>" width="70" height="564" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="price-content3">
                        <div class="price-card3 v2">
                            <div class="price-heade3">
                                <h3 class="title h4">Ongoing</h3>
                                <span>Continuous product development</span>
                            </div>
                            <ul class="price-item2">
                                <li>Regular feature releases</li>
                                <li>Shared priorities and roadmap</li>
                                <li>Integrations and improvements</li>
                                <li>Progress updates</li>
                            </ul>
                            <div class="price-item-price3">
                                <h3 class="price h4">Quote</h3>
                                <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                                    <span>Get started</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                        <div class="price-img3">
                            <img src="<?= asset('assets/images/layers/gradi2.png') ?>" width="75" height="564" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="price-content3">
                        <div class="price-card3 v3">
                            <div class="price-heade3">
                                <h3 class="title h4">Care</h3>
                                <span>Support for live platforms</span>
                            </div>
                            <ul class="price-item2">
                                <li>Updates and maintenance</li>
                                <li>Issue fixing</li>
                                <li>Cloud and hosting support</li>
                                <li>Technical advice</li>
                            </ul>
                            <div class="price-item-price3">
                                <h3 class="price h4">Quote</h3>
                                <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                                    <span>Get started</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                        <div class="price-img3">
                            <img src="<?= asset('assets/images/layers/gradi3.png') ?>" width="75" height="564" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End pricing-sec3 -->

    <!-- neural-playground -->
    <section class="neural-playground7 ibt-section-gapBottom">
        <div class="container3">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <div class="neural-img">
                        <img src="<?= asset('assets/images/layers/layer.png') ?>" width="455" height="642" alt="" loading="lazy" decoding="async">
                    </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12">
                    <div class="neural-content">
                        <h2 class="gradient-title">We turn <span>your ideas into dependable software</span> that helps your business develop, expand and transform.</h2>
                        <div class="swiper brand">
                            <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-html5.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="HTML5"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-css3.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="CSS3"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-javascript.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="JavaScript"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-php.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="PHP"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-wordpress.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="WordPress"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-aws.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="AWS"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-html5.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="HTML5"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-css3.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="CSS3"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-javascript.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="JavaScript"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-php.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="PHP"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-wordpress.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="WordPress"></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('services') ?>"><img src="<?= asset('assets/images/brand/tech-aws.svg') ?>" width="170" height="53" loading="lazy" decoding="async" alt="AWS"></a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End neural-playground -->

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

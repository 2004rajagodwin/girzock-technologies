<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- hero-style2 -->
        <section class="hero-style2">
            <div class="swiper hero-slider2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="hero-content2">
                            <img src="<?= asset('assets/images/bg/bg2.png') ?>" width="1883" height="855" alt="">
                            <div class="hero-text2">
                                <div class="container">
                                    <div class="hero-sec-info2 one-time">
                                        <h1 class="title animated-heading">Website, Software &amp; Digital Solutions in Tirunelveli</h1>
                                        <div class="hero-btn2">
                                            <p>GIRZOCK Technologies is a software development company in Thisaiyanvilai, Tirunelveli District, building dependable websites, custom software and cloud solutions for growing businesses.</p>
                                            <div class="girzock-btn-group">
                                                <a class='ibt-btn ibt-btn-secondary' href="<?= site_url('services') ?>">
                                                    <span>Discover</span>
                                                    <i class="icon-arrow-top"></i>
                                                </a>
                                                <a class='ibt-btn ibt-btn-outline girzock-btn-light' href="<?= site_url('contact') ?>">
                                                    <span>Start a Project</span>
                                                    <i class="icon-arrow-top"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="exp-box">
                                <div class="video-img">
                                    <img src="<?= asset('assets/images/event/video.png') ?>" width="190" height="157" alt="">
                                    <a href="<?= site_url('portfolio') ?>" class="video-popup">
                                        <i class="fa fa-arrow-right"></i> <span>Our Portfolio</span>
                                    </a>
                                </div>
                                <div class="counter-box2">
<span class="counter-number" data-target="10">0</span>
                                    <span class="counter-text">+</span>
                                </div>
                                <p>Core Services for Your Business</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="hero-content2">
                            <img src="<?= asset('assets/images/bg/hero-slide2.png') ?>" width="1883" height="855" alt="">
                            <div class="hero-text2">
                                <div class="container">
                                    <div class="hero-sec-info2 one-time">
                                        <h2 class="title">Complete Digital Solutions for Growing Businesses</h2>
                                        <div class="hero-btn2">
                                            <p>We plan, design and build the technology that helps your business grow and elevate what it can do.</p>
                                            <div class="girzock-btn-group">
                                                <a class='ibt-btn ibt-btn-secondary' href="<?= site_url('services') ?>">
                                                    <span>Discover</span>
                                                    <i class="icon-arrow-top"></i>
                                                </a>
                                                <a class='ibt-btn ibt-btn-outline girzock-btn-light' href="<?= site_url('contact') ?>">
                                                    <span>Start a Project</span>
                                                    <i class="icon-arrow-top"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="exp-box">
                                <div class="video-img">
                                    <img src="<?= asset('assets/images/event/video.png') ?>" width="190" height="157" alt="">
                                    <a href="<?= site_url('portfolio') ?>" class="video-popup">
                                        <i class="fa fa-arrow-right"></i> <span>Our Portfolio</span>
                                    </a>
                                </div>
                                <div class="counter-box2">
<span class="counter-number" data-target="10">0</span>
                                    <span class="counter-text">+</span>
                                </div>
                                <p>Core Services for Your Business</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-btn">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        <!-- End hero-style2 -->

        <!-- service-sec6 (index3) -->
        <section class="service-sec6 ibt-section-gap" id="services-overview">
            <div class="title-area">
                <div class="container">
                    <div class="row end">
                        <div class="col-xl-6 col-lg-12">
                            <div class="sec-title mb-0">
                                <span class="sub-title">services</span>
                                <h2 class="title animated-heading">Software Services for Your Business</h2>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <div class="sec-btn-box">
                                <p>We have the services to help your business grow.</p>
                                <a class='ibt-btn ibt-btn-outline' href="<?= site_url('services') ?>">
                                    <span>Explore More</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="row">
<?php $this->load->view('frontend/home/_service_overview'); ?>
</div>
            </div>
        </section>
        <!-- End service-sec6 -->

        <!-- about-us-sec (index1) -->
        <section class="about-us-sec" id="about-girzock">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="about-img">
                            <img src="<?= asset('assets/images/layers/person.png') ?>" width="805" height="1338" loading="lazy" decoding="async" alt="">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="about-content">
                            <div class="style-text gz-flow-text"><?php $this->load->view('frontend/partials/flow_text', array('flow_id' => 'about', 'lines' => array('GIRZOCK', 'Technologies'))); ?></div>
                            <div class="sec-title mb-0 white">
                                <span class="sub-title">about</span>
                                <h2 class="title animated-heading">Technology That Moves Your Business Forward</h2>
                                <p>GIRZOCK Technologies delivers practical digital solutions that help businesses improve operations, strengthen their online presence and grow with confidence.</p>
                                <p class="paragraph">Based in Thisaiyanvilai, Tirunelveli, we design and build websites, custom software and cloud solutions around what your business needs.</p>
                                <a class='ibt-btn ibt-btn-outline' href="<?= site_url('about') ?>">
                                    <span>Discover Our Company</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-us-sec -->

        <!-- service-sec15 (index10) -->
        <section class="service-sec15 ibt-section-gap" id="core-services">
            <div class="title-area">
                <div class="container">
                    <div class="row end">
                        <div class="col-lg-7">
                            <div class="sec-title mb-0">
                                <span class="sub-title">our core services</span>
                                <h2 class="title animated-heading">Complete Digital Solutions Under One Roof</h2>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="sec-btn-box">
                                <div class="slider-btn5">
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="swiper ser-slider15">
                    <div class="swiper-wrapper">
<?php $this->load->view('frontend/home/_core_services'); ?>
</div>
                </div>
            </div>
        </section>
        <!-- End service-sec15 -->

        <!-- faq-sec3 (index6) -->
        <section class="faq-sec3 ibt-section-gapBottom" id="why-girzock">
            <div class="faq-tabs">
                <div class="faq-content">
                    <div class="sec-title white">
                        <span class="sub-title">why choose girzock</span>
                        <h2 class="title animated-heading">Why Businesses Choose GIRZOCK Technologies</h2>
                        <p>We combine technical expertise, thoughtful design and practical innovation to build digital solutions that support real business needs.</p>
                    </div>
                    <div class="accordion" id="accordionWhy">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="whyHeading0">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#whyBody0" aria-expanded="true" aria-controls="whyBody0">
                                    Business-Focused Solutions
                                </button>
                            </h3>
                            <div id="whyBody0" class="accordion-collapse collapse show" aria-labelledby="whyHeading0" data-bs-parent="#accordionWhy">
                                <div class="accordion-body">Technology designed around your business requirements.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="whyHeading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#whyBody1" aria-expanded="false" aria-controls="whyBody1">
                                    Modern Technologies
                                </button>
                            </h3>
                            <div id="whyBody1" class="accordion-collapse collapse" aria-labelledby="whyHeading1" data-bs-parent="#accordionWhy">
                                <div class="accordion-body">Using modern development tools and technologies.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="whyHeading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#whyBody2" aria-expanded="false" aria-controls="whyBody2">
                                    Quality Development
                                </button>
                            </h3>
                            <div id="whyBody2" class="accordion-collapse collapse" aria-labelledby="whyHeading2" data-bs-parent="#accordionWhy">
                                <div class="accordion-body">Clean, scalable and maintainable solutions.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="whyHeading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#whyBody3" aria-expanded="false" aria-controls="whyBody3">
                                    Responsive Experiences
                                </button>
                            </h3>
                            <div id="whyBody3" class="accordion-collapse collapse" aria-labelledby="whyHeading3" data-bs-parent="#accordionWhy">
                                <div class="accordion-body">Websites and applications designed for all devices.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="whyHeading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#whyBody4" aria-expanded="false" aria-controls="whyBody4">
                                    Transparent Communication
                                </button>
                            </h3>
                            <div id="whyBody4" class="accordion-collapse collapse" aria-labelledby="whyHeading4" data-bs-parent="#accordionWhy">
                                <div class="accordion-body">Clear communication throughout the development process.</div>
                            </div>
                        </div>
                        <div class="accordion-item mb-0">
                            <h3 class="accordion-header" id="whyHeading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#whyBody5" aria-expanded="false" aria-controls="whyBody5">
                                    Ongoing Support
                                </button>
                            </h3>
                            <div id="whyBody5" class="accordion-collapse collapse" aria-labelledby="whyHeading5" data-bs-parent="#accordionWhy">
                                <div class="accordion-body">Assistance and technical support after project delivery.</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                        <span>Start a Project</span>
                        <i class="icon-arrow-top"></i>
                    </a>
                </div>
                <div class="faq-img3">
                    <img src="<?= asset('assets/images/event/faq3.png') ?>" width="664" height="1004" loading="lazy" decoding="async" alt="">
                    <div class="feature-ai">
                        <div class="title">Why GIRZOCK</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End faq-sec3 -->

        <!-- project-sec3 (index7) -->
        <section class="project-sec3" id="showcase">
            <div class="container">
                <div class="sec-title">
                    <span class="sub-title">ideas in motion</span>
                    <h2 class="title animated-heading">Innovative Technology Ideas</h2>
                    <p>Explore creative digital concepts, modern technology and innovative solutions designed to move businesses forward.</p>
                </div>
            </div>
            <div class="container2">
                <div class="project-track">
                    <div class="project-block3">
                        <img src="<?= asset('assets/images/project/project3-1.png') ?>" width="293" height="388" loading="lazy" decoding="async" alt="Abstract technology artwork">
                        <span class="text">Websites</span>
                    </div>
                    <div class="project-block3">
                        <img src="<?= asset('assets/images/project/project3-2.png') ?>" width="294" height="290" loading="lazy" decoding="async" alt="Abstract technology artwork">
                    </div>
                    <div class="project-block3">
                        <img src="<?= asset('assets/images/project/track-3.png') ?>" width="294" height="388" loading="lazy" decoding="async" alt="Abstract technology artwork">
                    </div>
                    <div class="project-block3">
                        <img src="<?= asset('assets/images/project/project3-4.png') ?>" width="293" height="442" loading="lazy" decoding="async" alt="Abstract technology artwork">
                        <span class="text v2">Software</span>
                    </div>
                    <div class="project-block3">
                        <img src="<?= asset('assets/images/project/track-5.png') ?>" width="294" height="290" loading="lazy" decoding="async" alt="Abstract technology artwork">
                    </div>
                    <div class="project-block3">
                        <img src="<?= asset('assets/images/project/project3-6.png') ?>" width="294" height="388" loading="lazy" decoding="async" alt="Abstract technology artwork">
                        <span class="text v3">Cloud</span>
                    </div>
                </div>
            </div>
        </section>
        <!-- End project-sec3 -->

        <!-- neural-playground (index1) -->
        <section class="neural-playground ibt-section-gap" id="technologies">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="neural-img">
                            <img src="<?= asset('assets/images/layers/layer.png') ?>" width="455" height="642" loading="lazy" decoding="async" alt="">
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <div class="neural-content p-0">
                            <h2 class="gradient-title">Powered by <span>Modern Technologies</span></h2>
                            <div class="swiper brand">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="HTML5"><img src="<?= asset('assets/images/brand/stack-html5.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="HTML5"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="CSS3"><img src="<?= asset('assets/images/brand/stack-css3.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="CSS3"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="JavaScript"><img src="<?= asset('assets/images/brand/stack-javascript.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="JavaScript"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="Bootstrap"><img src="<?= asset('assets/images/brand/stack-bootstrap.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="Bootstrap"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="React"><img src="<?= asset('assets/images/brand/stack-react.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="React"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="PHP"><img src="<?= asset('assets/images/brand/stack-php.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="PHP"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="Laravel"><img src="<?= asset('assets/images/brand/stack-laravel.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="Laravel"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="WordPress"><img src="<?= asset('assets/images/brand/stack-wordpress.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="WordPress"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="MySQL"><img src="<?= asset('assets/images/brand/stack-mysql.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="MySQL"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="Java"><img src="<?= asset('assets/images/brand/stack-java.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="Java"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="Spring Boot"><img src="<?= asset('assets/images/brand/stack-spring-boot.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="Spring Boot"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="Node.js"><img src="<?= asset('assets/images/brand/stack-nodejs.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="Node.js"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="AWS"><img src="<?= asset('assets/images/brand/stack-aws.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="AWS"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="<?= site_url('services') ?>" aria-label="Git"><img src="<?= asset('assets/images/brand/stack-git.svg') ?>" width="190" height="53" loading="lazy" decoding="async" alt="Git"></a>
                                    </div>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End neural-playground -->

        <!-- lanuguage-sec (index9) -->
        <section class="lanuguage-sec ibt-section-gap" id="without-borders">
            <div class="container">
                <div class="title-area">
                    <div class="row align-items-end">
                        <div class="col-xl-7 col-lg-9 col-md-12 col-sm-12">
                            <div class="sec-title mb-0">
                                <span class="sub-title">who we help</span>
                                <h2 class="title animated-heading">Technology for Local Businesses</h2>
                                <p>From Thisaiyanvilai, we build websites and software for many kinds of organisation.</p>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-sm-7">
                            <div class="user-count">
                                <div class="counter-box5">
                                    <span class="counter-text">Local</span>
                                </div>
                                <span class="user">Focus</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="languages-content">
                    <div class="world-languages">
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/retail.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Retail</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/wholesale.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Wholesale</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/manufacturers.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Manufacturers</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/schools.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Schools</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/colleges.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Colleges</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/training.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Training</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/clinics.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Clinics</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/hospitals.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Hospitals</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/hotels.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Hotels</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/restaurants.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Restaurants</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/travel.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Travel</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/real-estate.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Real Estate</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/builders.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Builders</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/logistics.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Logistics</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/exporters.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Exporters</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/startups.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Startups</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/family-firms.svg') ?>" width="60" height="60" loading="lazy" decoding="async" alt="">
                            <span>Family Firms</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/agencies.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Agencies</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/consultants.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Consultants</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/interiors.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Interiors</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/vehicle-sales.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Vehicle Sales</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/repairs.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Repairs</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/fitness.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Fitness</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/salons.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Salons</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/trusts.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Trusts</span>
                        </a>
                        <a href="<?= site_url('contact') ?>">
                            <img src="<?= asset('assets/images/industry/events.svg') ?>" width="30" height="30" loading="lazy" decoding="async" alt="">
                            <span>Events</span>
                        </a>
                    </div>
                    <a class='ibt-btn ibt-btn-outline' href="<?= site_url('contact') ?>">
                        <span>Tell Us About Your Business</span>
                        <i class="icon-arrow-top"></i>
                    </a>
                </div>
            </div>
        </section>
        <!-- End lanuguage-sec -->

        <!-- fun-fact-sec -->
        <section class="fun-fact-sec ibt-section-gapTop" id="strengths">
            <div class="container">
                <div class="sec-title">
                    <span class="sub-title">at a glance</span>
                    <h2 class="title animated-heading">What GIRZOCK Technologies Offers at a Glance</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="fun-fact-content black">
                            <div class="counter-box">
                                <span class="counter-number percent-counter" data-target="<?= (int) $service_count ?>">0</span>
                                <span class="counter-text">services</span>
                            </div>
                            <span class="title">Under One Roof</span>
                            <p>From website design to AWS cloud solutions and IT consulting.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-content">
                            <div class="counter-box">
                                <span class="counter-number percent-counter" data-target="14">0</span>
                            </div>
                            <span class="title">Technologies</span>
                            <p>Modern tools, from HTML5 and React to Laravel, Spring Boot and AWS.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-content">
                            <div class="counter-box">
                                <span class="counter-number percent-counter" data-target="4">0</span>
                            </div>
                            <span class="title">Process Stages</span>
                            <p>Discover, strategize, design and develop, launch and support.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End fun-fact-sec -->

        <!-- service-sec2 (index1) -->
        <section class="service-sec2 ibt-section-gapBottom" id="strength-areas">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="ser-block2">
                            <img src="<?= asset('assets/images/service/ser2-1.svg') ?>" width="73" height="73" loading="lazy" decoding="async" alt="">
                            <h3 class="title h4">Web and Software Engineering</h3>
                            <ul class="ser-list">
                                <li>Website design and development</li>
                                <li>Custom software development</li>
                                <li>Web application development</li>
                                <li>E-commerce and WordPress</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="ser-block2">
                            <img src="<?= asset('assets/images/service/ser2-2.svg') ?>" width="74" height="73" loading="lazy" decoding="async" alt="">
                            <h3 class="title h4">Cloud and Infrastructure</h3>
                            <ul class="ser-list">
                                <li>Cloud computing</li>
                                <li>AWS cloud solutions</li>
                                <li>Deployment and integration</li>
                                <li>Maintenance and support</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="ser-block2">
                            <img src="<?= asset('assets/images/service/ser2-3.svg') ?>" width="69" height="71" loading="lazy" decoding="async" alt="">
                            <h3 class="title h4">Design and Consulting</h3>
                            <ul class="ser-list">
                                <li>UI/UX design</li>
                                <li>Requirements and planning</li>
                                <li>IT consulting</li>
                                <li>Digital transformation advice</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End service-sec2 -->

        <!-- Feature-sec6 (index5) -->
        <section class="Feature-sec6" id="custom-software-solutions">
            <div class="container">
                <div class="row girzock-software-intro">
                    <div class="col-lg-6">
                        <div class="sec-title white">
                            <span class="sub-title">custom software solutions</span>
                            <h2 class="title animated-heading">Software Built Around Your Business</h2>
                          
                        </div>
                      
                    </div>



                </div>
                <div class="feature-tabs6">
                    <nav aria-label="Custom software solutions">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a href="#" class="nav-link active" id="nav-automation-tab" data-bs-toggle="tab" data-bs-target="#nav-automation" role="tab" aria-controls="nav-automation" aria-selected="true">
                                <div class="tab-heade">
                                    <svg width="55" height="55" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M54.8716 17.1725C54.8733 17.1697 54.8755 17.1674 54.8772 17.1646C54.8807 17.1589 54.8834 17.153 54.8869 17.1472C54.8953 17.1331 54.9033 17.1189 54.9108 17.1042C54.9158 17.0944 54.9205 17.0845 54.925 17.0746C54.9314 17.0607 54.9375 17.0468 54.9432 17.0325C54.9477 17.0212 54.9518 17.0098 54.9557 16.9984C54.9601 16.9854 54.9644 16.9724 54.9681 16.959C54.9719 16.9459 54.9753 16.9328 54.9783 16.9195C54.9811 16.9076 54.9836 16.8955 54.9859 16.8834C54.9886 16.8685 54.9909 16.8538 54.9927 16.8389C54.9941 16.8278 54.9955 16.8166 54.9963 16.8053C54.9977 16.7893 54.9984 16.7733 54.9988 16.7572C54.999 16.7503 54.9999 16.7437 54.9999 16.7368C54.9999 16.7327 54.9994 16.7286 54.9993 16.7245C54.999 16.7093 54.9981 16.6941 54.997 16.679C54.9961 16.6667 54.9954 16.6544 54.9939 16.6423C54.9924 16.6298 54.9902 16.6174 54.9882 16.605C54.9858 16.5908 54.9835 16.5765 54.9805 16.5626C54.9783 16.5525 54.9754 16.5425 54.9728 16.5325C54.9687 16.517 54.9647 16.5015 54.9599 16.4864C54.9568 16.4772 54.9532 16.4681 54.9498 16.459C54.9443 16.4438 54.9389 16.4287 54.9324 16.414C54.928 16.4038 54.9228 16.394 54.9179 16.384C54.9115 16.371 54.9055 16.358 54.8985 16.3454C54.8918 16.3334 54.8844 16.3218 54.8771 16.3101C54.8708 16.3001 54.8649 16.29 54.8583 16.2804C54.8494 16.2676 54.8397 16.2552 54.8302 16.2428C54.8239 16.2348 54.818 16.2266 54.8114 16.2187C54.8014 16.2068 54.7907 16.1955 54.7799 16.1841C54.7726 16.1763 54.7655 16.1684 54.7578 16.1608C54.7478 16.151 54.7372 16.1418 54.7266 16.1324C54.7169 16.1238 54.7072 16.1152 54.6971 16.1071C54.6879 16.0997 54.6782 16.0928 54.6686 16.0858C54.656 16.0766 54.6434 16.0676 54.6303 16.0591C54.6269 16.057 54.6239 16.0544 54.6205 16.0523L47.732 11.7471C47.7273 11.7441 47.7225 11.7419 47.7177 11.7391C47.7081 11.7334 47.6988 11.7276 47.689 11.7223C47.683 11.7191 47.6769 11.7161 47.6709 11.713C47.6612 11.7081 47.6514 11.7036 47.6415 11.699C47.6337 11.6954 47.6259 11.6916 47.6178 11.6882C47.6122 11.6858 47.6066 11.6838 47.601 11.6816C47.5879 11.6764 47.5748 11.6717 47.5616 11.6673C47.5567 11.6657 47.5522 11.6635 47.5472 11.662C47.5457 11.6616 47.5442 11.6613 47.5428 11.6608C47.5381 11.6594 47.5333 11.6583 47.5286 11.6569C47.5132 11.6523 47.4978 11.6486 47.4823 11.645C47.4764 11.6437 47.4706 11.6419 47.4647 11.6407C47.4608 11.64 47.4569 11.6396 47.4531 11.6389C47.4373 11.636 47.4216 11.6336 47.4058 11.6316C47.3945 11.6302 47.3832 11.6288 47.3718 11.6278C47.3579 11.6266 47.3441 11.626 47.3302 11.6255C47.317 11.6251 47.3038 11.6248 47.2906 11.625C47.2786 11.6252 47.2666 11.6259 47.2546 11.6266C47.2498 11.6269 47.2451 11.6269 47.2404 11.6273C47.2373 11.6275 47.2341 11.6274 47.231 11.6277C47.2244 11.6283 47.218 11.6295 47.2115 11.6303C47.2004 11.6316 47.1894 11.6333 47.1783 11.635C47.1746 11.6355 47.171 11.636 47.1674 11.6366C47.1624 11.6375 47.1575 11.6378 47.1527 11.6388C47.1466 11.64 47.1408 11.6417 47.1349 11.643C47.1238 11.6453 47.1128 11.6482 47.1017 11.651C47.088 11.6546 47.0743 11.6583 47.0608 11.6626C47.049 11.6663 47.0374 11.6705 47.0258 11.6748C47.0171 11.678 47.0084 11.6806 47 11.6841C46.9965 11.6855 46.993 11.6874 46.9895 11.6889C46.9769 11.6942 46.9646 11.7001 46.9524 11.706C46.944 11.7101 46.9353 11.7139 46.9271 11.7182C46.9262 11.7186 46.9252 11.719 46.9244 11.7195L34.5934 18.296L27.2636 9.33739C27.2633 9.33695 27.2629 9.33663 27.2626 9.3362C27.2603 9.3334 27.2579 9.33071 27.2556 9.32791C27.2499 9.32113 27.2436 9.315 27.2377 9.30843C27.2263 9.29573 27.2149 9.28292 27.2026 9.27098C27.1955 9.26398 27.1877 9.25763 27.1802 9.25096C27.1685 9.2403 27.157 9.22954 27.1446 9.21953C27.1329 9.21016 27.1204 9.20166 27.1082 9.19284C27.1073 9.19219 27.1064 9.19144 27.1054 9.19079C27.0974 9.18509 27.0896 9.17884 27.0813 9.17335C27.0689 9.16517 27.0557 9.15807 27.0428 9.15054C27.033 9.14483 27.0234 9.1387 27.0134 9.13342C27.0013 9.12707 26.9886 9.1218 26.9762 9.11609C26.9646 9.11082 26.9533 9.10501 26.9416 9.10027C26.9304 9.09575 26.9188 9.0922 26.9073 9.08822C26.8936 9.08337 26.88 9.07831 26.8662 9.07422C26.8644 9.07369 26.8627 9.07293 26.861 9.0725C26.8487 9.06895 26.8364 9.0668 26.8242 9.06389C26.8131 9.06131 26.8021 9.0583 26.7908 9.05614C26.7861 9.05528 26.7815 9.05421 26.7767 9.05334L2.67121 4.74838C2.66325 4.74698 2.65539 4.74655 2.64743 4.74537C2.6329 4.74322 2.61847 4.74117 2.60394 4.73977C2.5906 4.73848 2.57747 4.73784 2.56423 4.7373C2.55163 4.73676 2.53904 4.73633 2.52645 4.73633C2.51203 4.73633 2.49771 4.73687 2.4834 4.73773C2.47177 4.73837 2.46004 4.73923 2.44842 4.74031C2.43399 4.74171 2.41968 4.74365 2.40547 4.74591C2.39363 4.74774 2.3819 4.74978 2.37017 4.75204C2.3566 4.75473 2.34326 4.75785 2.32991 4.7613C2.31753 4.76442 2.30516 4.76786 2.29289 4.77163C2.28051 4.7754 2.26845 4.77949 2.25629 4.7839C2.24348 4.78853 2.23089 4.79337 2.2183 4.79865C2.20667 4.80349 2.19537 4.80876 2.18396 4.81415C2.17169 4.81996 2.15953 4.82599 2.14748 4.83244C2.13574 4.83879 2.12433 4.84547 2.11303 4.85236C2.10216 4.85892 2.09129 4.86559 2.08064 4.8727C2.06815 4.88109 2.0561 4.88992 2.04415 4.89896C2.03791 4.9037 2.03123 4.90779 2.0251 4.91274C2.02219 4.915 2.01982 4.91758 2.01692 4.91995C2.00486 4.92985 1.99335 4.9404 1.98183 4.95105C1.97354 4.9587 1.96504 4.96623 1.95707 4.9742C1.94674 4.98453 1.93716 4.99551 1.92737 5.00638C1.9193 5.01542 1.91101 5.02424 1.90347 5.0335C1.89486 5.04405 1.8869 5.05524 1.87883 5.06633C1.87129 5.07655 1.86354 5.08667 1.85655 5.09711C1.84923 5.1082 1.84266 5.11971 1.83588 5.13123C1.82921 5.14242 1.82232 5.1534 1.81629 5.16481C1.81026 5.17622 1.80499 5.18817 1.7995 5.1999C1.7938 5.21206 1.78788 5.22412 1.78282 5.23649C1.77808 5.2479 1.77421 5.25974 1.77001 5.27147C1.76527 5.28482 1.76032 5.29817 1.75634 5.31173C1.753 5.32292 1.75031 5.33455 1.74741 5.34606C1.74375 5.3607 1.74009 5.37523 1.73729 5.38998C1.73654 5.39375 1.73535 5.3974 1.73471 5.40117C1.7332 5.40935 1.73277 5.41742 1.73159 5.4256C1.72954 5.43981 1.7275 5.45402 1.7262 5.46833C1.72491 5.48168 1.72427 5.49492 1.72373 5.50816C1.72319 5.52086 1.72276 5.53356 1.72276 5.54626C1.72276 5.56047 1.72341 5.57457 1.72416 5.58867C1.7248 5.60061 1.72567 5.61245 1.72685 5.6244C1.72825 5.63861 1.73019 5.6526 1.73234 5.66659C1.73417 5.67865 1.73632 5.6907 1.73869 5.70265C1.74138 5.716 1.74439 5.72913 1.74784 5.74226C1.75107 5.75485 1.75451 5.76734 1.75828 5.77982C1.76205 5.79198 1.76614 5.80404 1.77044 5.81599C1.77507 5.82879 1.77991 5.8416 1.78519 5.8542C1.79003 5.86571 1.7952 5.87712 1.80058 5.88842C1.80639 5.90069 1.81242 5.91285 1.81887 5.92491C1.82512 5.93664 1.8319 5.94794 1.83868 5.95935C1.84524 5.97033 1.85192 5.9812 1.85913 5.99186C1.86742 6.00423 1.87624 6.01618 1.88518 6.02802C1.88991 6.03437 1.894 6.04104 1.89906 6.04729L7.04947 12.4853H0.807241C0.799922 12.4853 0.792926 12.4862 0.785714 12.4864C0.770861 12.4868 0.756008 12.4875 0.741155 12.4886C0.728131 12.4897 0.715215 12.4912 0.702407 12.4928C0.689814 12.4945 0.677221 12.4964 0.664736 12.4985C0.650528 12.501 0.636536 12.504 0.622652 12.5073C0.611458 12.5098 0.600372 12.5127 0.589286 12.5159C0.574971 12.5199 0.560978 12.5242 0.546986 12.529C0.536115 12.5327 0.525352 12.5366 0.514589 12.5408C0.50135 12.546 0.488327 12.5514 0.475519 12.5572C0.46411 12.5624 0.452808 12.5679 0.441615 12.5736C0.430098 12.5795 0.418689 12.5855 0.407495 12.592C0.395548 12.5987 0.383816 12.606 0.372192 12.6134C0.362182 12.6198 0.352387 12.6264 0.342701 12.6332C0.330861 12.6415 0.319344 12.6502 0.307935 12.6592C0.298679 12.6666 0.289746 12.674 0.28092 12.6816C0.270264 12.6909 0.259716 12.7003 0.249491 12.7101C0.240127 12.7191 0.231194 12.7282 0.22226 12.7376C0.213434 12.7468 0.204824 12.7563 0.196429 12.7661C0.186634 12.7775 0.17727 12.7893 0.168121 12.8012C0.163708 12.8069 0.158973 12.812 0.154667 12.8178C0.152192 12.8212 0.150254 12.8248 0.147886 12.8282C0.13863 12.8413 0.130127 12.8548 0.121624 12.8684C0.11592 12.8776 0.11 12.8869 0.104726 12.8962C0.0972994 12.9095 0.0905186 12.923 0.0837378 12.9367C0.0785714 12.9472 0.0732975 12.9576 0.0685617 12.9681C0.0629648 12.9808 0.0581213 12.9939 0.0531703 13.0069C0.0486497 13.0188 0.0439139 13.0308 0.0399315 13.0429C0.0360568 13.0549 0.0328278 13.0672 0.0294912 13.0794C0.0257241 13.093 0.0219569 13.1066 0.0190509 13.1202C0.0165753 13.1315 0.0148532 13.143 0.0128082 13.1544C0.0102251 13.1694 0.00764188 13.1844 0.00591977 13.1994C0.00462818 13.2103 0.00398239 13.2213 0.00322896 13.2324C0.00204501 13.2482 0.00107632 13.2641 0.000861057 13.2799C0.000538161 13.2841 0 13.2882 0 13.2925C0 13.2999 0.000861057 13.3069 0.00107632 13.3141C0.00150685 13.3289 0.00204501 13.3438 0.0033366 13.3586C0.00441292 13.3717 0.00591977 13.3845 0.00753425 13.3974C0.00914873 13.4101 0.0110861 13.4227 0.0133464 13.4352C0.0158219 13.4493 0.0188356 13.4632 0.0220646 13.4771C0.0247554 13.4884 0.0275538 13.4996 0.0306751 13.5107C0.0346575 13.5249 0.0389628 13.5388 0.0436986 13.5527C0.0474658 13.5638 0.0514481 13.5746 0.0557534 13.5855C0.0608121 13.5985 0.0661937 13.6115 0.0718982 13.6242C0.0771722 13.6358 0.0827691 13.6473 0.0884736 13.6587C0.0942857 13.67 0.100205 13.6812 0.106448 13.6922C0.113337 13.7043 0.120763 13.7163 0.128297 13.7281C0.13454 13.7379 0.140998 13.7476 0.147671 13.7571C0.156067 13.769 0.164892 13.7808 0.174041 13.7923C0.181252 13.8013 0.188571 13.8103 0.196106 13.819C0.205362 13.8297 0.214941 13.8403 0.224951 13.8506C0.233777 13.8599 0.242926 13.8688 0.25229 13.8776C0.261654 13.8865 0.271018 13.8952 0.28092 13.9037C0.292329 13.9135 0.304061 13.9227 0.3159 13.9319C0.321605 13.9363 0.326663 13.941 0.332583 13.9453L18.878 27.4329L15.5102 49.3238C15.5098 49.3264 15.5095 49.329 15.509 49.3316L15.5086 49.3342C15.5081 49.3376 15.5081 49.3408 15.5076 49.3441C15.5044 49.3671 15.5018 49.39 15.5005 49.4128C15.5 49.4218 15.5003 49.4307 15.5001 49.4396C15.4998 49.4567 15.4993 49.4738 15.5 49.4908C15.5005 49.5042 15.502 49.5172 15.5032 49.5303C15.5044 49.5428 15.5052 49.5553 15.5069 49.5677C15.509 49.5831 15.5122 49.5982 15.5152 49.6134C15.5172 49.6235 15.5188 49.6338 15.5213 49.6438C15.525 49.6593 15.5296 49.6743 15.5341 49.6895C15.537 49.6993 15.5397 49.7091 15.543 49.7188C15.5479 49.7328 15.5535 49.7465 15.5591 49.7602C15.5634 49.7709 15.5675 49.7817 15.5723 49.7921C15.5777 49.8038 15.5837 49.8152 15.5896 49.8266C15.5959 49.8387 15.6019 49.8508 15.6087 49.8625C15.6142 49.872 15.6203 49.881 15.6261 49.8903C15.6343 49.9032 15.6425 49.9161 15.6515 49.9286C15.6572 49.9364 15.6634 49.944 15.6693 49.9516C15.6793 49.9645 15.6893 49.9773 15.7002 49.9897C15.7066 49.997 15.7136 50.0039 15.7203 50.0111C15.7313 50.0227 15.7422 50.0344 15.7539 50.0453C15.7626 50.0535 15.772 50.0612 15.7811 50.069C15.7915 50.078 15.8017 50.087 15.8126 50.0954C15.8258 50.1057 15.8398 50.1151 15.8538 50.1246C15.8614 50.1297 15.8686 50.1352 15.8764 50.1401C15.8959 50.1523 15.9161 50.1635 15.9368 50.1742C15.9397 50.1757 15.9423 50.1774 15.9452 50.1789C15.9455 50.179 15.9458 50.1791 15.9461 50.1794C15.9734 50.1929 16.0014 50.205 16.0304 50.2155C16.0376 50.2181 16.0449 50.2199 16.0521 50.2223C16.0719 50.2289 16.092 50.2351 16.1125 50.2402C16.1261 50.2435 16.1397 50.2459 16.1532 50.2486C16.1633 50.2505 16.1731 50.2532 16.1835 50.2548C16.1869 50.2553 16.1902 50.2551 16.1937 50.2556C16.231 50.2608 16.2684 50.2644 16.3056 50.2644C16.306 50.2644 16.3065 50.2643 16.3068 50.2643H16.3072C16.3406 50.2643 16.3734 50.2615 16.406 50.2574C16.4125 50.2565 16.4188 50.2558 16.4253 50.2548C16.4919 50.2449 16.5563 50.2267 16.6172 50.2012C16.6231 50.1987 16.6289 50.1964 16.6348 50.1938C16.6642 50.1806 16.693 50.166 16.7206 50.1494C16.7257 50.1464 16.7304 50.143 16.7354 50.1399C16.7586 50.1252 16.781 50.1094 16.8027 50.0926C16.8091 50.0877 16.8156 50.0828 16.8218 50.0776C16.8458 50.0577 16.8686 50.0363 16.8903 50.0136C16.8957 50.0079 16.9008 50.002 16.9061 49.9962C16.9278 49.9721 16.9485 49.9469 16.9673 49.9202C16.9679 49.9193 16.9686 49.9186 16.9692 49.9178C16.9895 49.8885 17.0075 49.8575 17.024 49.8255C17.0252 49.8229 17.0271 49.8206 17.0284 49.818L22.9246 38.0255L42.4599 29.532C42.4652 29.5297 42.4699 29.5268 42.4751 29.5244C42.4907 29.5172 42.5061 29.5097 42.5212 29.5015C42.5226 29.5008 42.5242 29.5001 42.5257 29.4994C42.5281 29.4981 42.5306 29.4971 42.5331 29.4957C42.5387 29.4926 42.5438 29.4888 42.5494 29.4856C42.5616 29.4784 42.5737 29.4708 42.5854 29.463C42.5931 29.4578 42.601 29.453 42.6085 29.4476C42.6114 29.4455 42.6141 29.4432 42.617 29.441C42.6259 29.4346 42.6345 29.4278 42.643 29.4209C42.645 29.4193 42.6474 29.4182 42.6494 29.4165C42.6515 29.4148 42.6533 29.4128 42.6554 29.4111C42.6629 29.4049 42.6701 29.3985 42.6773 29.3919C42.6844 29.3855 42.6913 29.3788 42.6982 29.3722C42.6986 29.3718 42.6991 29.3715 42.6995 29.3711C42.7025 29.3682 42.7057 29.3657 42.7087 29.3627C42.711 29.3604 42.713 29.358 42.7153 29.3558C42.7207 29.3502 42.726 29.3446 42.7312 29.3389C42.7379 29.3316 42.7443 29.324 42.7507 29.3165C42.757 29.3093 42.7634 29.3022 42.7693 29.2947C42.7728 29.2904 42.776 29.2861 42.7794 29.2818C42.782 29.2784 42.7847 29.2749 42.7873 29.2715C42.7901 29.2676 42.7926 29.2635 42.7954 29.2597C42.7962 29.2585 42.797 29.2572 42.7979 29.256C42.8041 29.2472 42.8106 29.2385 42.8164 29.2294C42.8182 29.2265 42.82 29.2237 42.8219 29.2208C42.8281 29.2108 42.8338 29.2005 42.8396 29.1902C42.8451 29.1805 42.8508 29.1711 42.8559 29.1613C42.8561 29.1609 42.8564 29.1604 42.8566 29.1599C42.8574 29.1584 42.8581 29.1569 42.8589 29.1554C42.8647 29.1438 42.8699 29.1318 42.8751 29.12C42.8794 29.1103 42.8841 29.1007 42.8879 29.0908C42.8886 29.0892 42.8893 29.0876 42.89 29.0859C42.8949 29.0732 42.899 29.0602 42.9033 29.0472C42.904 29.0454 42.9046 29.0435 42.9053 29.0417C42.906 29.0393 42.9073 29.0372 42.9081 29.0348L42.9113 29.0245C42.9114 29.0243 42.9114 29.024 42.9115 29.0238L46.5367 17.5442H54.1907C54.1913 17.5442 54.1918 17.5443 54.1922 17.5443C54.1941 17.5443 54.1959 17.544 54.1977 17.544C54.2275 17.5438 54.2568 17.5419 54.2858 17.5385C54.2939 17.5376 54.302 17.536 54.3101 17.5349C54.3335 17.5314 54.3566 17.5272 54.3793 17.5218C54.3877 17.5199 54.396 17.5176 54.4043 17.5154C54.4275 17.5091 54.4502 17.5018 54.4725 17.4935C54.4795 17.4909 54.4866 17.4886 54.4936 17.4858C54.5225 17.4742 54.5509 17.4613 54.5781 17.4466C54.5787 17.4463 54.5794 17.4457 54.58 17.4454C54.6057 17.4313 54.6304 17.4156 54.6544 17.3988C54.6634 17.3925 54.6722 17.3857 54.6809 17.379C54.6969 17.3668 54.7124 17.3541 54.7274 17.3409C54.736 17.3333 54.7446 17.3257 54.7529 17.3177C54.7728 17.2985 54.7917 17.2785 54.8095 17.2574C54.8115 17.255 54.8137 17.253 54.8157 17.2506C54.836 17.2256 54.8543 17.1994 54.8716 17.1725ZM45.9389 14.0746L41.8177 27.1253L35.6358 19.5696L45.9389 14.0746ZM4.50074 6.71504L25.5214 10.4687L19.5155 25.4834L4.50074 6.71504ZM40.318 27.8419L20.9082 26.3489L26.8805 11.4182L40.318 27.8419ZM22.8857 36.2819L20.8053 27.9602L38.8356 29.3472L22.8857 36.2819ZM21.4781 37.3082L17.8871 44.4902L19.9391 31.152L21.4781 37.3082ZM15.369 22.8848L3.28967 14.0998H8.34106L15.369 22.8848ZM47.7602 13.6684L51.3781 15.9295H47.0462L47.7602 13.6684Z" fill="#909090" />
                                    </svg>
                                    <div class="title">Business Automation</div>
                                </div>
                            </a>
                            <a href="#" class="nav-link" id="nav-dashboards-tab" data-bs-toggle="tab" data-bs-target="#nav-dashboards" role="tab" aria-controls="nav-dashboards" aria-selected="false">
                                <div class="tab-heade">
                                    <svg width="55" height="55" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M35.5195 24.0625L28.6445 30.9375L24.0612 26.3542L17.1862 33.2292" stroke="#909090" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M33.2292 10.3125H13.5125C12.3924 10.3125 11.8323 10.3125 11.4045 10.5305C11.0282 10.7222 10.7222 11.0282 10.5305 11.4045C10.3125 11.8323 10.3125 12.3924 10.3125 13.5125V41.4875C10.3125 42.6076 10.3125 43.1677 10.5305 43.5955C10.7222 43.9718 11.0282 44.2778 11.4045 44.4695C11.8323 44.6875 12.3924 44.6875 13.5125 44.6875H41.4875C42.6076 44.6875 43.1677 44.6875 43.5955 44.4695C43.9718 44.2778 44.2778 43.9718 44.4695 43.5955C44.6875 43.1677 44.6875 42.6076 44.6875 41.4875V21.7708" stroke="#909090" stroke-width="2" stroke-linecap="round" />
                                        <circle cx="42.3971" cy="12.6042" r="4.72917" stroke="#909090" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    <div class="title">Custom Dashboards</div>
                                </div>
                            </a>
                            <a href="#" class="nav-link" id="nav-webapps-tab" data-bs-toggle="tab" data-bs-target="#nav-webapps" role="tab" aria-controls="nav-webapps" aria-selected="false">
                                <div class="tab-heade">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M30.5349 0.5022C30.5946 0.499409 30.6543 0.501369 30.7136 0.508062L38.5066 1.47193C39.1252 1.54381 39.5677 2.10453 39.4939 2.7229L38.5418 10.5188C38.4687 11.1414 37.9007 11.5842 37.2791 11.5032C36.66 11.4256 36.2223 10.8591 36.3035 10.2405L36.9304 5.13989L21.113 17.5061L21.1218 35.6702L24.7664 32.0344C25.3457 31.5094 25.9514 31.6486 26.3484 32.0344C26.7818 32.4727 26.7818 33.1782 26.3484 33.6165L20.7908 39.1741C20.3525 39.6074 19.6471 39.6074 19.2088 39.1741L13.6482 33.6165C13.207 33.1768 13.207 32.4624 13.6482 32.0227C14.0882 31.5796 14.8049 31.5796 15.2449 32.0227L18.8748 35.6526L18.8631 17.5383C13.6303 13.3746 8.34768 9.26394 3.06911 5.14282L3.69606 10.2405C3.77726 10.8591 3.33955 11.4256 2.72047 11.5032C2.1031 11.5771 1.5428 11.1363 1.4695 10.5188L0.50563 2.7229C0.431732 2.10555 0.872589 1.54529 1.49001 1.47193L9.2859 0.508059C9.90429 0.434164 10.4651 0.87673 10.5369 1.49536C10.6112 2.10869 10.1769 2.66716 9.56422 2.74634L4.45485 3.37036C9.63218 7.41155 14.8224 11.4479 19.9705 15.5403L35.5418 3.37036L30.4353 2.74634C29.8214 2.66862 29.3855 2.1097 29.4597 1.49536C29.5243 0.944542 29.9807 0.522977 30.5349 0.5022Z" fill="#3580C7" />
                                    </svg>
                                    <div class="title">Web Applications</div>
                                </div>
                            </a>
                            <a href="#" class="nav-link" id="nav-management-tab" data-bs-toggle="tab" data-bs-target="#nav-management" role="tab" aria-controls="nav-management" aria-selected="false">
                                <div class="tab-heade">
                                    <svg width="55" height="55" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M54.8716 17.1725C54.8733 17.1697 54.8755 17.1674 54.8772 17.1646C54.8807 17.1589 54.8834 17.153 54.8869 17.1472C54.8953 17.1331 54.9033 17.1189 54.9108 17.1042C54.9158 17.0944 54.9205 17.0845 54.925 17.0746C54.9314 17.0607 54.9375 17.0468 54.9432 17.0325C54.9477 17.0212 54.9518 17.0098 54.9557 16.9984C54.9601 16.9854 54.9644 16.9724 54.9681 16.959C54.9719 16.9459 54.9753 16.9328 54.9783 16.9195C54.9811 16.9076 54.9836 16.8955 54.9859 16.8834C54.9886 16.8685 54.9909 16.8538 54.9927 16.8389C54.9941 16.8278 54.9955 16.8166 54.9963 16.8053C54.9977 16.7893 54.9984 16.7733 54.9988 16.7572C54.999 16.7503 54.9999 16.7437 54.9999 16.7368C54.9999 16.7327 54.9994 16.7286 54.9993 16.7245C54.999 16.7093 54.9981 16.6941 54.997 16.679C54.9961 16.6667 54.9954 16.6544 54.9939 16.6423C54.9924 16.6298 54.9902 16.6174 54.9882 16.605C54.9858 16.5908 54.9835 16.5765 54.9805 16.5626C54.9783 16.5525 54.9754 16.5425 54.9728 16.5325C54.9687 16.517 54.9647 16.5015 54.9599 16.4864C54.9568 16.4772 54.9532 16.4681 54.9498 16.459C54.9443 16.4438 54.9389 16.4287 54.9324 16.414C54.928 16.4038 54.9228 16.394 54.9179 16.384C54.9115 16.371 54.9055 16.358 54.8985 16.3454C54.8918 16.3334 54.8844 16.3218 54.8771 16.3101C54.8708 16.3001 54.8649 16.29 54.8583 16.2804C54.8494 16.2676 54.8397 16.2552 54.8302 16.2428C54.8239 16.2348 54.818 16.2266 54.8114 16.2187C54.8014 16.2068 54.7907 16.1955 54.7799 16.1841C54.7726 16.1763 54.7655 16.1684 54.7578 16.1608C54.7478 16.151 54.7372 16.1418 54.7266 16.1324C54.7169 16.1238 54.7072 16.1152 54.6971 16.1071C54.6879 16.0997 54.6782 16.0928 54.6686 16.0858C54.656 16.0766 54.6434 16.0676 54.6303 16.0591C54.6269 16.057 54.6239 16.0544 54.6205 16.0523L47.732 11.7471C47.7273 11.7441 47.7225 11.7419 47.7177 11.7391C47.7081 11.7334 47.6988 11.7276 47.689 11.7223C47.683 11.7191 47.6769 11.7161 47.6709 11.713C47.6612 11.7081 47.6514 11.7036 47.6415 11.699C47.6337 11.6954 47.6259 11.6916 47.6178 11.6882C47.6122 11.6858 47.6066 11.6838 47.601 11.6816C47.5879 11.6764 47.5748 11.6717 47.5616 11.6673C47.5567 11.6657 47.5522 11.6635 47.5472 11.662C47.5457 11.6616 47.5442 11.6613 47.5428 11.6608C47.5381 11.6594 47.5333 11.6583 47.5286 11.6569C47.5132 11.6523 47.4978 11.6486 47.4823 11.645C47.4764 11.6437 47.4706 11.6419 47.4647 11.6407C47.4608 11.64 47.4569 11.6396 47.4531 11.6389C47.4373 11.636 47.4216 11.6336 47.4058 11.6316C47.3945 11.6302 47.3832 11.6288 47.3718 11.6278C47.3579 11.6266 47.3441 11.626 47.3302 11.6255C47.317 11.6251 47.3038 11.6248 47.2906 11.625C47.2786 11.6252 47.2666 11.6259 47.2546 11.6266C47.2498 11.6269 47.2451 11.6269 47.2404 11.6273C47.2373 11.6275 47.2341 11.6274 47.231 11.6277C47.2244 11.6283 47.218 11.6295 47.2115 11.6303C47.2004 11.6316 47.1894 11.6333 47.1783 11.635C47.1746 11.6355 47.171 11.636 47.1674 11.6366C47.1624 11.6375 47.1575 11.6378 47.1527 11.6388C47.1466 11.64 47.1408 11.6417 47.1349 11.643C47.1238 11.6453 47.1128 11.6482 47.1017 11.651C47.088 11.6546 47.0743 11.6583 47.0608 11.6626C47.049 11.6663 47.0374 11.6705 47.0258 11.6748C47.0171 11.678 47.0084 11.6806 47 11.6841C46.9965 11.6855 46.993 11.6874 46.9895 11.6889C46.9769 11.6942 46.9646 11.7001 46.9524 11.706C46.944 11.7101 46.9353 11.7139 46.9271 11.7182C46.9262 11.7186 46.9252 11.719 46.9244 11.7195L34.5934 18.296L27.2636 9.33739C27.2633 9.33695 27.2629 9.33663 27.2626 9.3362C27.2603 9.3334 27.2579 9.33071 27.2556 9.32791C27.2499 9.32113 27.2436 9.315 27.2377 9.30843C27.2263 9.29573 27.2149 9.28292 27.2026 9.27098C27.1955 9.26398 27.1877 9.25763 27.1802 9.25096C27.1685 9.2403 27.157 9.22954 27.1446 9.21953C27.1329 9.21016 27.1204 9.20166 27.1082 9.19284C27.1073 9.19219 27.1064 9.19144 27.1054 9.19079C27.0974 9.18509 27.0896 9.17884 27.0813 9.17335C27.0689 9.16517 27.0557 9.15807 27.0428 9.15054C27.033 9.14483 27.0234 9.1387 27.0134 9.13342C27.0013 9.12707 26.9886 9.1218 26.9762 9.11609C26.9646 9.11082 26.9533 9.10501 26.9416 9.10027C26.9304 9.09575 26.9188 9.0922 26.9073 9.08822C26.8936 9.08337 26.88 9.07831 26.8662 9.07422C26.8644 9.07369 26.8627 9.07293 26.861 9.0725C26.8487 9.06895 26.8364 9.0668 26.8242 9.06389C26.8131 9.06131 26.8021 9.0583 26.7908 9.05614C26.7861 9.05528 26.7815 9.05421 26.7767 9.05334L2.67121 4.74838C2.66325 4.74698 2.65539 4.74655 2.64743 4.74537C2.6329 4.74322 2.61847 4.74117 2.60394 4.73977C2.5906 4.73848 2.57747 4.73784 2.56423 4.7373C2.55163 4.73676 2.53904 4.73633 2.52645 4.73633C2.51203 4.73633 2.49771 4.73687 2.4834 4.73773C2.47177 4.73837 2.46004 4.73923 2.44842 4.74031C2.43399 4.74171 2.41968 4.74365 2.40547 4.74591C2.39363 4.74774 2.3819 4.74978 2.37017 4.75204C2.3566 4.75473 2.34326 4.75785 2.32991 4.7613C2.31753 4.76442 2.30516 4.76786 2.29289 4.77163C2.28051 4.7754 2.26845 4.77949 2.25629 4.7839C2.24348 4.78853 2.23089 4.79337 2.2183 4.79865C2.20667 4.80349 2.19537 4.80876 2.18396 4.81415C2.17169 4.81996 2.15953 4.82599 2.14748 4.83244C2.13574 4.83879 2.12433 4.84547 2.11303 4.85236C2.10216 4.85892 2.09129 4.86559 2.08064 4.8727C2.06815 4.88109 2.0561 4.88992 2.04415 4.89896C2.03791 4.9037 2.03123 4.90779 2.0251 4.91274C2.02219 4.915 2.01982 4.91758 2.01692 4.91995C2.00486 4.92985 1.99335 4.9404 1.98183 4.95105C1.97354 4.9587 1.96504 4.96623 1.95707 4.9742C1.94674 4.98453 1.93716 4.99551 1.92737 5.00638C1.9193 5.01542 1.91101 5.02424 1.90347 5.0335C1.89486 5.04405 1.8869 5.05524 1.87883 5.06633C1.87129 5.07655 1.86354 5.08667 1.85655 5.09711C1.84923 5.1082 1.84266 5.11971 1.83588 5.13123C1.82921 5.14242 1.82232 5.1534 1.81629 5.16481C1.81026 5.17622 1.80499 5.18817 1.7995 5.1999C1.7938 5.21206 1.78788 5.22412 1.78282 5.23649C1.77808 5.2479 1.77421 5.25974 1.77001 5.27147C1.76527 5.28482 1.76032 5.29817 1.75634 5.31173C1.753 5.32292 1.75031 5.33455 1.74741 5.34606C1.74375 5.3607 1.74009 5.37523 1.73729 5.38998C1.73654 5.39375 1.73535 5.3974 1.73471 5.40117C1.7332 5.40935 1.73277 5.41742 1.73159 5.4256C1.72954 5.43981 1.7275 5.45402 1.7262 5.46833C1.72491 5.48168 1.72427 5.49492 1.72373 5.50816C1.72319 5.52086 1.72276 5.53356 1.72276 5.54626C1.72276 5.56047 1.72341 5.57457 1.72416 5.58867C1.7248 5.60061 1.72567 5.61245 1.72685 5.6244C1.72825 5.63861 1.73019 5.6526 1.73234 5.66659C1.73417 5.67865 1.73632 5.6907 1.73869 5.70265C1.74138 5.716 1.74439 5.72913 1.74784 5.74226C1.75107 5.75485 1.75451 5.76734 1.75828 5.77982C1.76205 5.79198 1.76614 5.80404 1.77044 5.81599C1.77507 5.82879 1.77991 5.8416 1.78519 5.8542C1.79003 5.86571 1.7952 5.87712 1.80058 5.88842C1.80639 5.90069 1.81242 5.91285 1.81887 5.92491C1.82512 5.93664 1.8319 5.94794 1.83868 5.95935C1.84524 5.97033 1.85192 5.9812 1.85913 5.99186C1.86742 6.00423 1.87624 6.01618 1.88518 6.02802C1.88991 6.03437 1.894 6.04104 1.89906 6.04729L7.04947 12.4853H0.807241C0.799922 12.4853 0.792926 12.4862 0.785714 12.4864C0.770861 12.4868 0.756008 12.4875 0.741155 12.4886C0.728131 12.4897 0.715215 12.4912 0.702407 12.4928C0.689814 12.4945 0.677221 12.4964 0.664736 12.4985C0.650528 12.501 0.636536 12.504 0.622652 12.5073C0.611458 12.5098 0.600372 12.5127 0.589286 12.5159C0.574971 12.5199 0.560978 12.5242 0.546986 12.529C0.536115 12.5327 0.525352 12.5366 0.514589 12.5408C0.50135 12.546 0.488327 12.5514 0.475519 12.5572C0.46411 12.5624 0.452808 12.5679 0.441615 12.5736C0.430098 12.5795 0.418689 12.5855 0.407495 12.592C0.395548 12.5987 0.383816 12.606 0.372192 12.6134C0.362182 12.6198 0.352387 12.6264 0.342701 12.6332C0.330861 12.6415 0.319344 12.6502 0.307935 12.6592C0.298679 12.6666 0.289746 12.674 0.28092 12.6816C0.270264 12.6909 0.259716 12.7003 0.249491 12.7101C0.240127 12.7191 0.231194 12.7282 0.22226 12.7376C0.213434 12.7468 0.204824 12.7563 0.196429 12.7661C0.186634 12.7775 0.17727 12.7893 0.168121 12.8012C0.163708 12.8069 0.158973 12.812 0.154667 12.8178C0.152192 12.8212 0.150254 12.8248 0.147886 12.8282C0.13863 12.8413 0.130127 12.8548 0.121624 12.8684C0.11592 12.8776 0.11 12.8869 0.104726 12.8962C0.0972994 12.9095 0.0905186 12.923 0.0837378 12.9367C0.0785714 12.9472 0.0732975 12.9576 0.0685617 12.9681C0.0629648 12.9808 0.0581213 12.9939 0.0531703 13.0069C0.0486497 13.0188 0.0439139 13.0308 0.0399315 13.0429C0.0360568 13.0549 0.0328278 13.0672 0.0294912 13.0794C0.0257241 13.093 0.0219569 13.1066 0.0190509 13.1202C0.0165753 13.1315 0.0148532 13.143 0.0128082 13.1544C0.0102251 13.1694 0.00764188 13.1844 0.00591977 13.1994C0.00462818 13.2103 0.00398239 13.2213 0.00322896 13.2324C0.00204501 13.2482 0.00107632 13.2641 0.000861057 13.2799C0.000538161 13.2841 0 13.2882 0 13.2925C0 13.2999 0.000861057 13.3069 0.00107632 13.3141C0.00150685 13.3289 0.00204501 13.3438 0.0033366 13.3586C0.00441292 13.3717 0.00591977 13.3845 0.00753425 13.3974C0.00914873 13.4101 0.0110861 13.4227 0.0133464 13.4352C0.0158219 13.4493 0.0188356 13.4632 0.0220646 13.4771C0.0247554 13.4884 0.0275538 13.4996 0.0306751 13.5107C0.0346575 13.5249 0.0389628 13.5388 0.0436986 13.5527C0.0474658 13.5638 0.0514481 13.5746 0.0557534 13.5855C0.0608121 13.5985 0.0661937 13.6115 0.0718982 13.6242C0.0771722 13.6358 0.0827691 13.6473 0.0884736 13.6587C0.0942857 13.67 0.100205 13.6812 0.106448 13.6922C0.113337 13.7043 0.120763 13.7163 0.128297 13.7281C0.13454 13.7379 0.140998 13.7476 0.147671 13.7571C0.156067 13.769 0.164892 13.7808 0.174041 13.7923C0.181252 13.8013 0.188571 13.8103 0.196106 13.819C0.205362 13.8297 0.214941 13.8403 0.224951 13.8506C0.233777 13.8599 0.242926 13.8688 0.25229 13.8776C0.261654 13.8865 0.271018 13.8952 0.28092 13.9037C0.292329 13.9135 0.304061 13.9227 0.3159 13.9319C0.321605 13.9363 0.326663 13.941 0.332583 13.9453L18.878 27.4329L15.5102 49.3238C15.5098 49.3264 15.5095 49.329 15.509 49.3316L15.5086 49.3342C15.5081 49.3376 15.5081 49.3408 15.5076 49.3441C15.5044 49.3671 15.5018 49.39 15.5005 49.4128C15.5 49.4218 15.5003 49.4307 15.5001 49.4396C15.4998 49.4567 15.4993 49.4738 15.5 49.4908C15.5005 49.5042 15.502 49.5172 15.5032 49.5303C15.5044 49.5428 15.5052 49.5553 15.5069 49.5677C15.509 49.5831 15.5122 49.5982 15.5152 49.6134C15.5172 49.6235 15.5188 49.6338 15.5213 49.6438C15.525 49.6593 15.5296 49.6743 15.5341 49.6895C15.537 49.6993 15.5397 49.7091 15.543 49.7188C15.5479 49.7328 15.5535 49.7465 15.5591 49.7602C15.5634 49.7709 15.5675 49.7817 15.5723 49.7921C15.5777 49.8038 15.5837 49.8152 15.5896 49.8266C15.5959 49.8387 15.6019 49.8508 15.6087 49.8625C15.6142 49.872 15.6203 49.881 15.6261 49.8903C15.6343 49.9032 15.6425 49.9161 15.6515 49.9286C15.6572 49.9364 15.6634 49.944 15.6693 49.9516C15.6793 49.9645 15.6893 49.9773 15.7002 49.9897C15.7066 49.997 15.7136 50.0039 15.7203 50.0111C15.7313 50.0227 15.7422 50.0344 15.7539 50.0453C15.7626 50.0535 15.772 50.0612 15.7811 50.069C15.7915 50.078 15.8017 50.087 15.8126 50.0954C15.8258 50.1057 15.8398 50.1151 15.8538 50.1246C15.8614 50.1297 15.8686 50.1352 15.8764 50.1401C15.8959 50.1523 15.9161 50.1635 15.9368 50.1742C15.9397 50.1757 15.9423 50.1774 15.9452 50.1789C15.9455 50.179 15.9458 50.1791 15.9461 50.1794C15.9734 50.1929 16.0014 50.205 16.0304 50.2155C16.0376 50.2181 16.0449 50.2199 16.0521 50.2223C16.0719 50.2289 16.092 50.2351 16.1125 50.2402C16.1261 50.2435 16.1397 50.2459 16.1532 50.2486C16.1633 50.2505 16.1731 50.2532 16.1835 50.2548C16.1869 50.2553 16.1902 50.2551 16.1937 50.2556C16.231 50.2608 16.2684 50.2644 16.3056 50.2644C16.306 50.2644 16.3065 50.2643 16.3068 50.2643H16.3072C16.3406 50.2643 16.3734 50.2615 16.406 50.2574C16.4125 50.2565 16.4188 50.2558 16.4253 50.2548C16.4919 50.2449 16.5563 50.2267 16.6172 50.2012C16.6231 50.1987 16.6289 50.1964 16.6348 50.1938C16.6642 50.1806 16.693 50.166 16.7206 50.1494C16.7257 50.1464 16.7304 50.143 16.7354 50.1399C16.7586 50.1252 16.781 50.1094 16.8027 50.0926C16.8091 50.0877 16.8156 50.0828 16.8218 50.0776C16.8458 50.0577 16.8686 50.0363 16.8903 50.0136C16.8957 50.0079 16.9008 50.002 16.9061 49.9962C16.9278 49.9721 16.9485 49.9469 16.9673 49.9202C16.9679 49.9193 16.9686 49.9186 16.9692 49.9178C16.9895 49.8885 17.0075 49.8575 17.024 49.8255C17.0252 49.8229 17.0271 49.8206 17.0284 49.818L22.9246 38.0255L42.4599 29.532C42.4652 29.5297 42.4699 29.5268 42.4751 29.5244C42.4907 29.5172 42.5061 29.5097 42.5212 29.5015C42.5226 29.5008 42.5242 29.5001 42.5257 29.4994C42.5281 29.4981 42.5306 29.4971 42.5331 29.4957C42.5387 29.4926 42.5438 29.4888 42.5494 29.4856C42.5616 29.4784 42.5737 29.4708 42.5854 29.463C42.5931 29.4578 42.601 29.453 42.6085 29.4476C42.6114 29.4455 42.6141 29.4432 42.617 29.441C42.6259 29.4346 42.6345 29.4278 42.643 29.4209C42.645 29.4193 42.6474 29.4182 42.6494 29.4165C42.6515 29.4148 42.6533 29.4128 42.6554 29.4111C42.6629 29.4049 42.6701 29.3985 42.6773 29.3919C42.6844 29.3855 42.6913 29.3788 42.6982 29.3722C42.6986 29.3718 42.6991 29.3715 42.6995 29.3711C42.7025 29.3682 42.7057 29.3657 42.7087 29.3627C42.711 29.3604 42.713 29.358 42.7153 29.3558C42.7207 29.3502 42.726 29.3446 42.7312 29.3389C42.7379 29.3316 42.7443 29.324 42.7507 29.3165C42.757 29.3093 42.7634 29.3022 42.7693 29.2947C42.7728 29.2904 42.776 29.2861 42.7794 29.2818C42.782 29.2784 42.7847 29.2749 42.7873 29.2715C42.7901 29.2676 42.7926 29.2635 42.7954 29.2597C42.7962 29.2585 42.797 29.2572 42.7979 29.256C42.8041 29.2472 42.8106 29.2385 42.8164 29.2294C42.8182 29.2265 42.82 29.2237 42.8219 29.2208C42.8281 29.2108 42.8338 29.2005 42.8396 29.1902C42.8451 29.1805 42.8508 29.1711 42.8559 29.1613C42.8561 29.1609 42.8564 29.1604 42.8566 29.1599C42.8574 29.1584 42.8581 29.1569 42.8589 29.1554C42.8647 29.1438 42.8699 29.1318 42.8751 29.12C42.8794 29.1103 42.8841 29.1007 42.8879 29.0908C42.8886 29.0892 42.8893 29.0876 42.89 29.0859C42.8949 29.0732 42.899 29.0602 42.9033 29.0472C42.904 29.0454 42.9046 29.0435 42.9053 29.0417C42.906 29.0393 42.9073 29.0372 42.9081 29.0348L42.9113 29.0245C42.9114 29.0243 42.9114 29.024 42.9115 29.0238L46.5367 17.5442H54.1907C54.1913 17.5442 54.1918 17.5443 54.1922 17.5443C54.1941 17.5443 54.1959 17.544 54.1977 17.544C54.2275 17.5438 54.2568 17.5419 54.2858 17.5385C54.2939 17.5376 54.302 17.536 54.3101 17.5349C54.3335 17.5314 54.3566 17.5272 54.3793 17.5218C54.3877 17.5199 54.396 17.5176 54.4043 17.5154C54.4275 17.5091 54.4502 17.5018 54.4725 17.4935C54.4795 17.4909 54.4866 17.4886 54.4936 17.4858C54.5225 17.4742 54.5509 17.4613 54.5781 17.4466C54.5787 17.4463 54.5794 17.4457 54.58 17.4454C54.6057 17.4313 54.6304 17.4156 54.6544 17.3988C54.6634 17.3925 54.6722 17.3857 54.6809 17.379C54.6969 17.3668 54.7124 17.3541 54.7274 17.3409C54.736 17.3333 54.7446 17.3257 54.7529 17.3177C54.7728 17.2985 54.7917 17.2785 54.8095 17.2574C54.8115 17.255 54.8137 17.253 54.8157 17.2506C54.836 17.2256 54.8543 17.1994 54.8716 17.1725ZM45.9389 14.0746L41.8177 27.1253L35.6358 19.5696L45.9389 14.0746ZM4.50074 6.71504L25.5214 10.4687L19.5155 25.4834L4.50074 6.71504ZM40.318 27.8419L20.9082 26.3489L26.8805 11.4182L40.318 27.8419ZM22.8857 36.2819L20.8053 27.9602L38.8356 29.3472L22.8857 36.2819ZM21.4781 37.3082L17.8871 44.4902L19.9391 31.152L21.4781 37.3082ZM15.369 22.8848L3.28967 14.0998H8.34106L15.369 22.8848ZM47.7602 13.6684L51.3781 15.9295H47.0462L47.7602 13.6684Z" fill="#909090" />
                                    </svg>
                                    <div class="title">Management Systems</div>
                                </div>
                            </a>
                            <a href="#" class="nav-link m-0" id="nav-api-tab" data-bs-toggle="tab" data-bs-target="#nav-api" role="tab" aria-controls="nav-api" aria-selected="false">
                                <div class="tab-heade">
                                    <svg width="55" height="55" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M35.5195 24.0625L28.6445 30.9375L24.0612 26.3542L17.1862 33.2292" stroke="#909090" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M33.2292 10.3125H13.5125C12.3924 10.3125 11.8323 10.3125 11.4045 10.5305C11.0282 10.7222 10.7222 11.0282 10.5305 11.4045C10.3125 11.8323 10.3125 12.3924 10.3125 13.5125V41.4875C10.3125 42.6076 10.3125 43.1677 10.5305 43.5955C10.7222 43.9718 11.0282 44.2778 11.4045 44.4695C11.8323 44.6875 12.3924 44.6875 13.5125 44.6875H41.4875C42.6076 44.6875 43.1677 44.6875 43.5955 44.4695C43.9718 44.2778 44.2778 43.9718 44.4695 43.5955C44.6875 43.1677 44.6875 42.6076 44.6875 41.4875V21.7708" stroke="#909090" stroke-width="2" stroke-linecap="round" />
                                        <circle cx="42.3971" cy="12.6042" r="4.72917" stroke="#909090" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    <div class="title">API Integrations</div>
                                </div>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-automation" role="tabpanel" aria-labelledby="nav-automation-tab">
                        <div class="feature-tab-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="feature-tab-img">
                                        <img src="<?= asset('assets/images/generated/pro/home/business-automation.webp') ?>"<?= media_srcset('assets/images/generated/pro/home/business-automation.webp', '(max-width: 767px) 92vw, 46vw') ?> width="526" height="629" loading="lazy" decoding="async" alt="Two developers reviewing an automated business workflow on a large monitor">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-tab-content">
                                        <h3 class="title h4">Business Automation</h3>
                                        <p>Replace repetitive manual steps with reliable workflows.</p>
                                        <p>Approvals, notifications and record updates can run automatically, so that your team spends less time on routine work and fewer steps get missed.</p>
                                        <a class='ibt-btn ibt-btn-outline' href="<?= service_link('custom-software') ?>">
                                            <span>Explore More</span>
                                            <i class="icon-arrow-top"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-dashboards" role="tabpanel" aria-labelledby="nav-dashboards-tab">
                        <div class="feature-tab-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="feature-tab-img">
                                        <img src="<?= asset('assets/images/generated/pro/home/custom-dashboards.webp') ?>"<?= media_srcset('assets/images/generated/pro/home/custom-dashboards.webp', '(max-width: 767px) 92vw, 46vw') ?> width="526" height="629" loading="lazy" decoding="async" alt="Business analyst presenting a custom dashboard on a wall display to a colleague">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-tab-content">
                                        <h3 class="title h4">Custom Dashboards</h3>
                                        <p>See the information your team needs in one place.</p>
                                        <p>We bring data from your business systems together into clear views, so that decisions do not depend on collecting reports by hand.</p>
                                        <a class='ibt-btn ibt-btn-outline' href="<?= service_link('custom-software') ?>">
                                            <span>Explore More</span>
                                            <i class="icon-arrow-top"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-webapps" role="tabpanel" aria-labelledby="nav-webapps-tab">
                        <div class="feature-tab-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="feature-tab-img">
                                        <img src="<?= asset('assets/images/generated/pro/home/web-applications.webp') ?>"<?= media_srcset('assets/images/generated/pro/home/web-applications.webp', '(max-width: 767px) 92vw, 46vw') ?> width="526" height="629" loading="lazy" decoding="async" alt="Software engineer working on a browser-based application on a laptop and monitor">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-tab-content">
                                        <h3 class="title h4">Web Applications</h3>
                                        <p>Secure tools that work in any modern browser.</p>
                                        <p>Customer portals, booking tools and internal applications that your team can use from any device, with no software to install.</p>
                                        <a class='ibt-btn ibt-btn-outline' href="<?= service_link('custom-software') ?>">
                                            <span>Explore More</span>
                                            <i class="icon-arrow-top"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-management" role="tabpanel" aria-labelledby="nav-management-tab">
                        <div class="feature-tab-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="feature-tab-img">
                                        <img src="<?= asset('assets/images/generated/pro/home/management-systems.webp') ?>"<?= media_srcset('assets/images/generated/pro/home/management-systems.webp', '(max-width: 767px) 92vw, 46vw') ?> width="526" height="629" loading="lazy" decoding="async" alt="Operations manager with a tablet beside a business management system on a display">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-tab-content">
                                        <h3 class="title h4">Management Systems</h3>
                                        <p>Organise customers, orders, staff and records.</p>
                                        <p>A central system shaped around how your business runs, in place of separate spreadsheets and disconnected tools.</p>
                                        <a class='ibt-btn ibt-btn-outline' href="<?= service_link('custom-software') ?>">
                                            <span>Explore More</span>
                                            <i class="icon-arrow-top"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-api" role="tabpanel" aria-labelledby="nav-api-tab">
                        <div class="feature-tab-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="feature-tab-img">
                                        <img src="<?= asset('assets/images/generated/pro/home/api-integrations.webp') ?>"<?= media_srcset('assets/images/generated/pro/home/api-integrations.webp', '(max-width: 767px) 92vw, 46vw') ?> width="526" height="629" loading="lazy" decoding="async" alt="Developer at a curved monitor showing software systems connected through a central hub">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-tab-content">
                                        <h3 class="title h4">API Integrations</h3>
                                        <p>Connect your software with the services you already use.</p>
                                        <p>We connect payment, email and other third-party services to your platform, so that information moves between systems without manual copying.</p>
                                        <a class='ibt-btn ibt-btn-outline' href="<?= service_link('custom-software') ?>">
                                            <span>Explore More</span>
                                            <i class="icon-arrow-top"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Feature-sec6 -->

        <!-- Development process: cards stack on small screens; assets/js/girzock.js adds the sticky scroll stages on desktop -->
        <section class="girzock-process ibt-section-gap" id="process">
            <div class="container">
                <div class="row girzock-process-row">
                    <div class="col-lg-6">
                        <div class="girzock-process-intro">
                            <div class="sec-title">
                                <span class="sub-title">our development process</span>
                                <h2 class="title">From Concept <span class="girzock-gradient-text">to Completion</span></h2>
                                <p>We follow a structured development process to transform your ideas into reliable digital solutions, with clear communication and agreed goals at each stage.</p>
                            </div>
                            <a class='ibt-btn ibt-btn-secondary' href="<?= site_url('services') ?>">
                                <span>Explore Our Services</span>
                                <i class="icon-arrow-top"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="girzock-process-track">
                            <ol class="girzock-process-stage">
                                <li class="girzock-step">
                                    <span class="girzock-step-num" aria-hidden="true">01</span>
                                    <span class="girzock-step-label">Step 1</span>
                                    <h3 class="title">Discover</h3>
                                    <p>Understand business goals, requirements and challenges.</p>
                                </li>
                                <li class="girzock-step">
                                    <span class="girzock-step-num" aria-hidden="true">02</span>
                                    <span class="girzock-step-label">Step 2</span>
                                    <h3 class="title">Strategize</h3>
                                    <p>Define the right technology, architecture and development approach.</p>
                                </li>
                                <li class="girzock-step">
                                    <span class="girzock-step-num" aria-hidden="true">03</span>
                                    <span class="girzock-step-label">Step 3</span>
                                    <h3 class="title">Design &amp; Develop</h3>
                                    <p>Create and develop user-focused digital solutions.</p>
                                </li>
                                <li class="girzock-step">
                                    <span class="girzock-step-num" aria-hidden="true">04</span>
                                    <span class="girzock-step-label">Step 4</span>
                                    <h3 class="title">Launch &amp; Support</h3>
                                    <p>Deploy, monitor and continuously improve the solution.</p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End development process -->

        

        <!-- project-sec (index10) -->
        <section class="project-sec ibt-section-gap" id="featured-projects">
            <div class="title-area">
                <div class="container">
                    <div class="row align-items-end">
                        <div class="col-xl-8 col-lg-12">
                            <div class="sec-title mb-0 white">
                                <span class="sub-title">featured projects</span>
                                <h2 class="title animated-heading">Turning Ideas Into Digital Experiences</h2>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="swiper project-slider">
                    <div class="swiper-wrapper">
<?php $this->load->view('frontend/home/_featured_projects'); ?>
</div>
                </div>
            </div>
            <div class="title-area gz-project-actions">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="project-btn">
                            <a class='ibt-btn ibt-btn-outline' href="<?= site_url('portfolio') ?>">
                                <span>View Portfolio</span>
                                <i class="icon-arrow-top"></i>
                            </a>
                            <div class="custom-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <!-- End project-sec -->

        <!-- faq-sec (index5) -->
        <section class="faq-sec ibt-section-gap" id="faq">
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
                                <h2 class="title animated-heading">Frequently Asked Questions</h2>
                            </div>
                            <div class="accordion" id="accordionFaq">
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="faqHeading0">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody0" aria-expanded="true" aria-controls="faqBody0">
                                            What services does GIRZOCK Technologies provide?
                                        </button>
                                    </h3>
                                    <div id="faqBody0" class="accordion-collapse collapse show" aria-labelledby="faqHeading0" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">We provide website design and development, custom software, web applications, e-commerce, WordPress, UI/UX design, CRM and business software, mobile apps, cloud and AWS solutions, API integration, website maintenance, SEO, digital marketing, business automation and IT consulting.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="faqHeading1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody1" aria-expanded="false" aria-controls="faqBody1">
                                            How much does website development cost?
                                        </button>
                                    </h3>
                                    <div id="faqBody1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">The cost depends on the size, features and complexity of your website. <a href="<?= site_url('contact') ?>">Share your requirements</a> and we will send you a clear quote.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="faqHeading2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody2" aria-expanded="false" aria-controls="faqBody2">
                                            How long does a website take to develop?
                                        </button>
                                    </h3>
                                    <div id="faqBody2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">It depends on the scope of the project and how quickly content and feedback are available. We agree a clear timeline with you before work begins.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="faqHeading3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody3" aria-expanded="false" aria-controls="faqBody3">
                                            Can you build custom business software?
                                        </button>
                                    </h3>
                                    <div id="faqBody3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">Yes. We design and build software around your processes, including internal tools, management systems, dashboards and API integrations.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="faqHeading4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody4" aria-expanded="false" aria-controls="faqBody4">
                                            Do you provide WordPress development?
                                        </button>
                                    </h3>
                                    <div id="faqBody4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">Yes. We build and customise WordPress websites, including themes and plugins, so that your team can manage content easily.</div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-0">
                                    <h3 class="accordion-header" id="faqHeading5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody5" aria-expanded="false" aria-controls="faqBody5">
                                            Do you offer website maintenance and support?
                                        </button>
                                    </h3>
                                    <div id="faqBody5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">Yes. We can keep your website secure and up to date after launch, with updates, fixes and improvements. Email <a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a> to discuss what you need.</div>
                                    </div>
                                </div>
                            </div>
                            <a class='ibt-btn ibt-btn-outline' href="<?= site_url('contact') ?>">
                                <span>Contact Us</span>
                                <i class="icon-arrow-top"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End faq-sec -->

        <!-- choose-us-sec5 (index6) -->
        <section class="choose-us-sec5" id="commitment">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="choose-img5">
                        <img src="<?= asset('assets/images/event/choose2.png') ?>" width="721" height="1124" loading="lazy" decoding="async" alt="">
                        <div class="video-box5">
                            <a href="<?= site_url('about') ?>" class="video-popup">
                                <i class="fa fa-arrow-right"></i> About Us
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="choose-content5">
                        <div class="style-text gz-flow-text"><?php $this->load->view('frontend/partials/flow_text', array('flow_id' => 'commitment', 'lines' => array('GIRZOCK'))); ?></div>
                        <div class="sec-title white">
                            <span class="sub-title">our commitment</span>
                            <h2 class="title animated-heading">Your Technology Partner for Long-Term Growth</h2>
                            <p>We believe great technology starts with understanding your business. Our commitment is to deliver reliable, scalable and thoughtfully developed digital solutions while building lasting relationships with our clients.</p>
                        </div>
                        <a class='ibt-btn ibt-btn-outline' href="<?= site_url('contact') ?>">
                            <span>Start a Project</span>
                            <i class="icon-arrow-top"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End choose-us-sec5 -->

        <!-- service-sec18 (index12): left card and right video -->
        <section class="service-sec18 girzock-video-cta" id="start-a-project">
            <div class="container2">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="service-block18">
                            <img src="<?= asset('assets/images/icon/phone.svg') ?>" width="57" height="57" loading="lazy" decoding="async" alt="" class="girzock-cta-icon">
                            <h2 class="title">Let's Start Your Project</h2>
                            <a href="tel:+916379362330" class="girzock-cta-phone" aria-label="Call GIRZOCK Technologies on +91 6379362330">+91 6379362330</a>
                            <div>
                                <a class='ibt-btn ibt-btn-secondary' href="https://wa.me/916379362330" target="_blank" rel="noopener" aria-label="Chat with GIRZOCK Technologies on WhatsApp">
                                    <span><i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp Us</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="ser-img18">
                            <video autoplay muted loop playsinline preload="metadata" class="video-bg" aria-hidden="true">
                                <source src="<?= asset('assets/videos/abstract-render.mp4') ?>" type="video/mp4">
                            </video>
                            <div class="ser-text18">
                                <h2 class="girzock-cta-heading"><span>Bring Your Ideas to Life</span></h2>
                                <p>Have a business idea or a digital project in mind? Let's create something meaningful with modern technology.</p>
                                <a class='ibt-btn ibt-btn-secondary' href="<?= site_url('contact') ?>">
                                    <span>Start a Project</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End service-sec18 -->

        <!-- partners-sec -->
        <section class="partners-sec ibt-section-gap" id="partners">
            <div class="container">
                <div class="sec-title">
                    <span class="sub-title">work with us</span>
                    <h2 class="title animated-heading">Work With GIRZOCK to Build Stronger Digital Experiences</h2>
                </div>
                <div class="brand-sec2 ">
                    <div class="swiper brand2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand1.png') ?>" width="170" height="53" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand2.png') ?>" width="162" height="60" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand3.png') ?>" width="131" height="72" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand4.png') ?>" width="183" height="44" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand6.png') ?>" width="180" height="53" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand5.png') ?>" width="104" height="92" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand1.png') ?>" width="170" height="53" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand2.png') ?>" width="162" height="60" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand3.png') ?>" width="131" height="72" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand4.png') ?>" width="183" height="44" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand6.png') ?>" width="180" height="53" loading="lazy" decoding="async" alt=""></a>
                            </div>
                            <div class="swiper-slide">
                                <a href="<?= site_url('contact') ?>" aria-label="Contact GIRZOCK Technologies"><img src="<?= asset('assets/images/brand/brand5.png') ?>" width="104" height="92" loading="lazy" decoding="async" alt=""></a>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End partners-sec -->

        <!-- blog-sec (index1) -->
        <section class="blog-sec ibt-section-gapBottom girzock-insights" id="insights">
            <div class="container">
                <div class="title-area">
                    <div class="row end">
                        <div class="col-lg-7">
                            <div class="sec-title mb-0">
                                <span class="sub-title">insights</span>
                                <h2 class="title animated-heading">Insights, Ideas &amp; Technology</h2>
                                <p>Explore the latest technology trends, development insights and digital innovations shaping modern businesses.</p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="sec-btn-box">
                                <a class='ibt-btn ibt-btn-outline' href="<?= site_url('blog') ?>">
                                    <span>More Articles</span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
<?php $this->load->view('frontend/home/_latest_posts'); ?>
</div>
            </div>
        </section>
        <!-- End blog-sec -->

        <!-- local-sec -->
        <section class="gz-region" id="where-we-work">
            <div class="container">
                <div class="row align-items-center gz-region-top">
                    <div class="col-lg-6">
                        <div class="sec-title mb-0">
                            <span class="sub-title">where we work</span>
                            <h2 class="title animated-heading">A Software Company in <span class="gz-accent">Thisaiyanvilai,</span> Serving Tirunelveli and Beyond</h2>
                            <p>We are based in Thisaiyanvilai and work with startups, small businesses and growing companies across Tamil Nadu and nearby Kerala. Here is how that works in practice.</p>
                        </div>
                        <div class="gz-region-links">
                            <a href="<?= site_url('services') ?>" class="gz-region-btn gz-region-btn-main">Explore Our Services<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
                            <a href="<?= site_url('areas-we-serve') ?>" class="gz-region-btn"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s7-6.2 7-12a7 7 0 0 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>View Areas We Serve</a>
                            <a href="<?= site_url('contact') ?>" class="gz-region-btn"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.800a3.5 3.5 0 0 1 0 6.400M18 14.500a6.5 6.5 0 0 1 3.5 5.5"/></svg>Contact Our Team</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="gz-orbit">
                            <svg class="gz-orbit-svg" viewBox="0 0 520 520" role="img" aria-label="Rotating rings around a location pin marking our base in Thisaiyanvilai. This diagram is not a map.">
                                <defs>
                                    <linearGradient id="gzoRing" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#1769ff"/><stop offset=".6" stop-color="#19d5e5"/><stop offset="1" stop-color="#7a5cff"/></linearGradient>
                                    <linearGradient id="gzoArc" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#12308f"/><stop offset="1" stop-color="#1769ff"/></linearGradient>
                                    <linearGradient id="gzoPin" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#2f8bff"/><stop offset="1" stop-color="#0b3fd1"/></linearGradient>
                                    <linearGradient id="gzoSide" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#a9dcff"/><stop offset="1" stop-color="#3f97ff"/></linearGradient>
                                    <linearGradient id="gzoTop" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#fff"/><stop offset="1" stop-color="#e3f3ff"/></linearGradient>
                                    <radialGradient id="gzoGlow"><stop offset="0" stop-color="#19d5e5" stop-opacity=".42"/><stop offset=".55" stop-color="#1769ff" stop-opacity=".12"/><stop offset="1" stop-color="#1769ff" stop-opacity="0"/></radialGradient>
                                </defs>
                                <circle cx="260" cy="260" r="258" fill="url(#gzoGlow)"/>
                                <g class="gz-ring gz-ring-outer"><circle cx="260" cy="260" r="235" fill="none" stroke="url(#gzoRing)" stroke-width="1.8" stroke-dasharray="7 9"/><circle cx="160.7" cy="47" r="12" fill="#19d5e5" opacity=".18"/><circle cx="160.7" cy="47" r="6" fill="#19d5e5"/><circle cx="417.2" cy="85.4" r="13" fill="#1769ff" opacity=".18"/><circle cx="417.2" cy="85.4" r="7" fill="#1769ff"/><circle cx="417.2" cy="434.6" r="12" fill="#19d5e5" opacity=".18"/><circle cx="417.2" cy="434.6" r="6" fill="#19d5e5"/><circle cx="56.5" cy="377.5" r="11" fill="#7a5cff" opacity=".18"/><circle cx="56.5" cy="377.5" r="5" fill="#7a5cff"/></g>
                                <g class="gz-ring gz-ring-middle"><circle cx="260" cy="260" r="172" fill="none" stroke="url(#gzoRing)" stroke-width="1.8" stroke-dasharray="5 7"/><circle cx="260" cy="260" r="172" fill="none" stroke="url(#gzoArc)" stroke-width="2.6" stroke-linecap="round" stroke-dasharray="270 811" transform="rotate(95 260 260)"/><circle cx="149.4" cy="128.2" r="11" fill="#19d5e5" opacity=".18"/><circle cx="149.4" cy="128.2" r="5" fill="#19d5e5"/><circle cx="391.8" cy="149.4" r="11" fill="#19d5e5" opacity=".18"/><circle cx="391.8" cy="149.4" r="5" fill="#19d5e5"/><circle cx="431.3" cy="275" r="11" fill="#19d5e5" opacity=".18"/><circle cx="431.3" cy="275" r="5" fill="#19d5e5"/><circle cx="187.3" cy="415.9" r="11" fill="#12308f" opacity=".18"/><circle cx="187.3" cy="415.9" r="5" fill="#12308f"/><circle cx="88" cy="260" r="13" fill="#12308f" opacity=".18"/><circle cx="88" cy="260" r="7" fill="#12308f"/></g>
                                <g class="gz-ring gz-ring-inner"><circle cx="260" cy="260" r="122" fill="none" stroke="url(#gzoRing)" stroke-width="1.4" stroke-dasharray="2 8" stroke-linecap="round"/><circle cx="301.7" cy="145.4" r="10" fill="#1769ff" opacity=".18"/><circle cx="301.7" cy="145.4" r="4" fill="#1769ff"/><circle cx="301.7" cy="374.6" r="10" fill="#19d5e5" opacity=".18"/><circle cx="301.7" cy="374.6" r="4" fill="#19d5e5"/><circle cx="145.4" cy="218.3" r="10" fill="#7a5cff" opacity=".18"/><circle cx="145.4" cy="218.3" r="4" fill="#7a5cff"/></g>
                                <g class="gz-orbit-base">
                                    <ellipse cx="260" cy="292" rx="96" ry="44" fill="url(#gzoSide)"/>
                                    <ellipse cx="260" cy="276" rx="96" ry="44" fill="url(#gzoTop)"/>
                                    <path d="M260 246 C237 216 222 198 222 174 a38 38 0 0 1 76 0 C298 198 283 216 260 246 Z" fill="url(#gzoPin)"/>
                                    <circle cx="260" cy="174" r="15" fill="#d9f1ff"/>
                                    <text class="gz-orbit-text" x="260" y="273" text-anchor="middle">Base</text>
                                    <text class="gz-orbit-text" x="260" y="294" text-anchor="middle">Thisaiyanvilai</text>
                                </g>
                            </svg>
                            <div class="gz-orbit-label gz-label-a"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.800a3.5 3.5 0 0 1 0 6.400M18 14.500a6.5 6.5 0 0 1 3.5 5.5"/></svg><span><strong>In-person</strong><small>Local &amp; Nearby</small></span></div>
                            <div class="gz-orbit-label gz-label-b"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="5" width="16" height="11" rx="1.8"/><path d="M2 19.500h20"/></svg><span><strong>Remote</strong><small>Pan India &amp; Global</small></span></div>
                            <div class="gz-orbit-label gz-label-c"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 18.500a4.5 4.5 0 0 1-.6-9 6 6 0 0 1 11.4 1.3 3.9 3.9 0 0 1-.8 7.700z"/></svg><span><strong>Hybrid</strong><small>Flexible Engagement</small></span></div>
                        </div>
                    </div>
                </div>
                <div class="gz-cover-title"><span>Our Service Coverage</span></div>
                <div class="gz-region-grid">
                    <div class="gz-region-col gz-cover-a">
                        <div class="gz-cover-head">
                            <span class="gz-cover-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s7-6.2 7-12a7 7 0 0 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="9" r="2.5"/></svg></span>
                            <div><h3 class="title h4">Thisaiyanvilai &amp; Tirunelveli</h3><span class="gz-region-tag">Our Home Area</span></div>
                        </div>
                        <p>Our home area, where meeting in person is easy. We build <a href="<?= site_url('services/website-development') ?>">websites</a>, <a href="<?= site_url('services/custom-software-development') ?>">custom software</a> and business systems for local companies.</p>
                        <ul><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Primary business location</span></li><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Local website and software development</span></li><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>In-person meetings where appropriate</span></li></ul>
                        <svg class="gz-cover-art" viewBox="0 0 170 120" aria-hidden="true"><path fill="currentColor" d="M50 120V96h8V84h6V72h6V60h6V48h5V34h4l2-12 2 12h4v14h5v12h6v12h6v12h6v12h8v24zM136 120v-46c-8-2-16 2-20 8 4-9 12-13 20-12-6-6-14-6-20-2 6-7 15-7 21-3 0-7-6-12-12-12 8-2 15 3 16 10 4-5 11-6 16-3-6 0-11 3-13 8 7-1 14 2 17 8-6-4-13-5-19-2 5 2 9 7 9 13-4-6-9-9-13-9l-2 40z"/><path fill="#fff" opacity=".7" d="M81 120v-18a6 6 0 0 1 12 0v18z"/></svg>
                    </div>
                    <div class="gz-region-col gz-cover-b">
                        <div class="gz-cover-head">
                            <span class="gz-cover-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6.5" width="12.5" height="11" rx="2.5"/><path d="m15.5 11 5.5-3.200v8.400L15.5 13"/></svg></span>
                            <div><h3 class="title h4">Thoothukudi, Nagercoil &amp; Kanyakumari</h3><span class="gz-region-tag">Remote, with visits when needed</span></div>
                        </div>
                        <p>We have no offices here, and projects run smoothly by phone and video call, with meetings arranged when a project needs them.</p>
                        <ul><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Remote project delivery</span></li><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Online consultations</span></li><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Meetings arranged when required</span></li></ul>
                        <svg class="gz-cover-art" viewBox="0 0 170 120" aria-hidden="true"><path fill="currentColor" d="M0 120c20-16 38-24 60-24 8-8 24-16 42-14 26 3 46 20 68 38z"/><path fill="currentColor" d="M92 86 96 36h14l4 50zM94 32h18v-5l-3-3v-8h-12v8l-3 3z"/><path fill="#fff" opacity=".65" d="M95 52h16l.7 8H94.3zM93.6 70h19l.7 8H93z"/></svg>
                    </div>
                    <div class="gz-region-col gz-cover-c">
                        <div class="gz-cover-head">
                            <span class="gz-cover-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 18.500a4.5 4.5 0 0 1-.6-9 6 6 0 0 1 11.4 1.3 3.9 3.9 0 0 1-.8 7.700z"/></svg></span>
                            <div><h3 class="title h4">Thiruvananthapuram &amp; Beyond</h3><span class="gz-region-tag">Remote delivery</span></div>
                        </div>
                        <p>Most website and software work can be done remotely. <a href="<?= site_url('areas-we-serve') ?>">See the areas we serve</a> and how we work in each one.</p>
                        <ul><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Remote website and software development</span></li><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Digital services for businesses in relevant regions</span></li><li><svg viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="currentColor"/><path d="m5.6 10.3 3 3 5.8-6.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>No office here; support is online</span></li></ul>
                        <svg class="gz-cover-art" viewBox="0 0 170 120" aria-hidden="true"><path fill="currentColor" d="M0 120c30-14 60-20 92-18 30 2 56 8 78 18z"/><path fill="currentColor" d="M128 108c3-20 4-40 2-58h4c3 18 2 40-1 58zM132 50c-10-10-24-12-34-4 10-3 22-1 30 8-10-3-22 0-28 10 9-6 20-8 30-4-3 6-5 14-3 22 2-9 6-16 12-20 4 8 5 16 3 24 5-9 5-19 1-27 8 0 15 5 19 12-1-10-8-17-18-19 6-2 13-2 19 2-6-7-16-8-23-4zM66 106c2-11 2-22 1-30h3c2 8 2 20 0 30zM68 76c-6-6-14-7-20-3 6-1 12 0 17 5-6-1-12 1-16 6 5-3 11-4 17-2-2 4-2 8-1 12 1-5 3-9 7-11 2 4 3 9 2 13 3-5 3-10 1-15 5 0 9 3 11 7 0-6-5-10-10-11 3-1 7-1 11 1-3-4-9-5-13-3z"/></svg>
                    </div>
                </div>
            </div>
        </section>
        <!-- End local-sec -->

        <section class="girzock-contact ibt-section-gapBottom" id="get-in-touch">
            <div class="container">
                <div class="girzock-contact-panel">
                    <span class="girzock-glow girzock-glow-a" aria-hidden="true"></span>
                    <span class="girzock-glow girzock-glow-b" aria-hidden="true"></span>
                    <div class="row girzock-contact-row">
                        <div class="col-lg-5">
                            <div class="sec-title white">
                                <span class="sub-title">get in touch</span>
                                <h2 class="title animated-heading">Let's Build Something Great Together</h2>
                                <p>Have a project in mind? Tell us about your requirements. Our team will help you turn your ideas into practical digital solutions.</p>
                            </div>
                            <div class="girzock-contact-name">GIRZOCK Technologies</div>
                            <ul class="girzock-contact-list">
                                <li>
                                    <span class="girzock-icon"><svg aria-hidden="true" focusable="false" class="lucide lucide-map-pin" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" > <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" /> <circle cx="12" cy="10" r="3" /> </svg></span>
                                    <span class="girzock-contact-item"><span class="girzock-contact-label">Location</span><span><?= e(setting('address_short')) ?></span></span>
                                </li>
                                <li>
                                    <span class="girzock-icon"><svg aria-hidden="true" focusable="false" class="lucide lucide-mail" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" > <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" /> <rect x="2" y="4" width="20" height="16" rx="2" /> </svg></span>
                                    <span class="girzock-contact-item"><span class="girzock-contact-label">Email</span><a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a></span>
                                </li>
                                <li>
                                    <span class="girzock-icon"><svg aria-hidden="true" focusable="false" class="lucide lucide-phone" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" > <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" /> </svg></span>
                                    <span class="girzock-contact-item"><span class="girzock-contact-label">Phone</span><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', setting('phone'))) ?>"><?= e(setting('phone')) ?></a></span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-7">
                            <?php $this->load->view('frontend/partials/enquiry_form'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End enquiry form -->

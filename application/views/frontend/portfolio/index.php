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

    <!-- portfolio gallery -->
    <section class="project-sec8 gz-showcase ibt-section-gap">
        <div class="container">
            <div class="sec-title">
                <span class="sub-title">sample concepts</span>
                <h2 class="title animated-heading">Project Concepts That Show How We Think</h2>
                <p><?= e(setting('portfolio_intro')) ?></p>
            </div>
            <ul class="menu_iso" id="custom-filter">
<?php $this->load->view('frontend/portfolio/_filters'); ?>
</ul>
            <div class="row iso-container2">
<?php $this->load->view('frontend/portfolio/_gallery'); ?>
</div>
        </div>
    </section>
    <!-- End portfolio gallery -->

    <!-- kinds of projects -->
    <section class="gz-kinds ibt-section-gapBottom">
        <div class="container">
            <div class="sec-title">
                <span class="sub-title">what we build</span>
                <h2 class="title animated-heading">The Kinds of Projects We Take on</h2>
            </div>
            <div class="row gz-showcase-row">
                <?php foreach (array(
                    array('web-design', 'website-development', 'Websites', 'Business and corporate websites', 'Responsive websites that present your business clearly and generate enquiries.'),
                    array('web-apps', 'web-application-development', 'Web Apps', 'Web applications and portals', 'Secure, browser-based tools for your customers and your team.'),
                    array('ecommerce', 'e-commerce-development', 'E-commerce', 'Online stores', 'Catalogues, payments and order management for selling online.'),
                    array('wordpress', 'wordpress-development', 'WordPress', 'WordPress websites', 'Custom WordPress builds that your team can manage with ease.'),
                    array('custom-software', 'custom-software-development', 'Software', 'Custom business software', 'Systems shaped around the way your business works.'),
                    array('aws', 'aws-cloud-solutions', 'Cloud', 'Cloud and AWS deployments', 'Hosting and infrastructure planned for reliability and growth.'),
                ) as $kind): ?>
                <div class="col-lg-4 col-md-6">
                    <article class="gz-show-card">
                        <a href="<?= service_link($kind[0]) ?>" class="gz-show-img gz-show-img-wide" tabindex="-1" aria-hidden="true">
                            <img src="<?= asset('assets/images/generated/pro/cards/'.$kind[1].'.webp') ?>" width="800" height="500" loading="lazy" decoding="async" alt="">
                        </a>
                        <div class="gz-show-body">
                            <span class="gz-show-cat"><?= e($kind[2]) ?></span>
                            <h3 class="title h4"><a href="<?= service_link($kind[0]) ?>"><?= e($kind[3]) ?></a></h3>
                            <p><?= e($kind[4]) ?></p>
                            <a class="gz-show-link" href="<?= service_link($kind[0]) ?>">Explore the Service<span aria-hidden="true"> &rarr;</span></a>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- End kinds of projects -->

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

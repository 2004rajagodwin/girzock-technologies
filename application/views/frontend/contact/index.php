<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- page-banner9 -->
    <section class="page-banner9">
        <div class="shape"></div>
        <div class="shape3"></div>
        <div class="staff-text">Contact</div>
        <div class="container">
            <div class="page-content">
                <h1 class="title">/ Contact GIRZOCK /</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li>/</li>
            <li>Contact</li>
        </ul>
    </section>
    <!-- End page-banner9 -->

    <!-- contact-sec -->
    <section class="contact-sec2 ibt-section-gap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="contact-content2">
                        <div class="sec-title">
                            <span class="sub-title">get in touch</span>
                            <h2 class="title animated-heading">Tell Us What You Want to Build Next</h2>
                            <p>Have a question about a website, custom software or cloud solution? We are based in Thisaiyanvilai and work with businesses across Tirunelveli and <a href="<?= site_url('areas-we-serve') ?>">nearby districts</a>. Call <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', setting('phone'))) ?>"><?= e(setting('phone')) ?></a> or send us the details, and we will get back to you with clear next steps.</p>
                        </div>
                        <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="contact-info">
            <div class="call-center2">
                <h3 class="title h4">Email</h3>
                <a href="mailto:<?= e(setting('contact_email')) ?>" class="gmail"><?= e(setting('contact_email')) ?></a>
            </div>
            <div class="call-center2 mb-0">
                <h3 class="title h4">Website</h3>
                <a href="<?= e(setting('website_url')) ?>" class="gmail"><?= e(preg_replace('#^https?://#', '', rtrim(setting('website_url'), '/'))) ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="contact-info">
            <div class="call-center2">
                <h3 class="title h4">Our Location</h3>
                <p><?= str_replace("\n", ' <br>', e(setting('business_address'))) ?></p>
            </div>
            <div class="call-center2 mb-0">
                <h3 class="title h4">Social Network</h3>
                <?php $this->load->view('frontend/partials/social_icons'); ?>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form v2">
    <?php $this->load->view('frontend/partials/contact_form'); ?>
</div>
                </div>
            </div>
        </div>
    </section>
    <!-- End contact-sec -->

    <!-- googel-map -->
    <section class="googel-map">
        <h2>GIRZOCK Technologies Location Map</h2>
        <div class="container2">
            <iframe title="Map of Thisaiyanvilai, Tirunelveli, Tamil Nadu, India" src="https://www.google.com/maps?q=Thisaiyanvilai,+Tirunelveli,+Tamil+Nadu,+India&amp;output=embed" height="500" style="border:0; border-radius: 25px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>
    <!-- End googel-map -->

    <!-- main-sec -->
    <section class="main-sec">

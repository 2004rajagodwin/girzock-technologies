<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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

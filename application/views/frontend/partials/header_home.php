<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--======== Header ========-->
<header class="vs-header2">
    <div class="container2 position-relative">
        <div class="header-menu-area">
            <div class="row gx-20 align-items-center justify-content-between">
                <div class="col-auto col">
                    <div class="header-logo">
                        <a href="#sideMenu" class="menu-toggle v2" aria-label="Open contact panel"></a>
                        <a href="<?= site_url() ?>" aria-label="<?= e(setting('company_name')) ?> home"><img src="<?= e(media_url(setting('logo_white'))) ?>" alt="<?= e(setting('company_name')) ?> logo"></a>
                    </div>
                </div>
                <div class="col-auto">
                    <?php $this->load->view('frontend/partials/nav', array('is_home' => TRUE)); ?>
                </div>
                <div class="col-auto d-none d-xl-block">
                    <div class="btn-box">
                        <a href="#" class="popup-search" data-popup="1" aria-label="Search"><i class="fa fa-search"></i></a>
                        <a class='ibt-btn ibt-btn-outline-3 ibt-btn-rounded' href="<?= site_url('contact') ?>">
                            <span>Get in Touch</span>
                        </a>
                    </div>
                </div>
            </div>
            <button class="hamburger popup-menu" data-menu="mobileMenu" aria-label="Open menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>
<!--======== / Header ========-->

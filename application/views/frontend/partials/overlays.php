<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$email = setting('contact_email');
$address_html = str_replace("\n", ' <br>', e(setting('business_address')));
$mobile_services = $is_home ? $this->settings_model->services_by('menu_order') : $this->settings_model->services_by('footer_order');
?>
<!-- Preloader -->
<div id="preloader">
    <div class="loader">
        <img src="<?= e(media_url(setting('logo_icon'))) ?>" alt="Loading <?= e(setting('company_name')) ?>">
    </div>
</div>
<!-- End Preloader -->

<button id="themeBtn" aria-label="Switch colour theme"><i class="far fa-moon"></i></button>
<div class="video-modal">
    <div class="video-modal-content">
        <span class="close-btn">&times;</span>
        <iframe allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
</div>
<!-- search-popup -->
<div class="search-popup" data-popup="1">
    <div class="search-popup-content">
        <form action="<?= site_url('search') ?>" method="get">
            <button type="submit" aria-label="Search"><i class="fa fa-search"></i></button>
            <input type="text" name="q" placeholder="Search this website..." aria-label="Search this website" required>
        </form>
        <button type="button" class="close-popup" aria-label="Close search"></button>
    </div>
</div>

<!-- Side Menu -->
<div class="side-menu" id="sideMenu">
    <div class="overlay" id="overlay"></div>
    <a href="#sideMenu" class="close-btn" id="closeBtn"><i class="fa fa-close"></i> close</a>
    <div class="menu-content">
        <a class='logo' href="<?= site_url() ?>">
            <img src="<?= e(media_url(setting('logo_white'))) ?>" alt="<?= e(setting('company_name')) ?> logo">
        </a>
        <div class="sidebar-menu">
            <?php if ($is_home): ?><div class="title">contacts</div><?php else: ?><h4 class="title">Contacts</h4><?php endif; ?>
            <p><?= $address_html ?></p>
            <a href="mailto:<?= e($email) ?>" class="email"><?= e($email) ?></a>
            <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                <span>Get in Touch</span>
            </a>
        </div>
        <?php $this->load->view('frontend/partials/social_icons'); ?>
    </div>
</div>

<!-- New Mobile Menu -->
<div data-menu="mobileMenu" class="side-menu2">
    <div class="menu-btns">
        <a href="#" class="popup-search" data-popup="1" aria-label="Search"><i class="fa fa-search"></i></a>
        <button id="mobileCloseBtn2" class="close-btn" aria-label="Close menu"></button>
    </div>
    <ul>
        <li>
            <a href="#">About</a>
            <ul>
                <li><a href="<?= site_url('about') ?>">About GIRZOCK</a></li>
                <li><a href="<?= site_url('about') ?>#who-we-are">Who we are</a></li>
                <li><a href="<?= site_url('about') ?>#mission">Mission &amp; vision</a></li>
                <li><a href="<?= site_url('about') ?>#values">Our values</a></li>
                <li><a href="<?= site_url('about') ?>#expertise">Our expertise</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Services</a>
            <ul>
                <li><a href="<?= site_url('services') ?>">All services</a></li>
                <?php foreach ($mobile_services as $service): ?>
                <li><a href="<?= site_url('services/'.$service['slug']) ?>"><?= e($is_home ? ($service['menu_title'] ? $service['menu_title'] : $service['title']) : ($service['footer_title'] ? $service['footer_title'] : $service['title'])) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="girzock-no-sub"><a href="<?= site_url('products') ?>">Products</a></li>
        <li class="girzock-no-sub"><a href="<?= site_url('case-studies') ?>">Case Studies</a></li>
        <li class="girzock-no-sub"><a href="<?= site_url('portfolio') ?>">Portfolio</a></li>
        <li class="girzock-no-sub"><a href="<?= site_url('careers') ?>">Careers</a></li>
        <li class="girzock-no-sub"><a href="<?= site_url('blog') ?>">Blog</a></li>
        <li class="girzock-no-sub"><a href="<?= site_url('contact') ?>">Contact</a></li>
    </ul>
    <div class="menu-contact">
        <span>Contacts</span>
        <a href="mailto:<?= e($email) ?>" title="" class="gmail"><?= e($email) ?></a>
    </div>
    <div class="menu-links">
        <span>Follow us:</span>
        <?php $this->load->view('frontend/partials/social_icons'); ?>
        <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
            <span>Get in Touch</span>
        </a>
    </div>
</div>
<!-- Overlay for Mobile Menu -->
<div class="overlay2"></div>

<!-- sticky header -->
<header class="sticky-active">
    <div class="header-menu-area">
        <div class="row gx-20 align-items-center justify-content-between">
            <div class="col-auto">
                <div class="header-logo">
                    <a href="#sideMenu" class="menu-toggle" aria-label="Open contact panel"></a>
                    <a href="<?= site_url() ?>" aria-label="<?= e(setting('company_name')) ?> home"><img src="<?= e(media_url(setting('logo_color'))) ?>" alt="<?= e(setting('company_name')) ?> logo"<?= $is_home ? '' : ' class="girzock-auto-logo"' ?>></a>
                </div>
            </div>
            <div class="col-auto">
                <?php $this->load->view('frontend/partials/nav', array('is_home' => $is_home)); ?>
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
</header>
<!-- End sticky header -->

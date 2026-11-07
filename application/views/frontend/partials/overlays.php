<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$email = setting('contact_email');
$address_html = str_replace("\n", ' <br>', e(setting('business_address')));
$mobile_services = $this->settings_model->services_by('menu_order');
?>
<!-- Preloader -->
<div id="preloader" class="gz-preloader" role="status" aria-label="Loading">
    <svg class="gz-pre-wave gz-pre-wave-top" viewBox="0 0 700 420" fill="none" aria-hidden="true" focusable="false"><path d="M0 170C150 110 250 170 340 90S520 0 700 0H0Z" fill="#19d5e5" opacity=".08"/><path d="M0 250C130 230 240 170 320 90S470 10 560 0H380C330 40 290 90 230 120S90 130 0 120Z" fill="#1769ff" opacity=".06"/><path d="M0 320C120 280 230 190 320 95S470 25 620 15" stroke="#19d5e5" stroke-opacity=".35"/><path d="M0 130C110 110 210 150 310 95S430 20 480 0" stroke="#1769ff" stroke-opacity=".22"/></svg>
    <svg class="gz-pre-wave gz-pre-wave-bottom" viewBox="0 0 700 420" fill="none" aria-hidden="true" focusable="false"><path d="M0 170C150 110 250 170 340 90S520 0 700 0H0Z" fill="#19d5e5" opacity=".08"/><path d="M0 250C130 230 240 170 320 90S470 10 560 0H380C330 40 290 90 230 120S90 130 0 120Z" fill="#1769ff" opacity=".06"/><path d="M0 320C120 280 230 190 320 95S470 25 620 15" stroke="#19d5e5" stroke-opacity=".35"/><path d="M0 130C110 110 210 150 310 95S430 20 480 0" stroke="#1769ff" stroke-opacity=".22"/></svg>
    <div class="gz-pre-box">
        <div class="gz-pre-ring">
            <svg viewBox="0 0 240 240" fill="none" aria-hidden="true" focusable="false">
                <defs><linearGradient id="gz-pre-arc" gradientUnits="userSpaceOnUse" x1="232" y1="120" x2="28" y2="56"><stop offset="0" stop-color="#1769ff" stop-opacity="0"/><stop offset=".35" stop-color="#1769ff"/><stop offset="1" stop-color="#19d5e5"/></linearGradient><linearGradient id="gz-pre-track" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#cfeefa"/><stop offset=".72" stop-color="#e3f3fb"/><stop offset="1" stop-color="#e3f3fb" stop-opacity="0"/></linearGradient></defs>
                <circle cx="120" cy="120" r="112" stroke="url(#gz-pre-track)" stroke-width="3"/>
                <g class="gz-pre-spin">
                    <circle cx="120" cy="120" r="112" stroke="url(#gz-pre-arc)" stroke-width="4" stroke-linecap="round" stroke-dasharray="420 284"/>
                    <circle cx="28.3" cy="55.8" r="11" fill="#19d5e5" opacity=".28"/>
                    <circle cx="28.3" cy="55.8" r="5.5" fill="#fff" stroke="#13c6e0" stroke-width="3"/>
                </g>
            </svg>
            <img class="gz-pre-logo" src="<?= asset(preloader_logo()) ?>" width="3000" height="2382" alt="<?= e(setting('company_name')) ?>">
        </div>
        <p class="gz-pre-label">Loading...</p>
        <div class="gz-pre-bar"><span class="gz-pre-fill"></span><b class="gz-pre-pct">0%</b></div>
        <div class="gz-pre-dots" aria-hidden="true"><i></i><i></i><i></i></div>
    </div>
</div>
<script>try{if(sessionStorage.getItem("gzPageLoaded")){var gzPre=document.getElementById("preloader");gzPre.style.display="none";gzPre.dataset.hidden="true";}}catch(e){}</script>
<noscript><style>#preloader{display:none}</style></noscript>
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
            <img src="<?= e(media_url(setting('logo_white'))) ?>" width="640" height="199" alt="<?= e(setting('company_name')) ?> logo">
        </a>
        <div class="sidebar-menu">
            <?php if ($is_home): ?><div class="title">contacts</div><?php else: ?><h3 class="title h4">Contacts</h3><?php endif; ?>
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
                <li><a href="<?= site_url('services/'.$service['slug']) ?>"><?= e($service['menu_title'] ? $service['menu_title'] : $service['title']) ?></a></li>
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
                    <a href="<?= site_url() ?>" aria-label="<?= e(setting('company_name')) ?> home"><img src="<?= e(media_url(setting('logo_color'))) ?>" width="640" height="199" alt="<?= e(setting('company_name')) ?> logo"<?= $is_home ? '' : ' class="girzock-auto-logo"' ?>></a>
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

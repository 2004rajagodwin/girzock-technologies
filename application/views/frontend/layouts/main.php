<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Shared page shell. Asset order and loading strategy match the original static pages. */
$is_home = ! empty($is_home);
$use_wrapper = ! empty($use_wrapper);
$gallery_scripts = ! empty($gallery_scripts);
$gallery_css = $gallery_scripts OR ! empty($gallery_css);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->load->view('frontend/partials/seo', array('seo' => $seo)); ?>
    <?php if ($is_home): ?><link rel="preload" as="image" href="<?= asset('assets/images/bg/bg2.png') ?>"><?php endif; ?>

    <link rel="preload" href="<?= asset('assets/fonts/manrope-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('assets/fonts/sora-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>

    <?php $favicon = site_favicon(); ?>
    <link rel="icon" type="<?= e($favicon['type']) ?>" href="<?= e($favicon['url']) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/logos/apple-touch-icon.png') ?>">

    <link rel="stylesheet" href="<?= asset('assets/fonts/girzock-fonts.css') ?>">

    <link rel="stylesheet" href="<?= asset('assets/css/font-awesome.min.css') ?>" media="print" onload="this.media='all'">

    <link rel="stylesheet" href="<?= asset('assets/css/plugins/fontello-enqueue.css') ?>" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="<?= asset('assets/css/plugins/fontello-icons.css') ?>" media="print" onload="this.media='all'">

    <link rel="stylesheet" href="<?= asset('assets/css/plugins/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/style.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/girzock.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/girzock-dynamic.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/plugins/swiper-bundle.min.css') ?>">
    <?php if ($gallery_css): ?>
    <link rel="stylesheet" href="<?= asset('assets/css/plugins/lightgallery-bundle.min.css') ?>" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="<?= asset('assets/css/plugins/lightgallery-bundle.min.css') ?>">
    </noscript>
    <?php endif; ?>
    <?php if (preg_match('/^G-[A-Z0-9]+$|^UA-[0-9-]+$/', setting('google_analytics_id'))): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e(setting('google_analytics_id')) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e(setting('google_analytics_id')) ?>');</script>
    <?php endif; ?>
</head>

<body class="<?= $is_home ? 'girzock-home ' : '' ?>girzock-nav">
<?php if ($use_wrapper): ?><div class="wrapper"><?php endif; ?>
<?php $this->load->view('frontend/partials/overlays', array('is_home' => $is_home)); ?>
<?php $this->load->view($is_home ? 'frontend/partials/header_home' : 'frontend/partials/header_inner'); ?>

<?php if ( ! empty($is_preview)): ?><div class="gz-preview-bar" role="status">Preview only. This page is not published, and visitors cannot see it.</div><?php endif; ?>
<?php $gz_content = $this->load->view($content_view, array(), TRUE); echo $gz_content; ?>

<?php if ($is_home): ?>
<?php $this->load->view('frontend/partials/footer_home'); ?>
<?php else: ?>
<?php $this->load->view('frontend/partials/footer_inner', array('main_sec_open' => substr_count($gz_content, 'class="main-sec') > substr_count($gz_content, '<!-- End main-sec -->'))); ?>
<?php endif; ?>

<!-- Scroll Button -->
<button id="scrollBtn" title="Go to top">
    <i class="fas fa-angle-up"></i>
</button>
<a id="gz-whatsapp" class="gz-whatsapp" href="https://wa.me/916379362330" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp" title="Chat on WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
<?php if ($use_wrapper): ?></div><?php endif; ?>
<?php $popup = get_instance()->popup_state(); if ($popup) { $this->load->view('frontend/partials/promo_popup', array('popup' => $popup)); } ?>

<script>window.GIRZOCK_SITE=<?= json_encode(array('email' => setting('contact_email'), 'phone' => setting('phone'), 'searchUrl' => site_url('search')), JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>" defer></script>
<script src="<?= asset('assets/js/vendor/swiper-bundle.min.js') ?>" defer></script>
<?php if ($gallery_scripts): ?>
<script src="<?= asset('assets/js/vendor/lightgallery.min.js') ?>" defer></script>
<script src="<?= asset('assets/js/vendor/lg-zoom.min.js') ?>" defer></script>
<script src="<?= asset('assets/js/vendor/lg-thumbnail.min.js') ?>" defer></script>
<?php endif; ?>
<script src="<?= asset('assets/js/vendor/lenis.min.js') ?>" defer></script>
<script src="<?= asset('assets/js/vendor/gsap.min.js') ?>" defer></script>
<script src="<?= asset('assets/js/vendor/ScrollTrigger.min.js') ?>" defer></script>
<?php if ($gallery_scripts): ?>
<script src="<?= asset('assets/js/vendor/isotope.pkgd.min.js') ?>" defer></script>
<script src="<?= asset('assets/js/vendor/imagesloaded.pkgd.min.js') ?>" defer></script>
<?php endif; ?>
<script src="<?= asset('assets/js/main.min.js') ?>" defer></script>
<script src="<?= asset('assets/js/girzock.min.js') ?>" defer></script>
</body>
</html>

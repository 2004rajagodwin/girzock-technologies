<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <title><?= e($seo['title']) ?></title>
    <meta name="description" content="<?= e($seo['description']) ?>">
    <?php if ( ! empty($seo['keywords'])): ?><meta name="keywords" content="<?= e($seo['keywords']) ?>"><?php endif; ?>
    <meta name="author" content="<?= e(setting('company_name')) ?>">
    <?php if ( ! isset($seo['indexable']) OR $seo['indexable']): ?><link rel="canonical" href="<?= e($seo['canonical']) ?>"><?php endif; ?>
    <?php if ( ! empty($seo['prev'])): ?><link rel="prev" href="<?= e($seo['prev']) ?>"><?php endif; ?>
    <?php if ( ! empty($seo['next'])): ?><link rel="next" href="<?= e($seo['next']) ?>"><?php endif; ?>
    <meta name="robots" content="<?= e($seo['robots']) ?>">
    <?php if ( ! empty($seo['is_home'])): ?>
    <?php if ( ! isset($seo['indexable']) OR $seo['indexable']): ?><meta name="googlebot" content="index, follow"><?php endif; ?>
    <meta name="language" content="English">
    <meta name="contact" content="<?= e(setting('contact_email')) ?>">
    <meta name="telephone" content="<?= e(preg_replace('/[^\d+]/', '', (string) setting('phone'))) ?>">
    <?php endif; ?>
    <meta name="geo.region" content="IN-TN">
    <meta name="geo.placename" content="Thisaiyanvilai, Tirunelveli, Tamil Nadu">
    <meta name="theme-color" content="#0A1A3F">
    <?php if (setting('gsc_verification')): ?><meta name="google-site-verification" content="<?= e(setting('gsc_verification')) ?>"><?php endif; ?>
    <meta property="og:site_name" content="<?= e(setting('company_name')) ?>">
    <meta property="og:type" content="<?= e($seo['og_type']) ?>">
    <meta property="og:locale" content="en_IN">
    <meta property="og:title" content="<?= e($seo['og_title']) ?>">
    <meta property="og:description" content="<?= e($seo['og_description']) ?>">
    <meta property="og:url" content="<?= e($seo['canonical']) ?>">
    <meta property="og:image" content="<?= e($seo['image']) ?>">
    <?php if ( ! empty($seo['image_width'])): ?><meta property="og:image:width" content="<?= (int) $seo['image_width'] ?>">
    <meta property="og:image:height" content="<?= (int) $seo['image_height'] ?>"><?php endif; ?>
    <meta property="og:image:alt" content="<?= e($seo['image_alt']) ?>">
    <meta name="twitter:card" content="<?= e($seo['twitter_card']) ?>">
    <meta name="twitter:title" content="<?= e(isset($seo['twitter_title']) ? $seo['twitter_title'] : $seo['og_title']) ?>">
    <meta name="twitter:description" content="<?= e(isset($seo['twitter_description']) ? $seo['twitter_description'] : $seo['og_description']) ?>">
    <meta name="twitter:image" content="<?= e($seo['image']) ?>">
    <meta name="twitter:image:alt" content="<?= e($seo['image_alt']) ?>">
    <?php foreach ($seo['schema'] as $schema): ?>
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
    <?php endforeach; ?>

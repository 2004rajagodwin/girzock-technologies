<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <title><?= e($seo['title']) ?></title>
    <meta name="description" content="<?= e($seo['description']) ?>">
    <link rel="canonical" href="<?= e($seo['canonical']) ?>">
    <?php if ( ! empty($seo['prev'])): ?><link rel="prev" href="<?= e($seo['prev']) ?>"><?php endif; ?>
    <?php if ( ! empty($seo['next'])): ?><link rel="next" href="<?= e($seo['next']) ?>"><?php endif; ?>
    <meta name="robots" content="<?= e($seo['robots']) ?>">
    <meta name="theme-color" content="#0b1f5c">
    <meta property="og:site_name" content="<?= e(setting('company_name')) ?>">
    <meta property="og:type" content="<?= e($seo['og_type']) ?>">
    <meta property="og:locale" content="en_IN">
    <meta property="og:title" content="<?= e($seo['og_title']) ?>">
    <meta property="og:description" content="<?= e($seo['og_description']) ?>">
    <meta property="og:url" content="<?= e($seo['canonical']) ?>">
    <meta property="og:image" content="<?= e($seo['image']) ?>">
    <meta name="twitter:card" content="<?= e($seo['twitter_card']) ?>">
    <meta name="twitter:title" content="<?= e($seo['og_title']) ?>">
    <meta name="twitter:description" content="<?= e($seo['og_description']) ?>">
    <meta name="twitter:image" content="<?= e($seo['image']) ?>">
    <?php if (setting('gsc_verification')): ?><meta name="google-site-verification" content="<?= e(setting('gsc_verification')) ?>"><?php endif; ?>
    <?php foreach ($seo['schema'] as $schema): ?>
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
    <?php endforeach; ?>

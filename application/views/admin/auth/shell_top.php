<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Shared shell for sign in, forgot password and reset password. Brand panel on the left, form on the right. */
$logo_white = setting('logo_white') ?: 'assets/logos/girzock-logo-white.png';
$logo_color = setting('logo_color') ?: 'assets/logos/girzock-logo-color.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0A1A3F">
    <title><?= e($title) ?> | <?= e(setting('company_name')) ?></title>
    <?php $favicon = site_favicon(); ?>
    <link rel="icon" type="<?= e($favicon['type']) ?>" href="<?= e($favicon['url']) ?>">
    <link rel="preload" href="<?= asset('assets/fonts/manrope-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= asset('assets/fonts/girzock-fonts.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/admin/css/admin.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/admin/css/auth.css') ?>">
</head>
<body class="gz-auth">
<div class="gz-auth-bg" aria-hidden="true"><span class="gz-auth-glow gz-auth-glow-1"></span><span class="gz-auth-glow gz-auth-glow-2"></span><span class="gz-auth-grid"></span></div>
<main class="gz-auth-card">
    <section class="gz-auth-brand" aria-label="<?= e(setting('company_name')) ?>">
        <img class="gz-auth-brand-logo" src="<?= e(media_url($logo_white)) ?>" width="640" height="199" alt="<?= e(setting('company_name')) ?>">
        <div class="gz-auth-brand-copy">
            <p class="gz-auth-eyebrow">Admin console</p>
            <p class="gz-auth-lead">Manage your website content, enquiries, careers and SEO in one secure place.</p>
        </div>
        <ul class="gz-auth-points">
            <li><span class="gz-auth-dot" aria-hidden="true"></span>Encrypted, role-based access</li>
            <li><span class="gz-auth-dot" aria-hidden="true"></span>Every change recorded</li>
        </ul>
    </section>
    <section class="gz-auth-panel">
        <img class="gz-auth-logo" src="<?= e(media_url($logo_color)) ?>" width="640" height="199" alt="<?= e(setting('company_name')) ?>">
        <h1><?= e($title) ?></h1>

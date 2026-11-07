<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$auth = $this->auth;
$nav = array(
	array('dashboard', 'dashboard', 'Dashboard', 'fa-gauge-high', 'dashboard'),
	array('enquiries', 'enquiries', 'Enquiries', 'fa-inbox', 'enquiries'),
	array('services', 'services', 'Services', 'fa-layer-group', 'services'),
	array('products', 'products', 'Products', 'fa-cube', 'products'),
	array('portfolio', 'portfolio', 'Portfolio', 'fa-briefcase', 'portfolio'),
	array('case-studies', 'caseStudies', 'Case Studies', 'fa-book-open', 'case_studies'),
	array('blog', 'blog', 'Blog Management', 'fa-pen-nib', 'blog'),
	array('careers', 'careers', 'Careers', 'fa-user-tie', 'careers'),
	array('job-applications', 'applications', 'Job Applications', 'fa-file-lines', 'applications'),
	array('media', 'media', 'Media Library', 'fa-images', 'media'),
	array('categories', 'categories', 'Categories', 'fa-tags', 'categories'),
	array('popup', 'popup', 'Promotional Popup', 'fa-bullhorn', 'popup'),
	array('seo', 'seo', 'SEO Management', 'fa-magnifying-glass-chart', 'seo'),
	array('users', 'users', 'Admin Users', 'fa-users-gear', 'users'),
	array('settings', 'settings', 'Website Settings', 'fa-sliders', 'settings'),
);
$current = strtolower($this->router->class);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="gz-csrf-name" content="<?= e($this->security->get_csrf_token_name()) ?>">
    <meta name="gz-csrf-hash" content="<?= e($this->security->get_csrf_hash()) ?>">
    <meta name="gz-base" content="<?= e(site_url('admin')) ?>">
    <title><?= e($page_title) ?> | <?= e(setting('company_name')) ?> Admin</title>
    <link rel="icon" type="image/png" href="<?= e(media_url(setting('favicon'))) ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/admin/css/admin.css') ?>">
</head>
<body class="gz-admin">
<a class="gz-skip" href="#gz-main">Skip to content</a>
<aside class="gz-sidebar" id="gz-sidebar" aria-label="Admin navigation">
    <a class="gz-brand" href="<?= site_url('admin/dashboard') ?>"><img src="<?= e(media_url(setting('logo_white'))) ?>" alt="<?= e(setting('company_name')) ?>"></a>
    <nav class="gz-nav">
        <?php foreach ($nav as $item): if ( ! $auth->can($item[4])) { continue; } ?>
        <a href="<?= site_url('admin/'.$item[0]) ?>"<?= $current === strtolower($item[1]) ? ' class="active" aria-current="page"' : '' ?>>
            <i class="fa-solid <?= $item[3] ?>" aria-hidden="true"></i><span><?= e($item[2]) ?></span>
            <?php if ($item[0] === 'enquiries'): ?><span class="gz-nav-count" data-gz-unread<?= $unread_enquiries ? '' : ' hidden' ?>><?= (int) $unread_enquiries ?></span><?php endif; ?>
        </a>
        <?php endforeach; ?>
        <a href="<?= site_url('admin/profile') ?>"<?= $current === 'profile' ? ' class="active" aria-current="page"' : '' ?>><i class="fa-solid fa-circle-user" aria-hidden="true"></i><span>Profile</span></a>
        <form action="<?= site_url('admin/logout') ?>" method="post"><?= csrf_field() ?><button type="submit"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i><span>Logout</span></button></form>
    </nav>
</aside>
<div class="gz-scrim" data-gz-sidebar-toggle></div>
<div class="gz-shell">
    <header class="gz-topbar">
        <button class="gz-icon-btn" type="button" data-gz-sidebar-toggle aria-label="Toggle sidebar" aria-controls="gz-sidebar"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
        <form class="gz-top-search" action="<?= site_url('admin/dashboard/search') ?>" method="get" role="search">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <input type="search" name="q" placeholder="Search..." aria-label="Search the admin panel" maxlength="100">
        </form>
        <div class="gz-top-actions">
            <a class="gz-icon-btn" href="<?= site_url() ?>" target="_blank" rel="noopener" aria-label="View website" title="View website"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
            <?php if ($auth->can('enquiries')): ?>
            <div class="gz-dropdown">
                <button class="gz-icon-btn" type="button" data-gz-dropdown aria-expanded="false" aria-label="Notifications">
                    <i class="fa-solid fa-bell" aria-hidden="true"></i><span class="gz-dot" data-gz-unread<?= $unread_enquiries ? '' : ' hidden' ?>><?= (int) $unread_enquiries ?></span>
                </button>
                <div class="gz-dropdown-menu gz-notify" data-gz-notify-list><p class="gz-muted">Loading...</p></div>
            </div>
            <?php endif; ?>
            <div class="gz-dropdown">
                <button class="gz-user-btn" type="button" data-gz-dropdown aria-expanded="false">
                    <?php if ($admin['avatar']): ?><img src="<?= e(media_url($admin['avatar'])) ?>" alt=""><?php else: ?><span class="gz-avatar" aria-hidden="true"><?= e(mb_strtoupper(mb_substr($admin['full_name'], 0, 1))) ?></span><?php endif; ?>
                    <span class="gz-user-name"><?= e($admin['full_name']) ?><small><?= e($admin['role_name']) ?></small></span>
                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                </button>
                <div class="gz-dropdown-menu">
                    <a href="<?= site_url('admin/profile') ?>">Profile</a>
                    <a href="<?= site_url('admin/profile/password') ?>">Change password</a>
                    <form action="<?= site_url('admin/logout') ?>" method="post"><?= csrf_field() ?><button type="submit">Logout</button></form>
                </div>
            </div>
        </div>
    </header>
    <main class="gz-main" id="gz-main">
        <h1 class="gz-page-title"><?= e($page_title) ?></h1>
        <?php if ($flash_success): ?><div class="gz-flash gz-flash-success" role="status"><?= e($flash_success) ?></div><?php endif; ?>
        <?php if ($flash_error): ?><div class="gz-flash gz-flash-error" role="alert"><?= e($flash_error) ?></div><?php endif; ?>
        <?php $this->load->view($content_view); ?>
    </main>
</div>
<script src="<?= asset('assets/admin/js/admin.js') ?>" defer></script>
</body>
</html>

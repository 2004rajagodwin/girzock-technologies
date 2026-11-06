<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* The original inner-page banner. $crumbs is label => path; the last entry is the current page. */
?>
<!-- page-banner9 -->
<section class="page-banner9">
    <div class="shape"></div>
    <div class="shape3"></div>
    <div class="staff-text"><?= e($staff) ?></div>
    <div class="container">
        <div class="page-content">
            <h1 class="title gz-detail-title"><?= e($heading) ?></h1>
        </div>
    </div>
    <ul class="breadcrumbs gz-crumbs">
        <li><a href="<?= site_url() ?>">Home</a></li>
        <?php foreach ($crumbs as $label => $path): ?>
        <li>/</li>
        <li><?php if ($path !== NULL): ?><a href="<?= site_url($path) ?>"><?= e($label) ?></a><?php else: ?><?= e($label) ?><?php endif; ?></li>
        <?php endforeach; ?>
    </ul>
</section>
<!-- End page-banner9 -->

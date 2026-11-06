<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-blog-toolbar">
    <ul class="tag-list">
        <li><a href="<?= site_url('blog') ?>"<?= empty($active_category) ? ' aria-current="page"' : '' ?>>/ All /</a></li>
        <?php foreach ($blog_categories as $category): ?>
        <li><a href="<?= site_url('blog/category/'.$category['slug']) ?>"<?= ( ! empty($active_category) && $active_category === $category['slug']) ? ' aria-current="page"' : '' ?>>/ <?= e($category['name']) ?> /</a></li>
        <?php endforeach; ?>
    </ul>
    <form class="gz-blog-search" action="<?= site_url('blog') ?>" method="get" role="search">
        <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search articles" aria-label="Search articles" maxlength="100">
        <button type="submit" aria-label="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
</div>

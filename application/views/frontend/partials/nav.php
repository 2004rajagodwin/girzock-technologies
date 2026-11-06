<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Main navigation. The homepage shows the services mega menu; inner pages show the sub-menu, as on the original site. */
$top = array('products' => 'Products', 'case-studies' => 'Case Studies', 'portfolio' => 'Portfolio', 'careers' => 'Careers', 'blog' => 'Blog', 'contact' => 'Contact');
$active = function ($section) use ($is_home) { return $is_home ? '' : nav_active($section); };
?>
<nav class="main-menu menu-style1">
    <ul>
        <li>
            <a<?= $active('about') ?> href="<?= site_url('about') ?>">
                <span class="menu-item">About</span>
                <span class="menu-item2">About</span>
            </a>
            <ul class="sub-menu">
                <li><a href="<?= site_url('about') ?>#who-we-are">Who we are</a></li>
                <li><a href="<?= site_url('about') ?>#mission">Mission &amp; vision</a></li>
                <li><a href="<?= site_url('about') ?>#values">Our values</a></li>
                <li><a href="<?= site_url('about') ?>#expertise">Our expertise</a></li>
            </ul>
        </li>
        <li>
            <a<?= $active('services') ?> href="<?= site_url('services') ?>">
                <span class="menu-item">Services</span>
                <span class="menu-item2">Services</span>
            </a>
            <?php if ($is_home): ?>
            <?php $menu = $this->settings_model->services_by('menu_order'); $first = isset($menu[0]) ? $menu[0] : NULL; ?>
            <ul class="mega-sub-menu girzock-mega">
                <li class="mega-menu-column">
                    <?php foreach (array_chunk($menu, max(5, (int) ceil(count($menu) / 2))) as $column): ?>
                    <ul>
                        <?php foreach ($column as $service): ?>
                        <li><a href="<?= site_url('services/'.$service['slug']) ?>" class="girzock-mega-link" data-img="<?= e(media_url($service['menu_image'])) ?>" data-desc="<?= e($service['menu_description']) ?>"><?= e($service['menu_title'] ? $service['menu_title'] : $service['title']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endforeach; ?>
                </li>
                <?php if ($first): ?>
                <li class="mega-menu-column girzock-mega-side">
                    <a href="<?= site_url('services/'.$first['slug']) ?>" class="girzock-mega-preview">
                        <span class="girzock-mega-images"><img src="<?= e(media_url($first['menu_image'])) ?>" alt="" class="is-current" loading="lazy" width="406" height="190"><img src="<?= e(media_url($first['menu_image'])) ?>" alt="" loading="lazy" width="406" height="190"></span>
                        <span class="girzock-mega-title"><?= e($first['menu_title'] ? $first['menu_title'] : $first['title']) ?></span>
                        <span class="girzock-mega-desc"><?= e($first['menu_description']) ?></span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <?php else: ?>
            <ul class="sub-menu">
                <?php foreach ($this->settings_model->services_by('footer_order') as $service): ?>
                <li><a href="<?= site_url('services/'.$service['slug']) ?>"><?= e($service['footer_title'] ? $service['footer_title'] : $service['title']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php foreach ($top as $section => $label): ?>
        <li class="girzock-no-sub">
            <a<?= $active($section) ?> href="<?= site_url($section) ?>">
                <span class="menu-item"><?= $label ?></span>
                <span class="menu-item2"><?= $label ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>

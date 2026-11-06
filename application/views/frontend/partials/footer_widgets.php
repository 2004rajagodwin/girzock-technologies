<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Footer columns shared by both footers. The homepage uses div headings, inner pages h4, as on the original site. */
$heading = function ($text) use ($is_home) {
	return $is_home ? '<div class="widget-title">'.$text.'</div>' : '<h4 class="widget-title">'.$text.'</h4>';
};
$email = setting('contact_email');
$website = setting('website_url');
$instagram = $this->settings_model->social_url('instagram');
$instagram_handle = $instagram ? trim(parse_url($instagram, PHP_URL_PATH), '/') : '';
?>
<div class="row">
    <div class="col-lg-4">
        <div class="about-widget v2 footer-widget">
            <div class="footer-logo">
                <a href="<?= site_url() ?>"><img src="<?= e(media_url(setting('logo_white'))) ?>" width="640" height="199" loading="lazy" decoding="async" alt="<?= e(setting('company_name')) ?> logo"></a>
            </div>
            <p class="girzock-footer-intro"><?= e(setting('footer_description')) ?></p>
            <?php $this->load->view('frontend/partials/social_icons'); ?>
            <div class="title">GIRZOCK</div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="footer-menu v2">
            <div class="contact-widget footer-widget">
                <?= $heading('Contacts') ?>
                <p><?= str_replace("\n", ' <br>', e(setting('business_address'))) ?></p>
                <a href="mailto:<?= e($email) ?>" class="gmail"><?= e($email) ?></a>
                <?php if ($instagram): ?><a href="<?= e($instagram) ?>" target="_blank" rel="noopener" class="girzock-footer-link">@<?= e($instagram_handle) ?></a><?php endif; ?>
                <a href="<?= e($website) ?>" class="girzock-footer-link"><?= e(preg_replace('#^https?://#', '', rtrim($website, '/'))) ?></a>
            </div>
            <div class="footer-links footer-widget">
                <?= $heading('Company') ?>
                <ul>
                    <li><a href="<?= site_url('about') ?>">About</a></li>
                    <li><a href="<?= site_url('products') ?>">Products</a></li>
                    <li><a href="<?= site_url('case-studies') ?>">Case Studies</a></li>
                    <li><a href="<?= site_url('portfolio') ?>">Portfolio</a></li>
                    <li><a href="<?= site_url('careers') ?>">Careers</a></li>
                    <li><a href="<?= site_url('blog') ?>">Blog</a></li>
                    <li><a href="<?= site_url('contact') ?>">Contact</a></li>
                    <li><a href="<?= site_url('areas-we-serve') ?>">Areas We Serve</a></li>
                </ul>
            </div>
            <div class="footer-links footer-widget m-0">
                <?= $heading('Services') ?>
                <ul>
                    <?php foreach (array_slice($this->settings_model->services_by('footer_order'), 0, 9) as $service): ?>
                    <li><a href="<?= site_url('services/'.$service['slug']) ?>"><?= e($service['footer_title'] ? $service['footer_title'] : $service['title']) ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="<?= site_url('services') ?>">All Services</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

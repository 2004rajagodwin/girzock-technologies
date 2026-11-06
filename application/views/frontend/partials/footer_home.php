<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- footer-style2 -->
<footer class="footer-style2">
    <div class="widget-area2">
        <div class="container">
            <?php $this->load->view('frontend/partials/footer_widgets', array('is_home' => TRUE)); ?>
        </div>
    </div>
    <div class="footer-botom">
        <div class="container">
            <div class="footer-box">
                <p><a href="<?= site_url() ?>">©<?= e(setting('company_name')) ?></a> <?= date('Y') ?>. All rights reserved.</p>
                <span><?= e(setting('tagline')) ?></span>
            </div>
        </div>
    </div>
</footer>
<!-- footer-style2 -->

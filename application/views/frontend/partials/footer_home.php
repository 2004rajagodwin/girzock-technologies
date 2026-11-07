<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* The site footer, used unchanged on every public page. Inner pages load it through footer_inner.php. */
?>
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
                <p>&copy; <?= e(setting('company_name')) ?> <?= date('Y') ?>. All rights reserved. <span class="gz-legal-links"><a href="<?= site_url('privacy-policy') ?>">Privacy</a> | <a href="<?= site_url('terms') ?>">Terms</a> | <a href="<?= site_url('cookie-policy') ?>">Cookies</a></span></p>
                <span><?= e(setting('tagline', 'Technology. Growth. Elevate.')) ?></span>
            </div>
        </div>
    </div>
</footer>
<!-- footer-style2 -->
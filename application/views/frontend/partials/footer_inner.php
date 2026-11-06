<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
        <!-- footer-style1 -->
        <footer class="footer-style1<?= empty($footer_gap_top) ? '' : ' ibt-section-gapTop' ?>">
            <div class="footer-top">
                <div class="container">
                    <div class="footer-content">
                        <h2 class="title">Develop. Expand. Transform.<br>Start with GIRZOCK</h2>
                        <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                            <span>Get a Quote</span>
                            <i class="icon-arrow-top"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-area ibt-section-gapTop">
                <div class="container">
                    <?php $this->load->view('frontend/partials/footer_widgets', array('is_home' => FALSE)); ?>
                </div>
            </div>
            <div class="footer-botom">
                <div class="container">
                    <div class="footer-box">
                        <p><a href="<?= site_url() ?>">©<?= e(setting('company_name')) ?></a> <?= date('Y') ?>. All rights reserved.</p>
                        <span>Develop. Expand. Transform.</span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer-style1 -->
    </section>
    <!-- End main-sec -->

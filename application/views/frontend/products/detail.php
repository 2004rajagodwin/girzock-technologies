<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Platforms', 'heading' => $product['title'], 'crumbs' => array('Products' => 'products', $product['title'] => NULL))); ?>

<section class="project-single ibt-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-5">
                <div class="project-img7">
                    <img src="<?= e(media_url($product['image'])) ?>" alt="<?= e($product['title']) ?>">
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="project-content7">
                    <div class="sec-title mb-0">
                        <?php if ($product['category_name']): ?><span class="sub-title"><?= e($product['category_name']) ?></span><?php endif; ?>
                        <h2 class="title animated-heading"><?= e($product['title']) ?></h2>
                        <p><?= e($product['short_description']) ?></p>
                    </div>
                    <?php if ($product['description']): ?><div class="gz-rich-text"><?= rich_text($product['description']) ?></div><?php endif; ?>
                    <?php if (text_lines($product['features'])): ?>
                    <ul class="ser-detail-list">
                        <?php foreach (text_lines($product['features']) as $line): ?>
                        <li><i class="fontello icon-button-arrow-down"></i><?= e($line) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <div class="girzock-btn-group">
                        <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline">
                            <span>Enquire about this product</span>
                            <i class="icon-arrow-top"></i>
                        </a>
                        <?php if ($product['external_url']): ?>
                        <a href="<?= e($product['external_url']) ?>" class="ibt-btn ibt-btn-outline" target="_blank" rel="noopener noreferrer">
                            <span>Visit product site</span>
                            <i class="icon-arrow-top"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

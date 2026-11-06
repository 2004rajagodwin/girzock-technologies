<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($products as $i => $product):
	$link = site_url('products/'.$product['slug']); ?>
<div class="col-xl-4 col-lg-6 col-md-6" id="product-<?= $i + 1 ?>">
    <div class="shop-card">
        <div class="shop-img">
            <a href="<?= $link ?>"><img src="<?= e(media_url($product['image'])) ?>" loading="lazy" decoding="async" alt="<?= e($product['title']) ?>"></a>
            <div class="shop-shap"></div>
        </div>
        <div class="shop-content">
            <a href="<?= $link ?>" class="show-now" aria-label="View <?= e($product['title']) ?>"><i class="fa fa-arrow-right"></i></a>
            <h3 class="title h4"><a href="<?= $link ?>"><?= e($product['title']) ?></a></h3>
            <span class="price">/ <?= e($product['category_name']) ?> /</span>
            <p class="girzock-product-text"><?= e($product['short_description']) ?></p>
        </div>
    </div>
</div>
<?php endforeach; ?>

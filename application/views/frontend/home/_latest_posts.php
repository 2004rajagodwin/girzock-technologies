<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($latest_posts as $post):
	$link = site_url('blog/'.$post['slug']); ?>
<div class="col-lg-4 col-md-6">
    <div class="blog-card">
        <div class="blog-img">
            <a href="<?= $link ?>" aria-label="<?= e($post['title']) ?>"><img src="<?= e(media_url($post['featured_image'])) ?>"<?= media_srcset($post['featured_image'], '(max-width: 767px) 92vw, 420px') ?> width="420" height="314" loading="lazy" decoding="async" alt="<?= e($post['featured_image_alt'] ? $post['featured_image_alt'] : $post['title']) ?>"></a>
            <span class="blog-meta"><?= e($post['category_name']) ?></span>
        </div>
        <div class="blog-content">
            <?php if ( ! empty($post['published_at'])): ?><time class="gz-card-date" datetime="<?= e(date('Y-m-d', strtotime($post['published_at']))) ?>"><?= e(date('j F Y', strtotime($post['published_at']))) ?></time><?php endif; ?>
            <h3 class="title h4"><a href="<?= $link ?>"><?= e($post['title']) ?></a></h3>
            <p><?= e($post['excerpt']) ?></p>
            <a class='ser-btn3' href="<?= $link ?>" aria-label="Read the article: <?= e($post['title']) ?>">Read the Article</a>
        </div>
    </div>
</div>
<?php endforeach; ?>

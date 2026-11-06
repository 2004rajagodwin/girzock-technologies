<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($latest_posts as $post):
	$link = site_url('blog/'.$post['slug']); ?>
<div class="col-lg-4 col-md-6">
    <div class="blog-card">
        <div class="blog-img">
            <a href="<?= $link ?>" aria-label="<?= e($post['title']) ?>"><img src="<?= e(media_url($post['featured_image'])) ?>" width="420" height="314" loading="lazy" decoding="async" alt="<?= e($post['title']) ?>"></a>
            <span class="blog-meta"><?= e($post['category_name']) ?></span>
        </div>
        <div class="blog-content">
            <h3 class="title h4"><a href="<?= $link ?>"><?= e($post['title']) ?></a></h3>
            <p><?= e($post['excerpt']) ?></p>
            <a class='ser-btn3' href="<?= $link ?>" aria-label="Read the article: <?= e($post['title']) ?>">Read the Article</a>
        </div>
    </div>
</div>
<?php endforeach; ?>

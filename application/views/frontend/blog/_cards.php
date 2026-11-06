<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ( ! $posts): ?>
<div class="col-12"><p class="gz-empty">No articles found<?= $search !== '' ? ' for &ldquo;'.e($search).'&rdquo;' : '' ?>. <a href="<?= site_url('blog') ?>">View all articles</a>.</p></div>
<?php endif; ?>
<?php $last = count($posts) - 1; foreach ($posts as $i => $post):
	$link = site_url('blog/'.$post['slug']); ?>
<div class="col-lg-4 col-md-6">
    <div class="blog-card<?= $i === $last ? ' mb-0' : '' ?>">
        <div class="blog-img">
            <a href="<?= $link ?>"><img src="<?= e(media_url($post['featured_image'])) ?>" alt="<?= e($post['title']) ?>" loading="lazy"></a>
            <span class="blog-meta"><?= e(strtoupper(date('M', strtotime($post['published_at'])))) ?>. <?= date('Y', strtotime($post['published_at'])) ?> / <?= e($post['author_name']) ?></span>
        </div>
        <div class="blog-content">
            <h2 class="title h4"><a href="<?= $link ?>"><?= e($post['title']) ?></a></h2>
            <span>/ <?= e(implode(' / ', $post['tag_names'])) ?> /</span>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php if ( ! empty($pagination)): ?>
<div class="col-12"><nav class="gz-pagination" aria-label="Blog pages"><?= $pagination ?></nav></div>
<?php endif; ?>

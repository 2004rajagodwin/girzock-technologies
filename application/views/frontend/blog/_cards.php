<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ( ! $posts): ?>
<div class="col-12"><p class="gz-empty">No articles found<?= $search !== '' ? ' for &ldquo;'.e($search).'&rdquo;' : '' ?>. <a href="<?= site_url('blog') ?>">View all articles</a>.</p></div>
<?php endif; ?>
<?php foreach ($posts as $i => $post):
	$link = site_url('blog/'.$post['slug']);
	$alt = $post['featured_image_alt'] ? $post['featured_image_alt'] : $post['title'];
	$date = date('j F Y', strtotime($post['published_at']));
	if ($i === 0 && ! empty($show_featured)): ?>
<div class="col-12">
    <article class="gz-feature-post">
        <a href="<?= $link ?>" class="gz-feature-img" tabindex="-1" aria-hidden="true"><img src="<?= e(media_url($post['featured_image'])) ?>"<?= media_srcset($post['featured_image'], '(max-width: 991px) 92vw, 680px') ?> width="1200" height="900" alt="<?= e($alt) ?>"></a>
        <div class="gz-feature-body">
            <span class="gz-feature-flag">Featured article</span>
            <div class="gz-post-meta"><?php if ($post['category_name']): ?><span class="gz-show-cat"><?= e($post['category_name']) ?></span><?php endif; ?><time datetime="<?= date('Y-m-d', strtotime($post['published_at'])) ?>"><?= e($date) ?></time></div>
            <h2 class="title"><a href="<?= $link ?>"><?= e($post['title']) ?></a></h2>
            <p><?= e($post['excerpt']) ?></p>
            <a class="gz-show-link" href="<?= $link ?>">Read Article<span aria-hidden="true"> &rarr;</span></a>
        </div>
    </article>
</div>
<?php continue; endif; ?>
<div class="col-lg-4 col-md-6">
    <article class="gz-show-card">
        <a href="<?= $link ?>" class="gz-show-img" tabindex="-1" aria-hidden="true"><img src="<?= e(media_url($post['featured_image'])) ?>"<?= media_srcset($post['featured_image'], '(max-width: 767px) 92vw, 420px') ?> width="1200" height="900" alt="<?= e($alt) ?>" loading="lazy" decoding="async"></a>
        <div class="gz-show-body">
            <div class="gz-post-meta"><?php if ($post['category_name']): ?><span class="gz-show-cat"><?= e($post['category_name']) ?></span><?php endif; ?><time datetime="<?= date('Y-m-d', strtotime($post['published_at'])) ?>"><?= e($date) ?></time></div>
            <h2 class="title h4"><a href="<?= $link ?>"><?= e($post['title']) ?></a></h2>
            <p><?= e($post['excerpt']) ?></p>
            <a class="gz-show-link" href="<?= $link ?>">Read Article<span aria-hidden="true"> &rarr;</span></a>
        </div>
    </article>
</div>
<?php endforeach; ?>
<?php if ( ! empty($pagination)): ?>
<div class="col-12"><nav class="gz-pagination" aria-label="Blog pages"><?= $pagination ?></nav></div>
<?php endif; ?>

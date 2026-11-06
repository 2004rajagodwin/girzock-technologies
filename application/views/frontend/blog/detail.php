<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Articles', 'heading' => $post['title'], 'crumbs' => array('Blog' => 'blog', $post['title'] => NULL))); ?>

<?php
$encoded_url = rawurlencode($share_url);
$encoded_title = rawurlencode($post['title']);
?>
<!-- article: same layout as the articles on the original blog page -->
<section class="process-sec ibt-section-gap girzock-article">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="process-title">
                    <?php if ($post['category_name']): ?>
                    <h2 class="title h3"><a href="<?= site_url('blog/category/'.$post['category_slug']) ?>" class="gz-inherit-link"><?= e($post['category_name']) ?></a></h2>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-9">
                <article class="process-detail">
                    <?php if ($post['featured_image']): ?><img class="gz-article-image" src="<?= e(media_url($post['featured_image'])) ?>" width="870" height="500" alt="<?= e($post['title']) ?>"><?php endif; ?>
                    <p class="gz-article-meta">
                        <time datetime="<?= date('Y-m-d', strtotime($post['published_at'])) ?>"><?= date('j F Y', strtotime($post['published_at'])) ?></time>
                        / <?= e($post['author_name']) ?> / <?= (int) $post['reading_time'] ?> min read
                    </p>
                    <div class="gz-rich-text"><?= rich_text($post['content']) ?></div>
                    <?php if ($post['tags']): ?>
                    <ul class="tag-list gz-article-tags">
                        <?php foreach ($post['tags'] as $tag): ?>
                        <li><a href="<?= site_url('blog/tag/'.$tag['slug']) ?>">/ <?= e($tag['name']) ?> /</a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <div class="gz-share">
                        <span>Share this article</span>
                        <ul class="social-icon">
                            <li><a class="girzock-social" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>
                            <li><a class="girzock-social" href="https://www.facebook.com/sharer/sharer.php?u=<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                            <li><a class="girzock-social" href="https://wa.me/?text=<?= $encoded_title ?>%20<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </article>
            </div>
        </div>
        <?php if ($previous OR $next): ?>
        <nav class="gz-post-nav ibt-section-gapTop" aria-label="More articles">
            <?php if ($previous): ?>
            <a class="gz-post-nav-item" href="<?= site_url('blog/'.$previous['slug']) ?>">
                <img src="<?= e(media_url($previous['featured_image'])) ?>" alt="" loading="lazy" width="96" height="72">
                <span><small>Previous article</small><strong><?= e($previous['title']) ?></strong></span>
            </a>
            <?php endif; ?>
            <?php if ($next): ?>
            <a class="gz-post-nav-item gz-post-nav-next" href="<?= site_url('blog/'.$next['slug']) ?>">
                <img src="<?= e(media_url($next['featured_image'])) ?>" alt="" loading="lazy" width="96" height="72">
                <span><small>Next article</small><strong><?= e($next['title']) ?></strong></span>
            </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
    </div>
</section>
<!-- End article -->

<?php foreach (array(array('Related Articles', 'keep reading', $related), array('Latest Articles', 'latest', $latest)) as $group): if ( ! $group[2]) { continue; } ?>
<section class="blog-sec v2 ibt-section-gapBottom">
    <div class="container">
        <div class="sec-title">
            <span class="sub-title"><?= e($group[1]) ?></span>
            <h2 class="title animated-heading"><?= e($group[0]) ?></h2>
        </div>
        <div class="row">
            <?php foreach ($group[2] as $item): $link = site_url('blog/'.$item['slug']); ?>
            <div class="col-lg-4 col-md-6">
                <div class="blog-card">
                    <div class="blog-img">
                        <a href="<?= $link ?>"><img src="<?= e(media_url($item['featured_image'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy"></a>
                        <span class="blog-meta"><?= e($item['category_name']) ?></span>
                    </div>
                    <div class="blog-content">
                        <h3 class="title h4"><a href="<?= $link ?>"><?= e($item['title']) ?></a></h3>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

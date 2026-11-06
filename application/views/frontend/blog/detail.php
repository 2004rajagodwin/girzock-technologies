<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Articles', 'heading' => $post['title'], 'crumbs' => array('Blog' => 'blog', $post['title'] => NULL))); ?>

<?php
$encoded_url = rawurlencode($share_url);
$encoded_title = rawurlencode($post['title']);
?>
<!-- article and sidebar -->
<section class="gz-post ibt-section-gap girzock-article">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="gz-post-main">
                    <div class="gz-post-meta">
                        <?php if ($post['category_name']): ?><a class="gz-show-cat" href="<?= site_url('blog/category/'.$post['category_slug']) ?>"><?= e($post['category_name']) ?></a><?php endif; ?>
                        <time datetime="<?= date('Y-m-d', strtotime($post['published_at'])) ?>"><?= date('j F Y', strtotime($post['published_at'])) ?></time>
                        <span><?= e($post['author_name']) ?></span>
                        <span><?= (int) $post['reading_time'] ?> min read</span>
                    </div>
                    <?php if ($post['featured_image']): ?><img class="gz-article-image" src="<?= e(media_url($post['featured_image'])) ?>"<?= media_srcset($post['featured_image'], '(max-width: 991px) 92vw, 860px') ?> width="1200" height="900" alt="<?= e($post['featured_image_alt'] ? $post['featured_image_alt'] : $post['title']) ?>"><?php endif; ?>
                    <div class="gz-rich-text gz-post-text"><?= rich_text($post['content']) ?></div>
                    <div class="gz-share">
                        <span>Share this article</span>
                        <ul class="social-icon">
                            <li><a class="girzock-social" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a class="girzock-social" href="https://www.facebook.com/sharer/sharer.php?u=<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="girzock-social" href="https://wa.me/?text=<?= $encoded_title ?>%20<?= $encoded_url ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a></li>
                        </ul>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <aside class="gz-sidebar" aria-label="More from the blog">
                    <form class="gz-side-search" action="<?= site_url('blog') ?>" method="get" role="search">
                        <label class="visually-hidden" for="gz-side-q">Search articles</label>
                        <input id="gz-side-q" type="search" name="q" maxlength="100" placeholder="Search articles">
                        <button type="submit" aria-label="Search"><i class="fa fa-search"></i></button>
                    </form>
                    <?php if ( ! empty($categories)): ?>
                    <div class="gz-side-box">
                        <h3 class="gz-side-title">Categories</h3>
                        <ul class="gz-side-cats">
                            <?php foreach ($categories as $category): ?><li><a href="<?= site_url('blog/category/'.$category['slug']) ?>"><?= e($category['name']) ?></a></li><?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if ($latest): ?>
                    <div class="gz-side-box">
                        <h3 class="gz-side-title">Recent Posts</h3>
                        <ul class="gz-side-posts">
                            <?php foreach ($latest as $item): $item_link = site_url('blog/'.$item['slug']); ?>
                            <li>
                                <a href="<?= $item_link ?>" tabindex="-1" aria-hidden="true"><img src="<?= e(media_url($item['featured_image'])) ?>"<?= media_srcset($item['featured_image'], '84px') ?> width="84" height="63" loading="lazy" decoding="async" alt=""></a>
                                <div>
                                    <time datetime="<?= date('Y-m-d', strtotime($item['published_at'])) ?>"><?= date('j M Y', strtotime($item['published_at'])) ?></time>
                                    <a href="<?= $item_link ?>"><?= e($item['title']) ?></a>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if ($post['tags']): ?>
                    <div class="gz-side-box">
                        <h3 class="gz-side-title">Tags</h3>
                        <ul class="gz-side-tags">
                            <?php foreach ($post['tags'] as $tag): ?><li><a href="<?= site_url('blog/tag/'.$tag['slug']) ?>"><?= e($tag['name']) ?></a></li><?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="gz-side-cta">
                        <h3 class="gz-side-title">Have a project in mind?</h3>
                        <p>Tell GIRZOCK Technologies what you need, and we will suggest clear next steps.</p>
                        <a href="<?= site_url('contact') ?>" class="ibt-btn ibt-btn-outline"><span>Contact Us</span><i class="icon-arrow-top"></i></a>
                    </div>
                </aside>
            </div>
        </div>
        <?php if ($previous OR $next): ?>
        <nav class="gz-post-nav ibt-section-gapTop" aria-label="More articles">
            <?php if ($previous): ?>
            <a class="gz-post-nav-item" href="<?= site_url('blog/'.$previous['slug']) ?>">
                <img src="<?= e(media_url($previous['featured_image'])) ?>"<?= media_srcset($previous['featured_image'], '96px') ?> alt="" loading="lazy" width="96" height="72">
                <span><small>Previous article</small><strong><?= e($previous['title']) ?></strong></span>
            </a>
            <?php endif; ?>
            <?php if ($next): ?>
            <a class="gz-post-nav-item gz-post-nav-next" href="<?= site_url('blog/'.$next['slug']) ?>">
                <img src="<?= e(media_url($next['featured_image'])) ?>"<?= media_srcset($next['featured_image'], '96px') ?> alt="" loading="lazy" width="96" height="72">
                <span><small>Next article</small><strong><?= e($next['title']) ?></strong></span>
            </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
    </div>
</section>
<!-- End article -->

<?php foreach (array(array('Related Articles', 'keep reading', $related)) as $group): if ( ! $group[2]) { continue; } ?>
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
                        <a href="<?= $link ?>"><img src="<?= e(media_url($item['featured_image'])) ?>"<?= media_srcset($item['featured_image'], '(max-width: 767px) 92vw, 420px') ?> width="1200" height="900" alt="<?= e($item['featured_image_alt'] ? $item['featured_image_alt'] : $item['title']) ?>" loading="lazy"></a>
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

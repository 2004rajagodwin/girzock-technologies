<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar">
    <form class="gz-filters" method="get" action="<?= site_url('admin/media') ?>">
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search files..." aria-label="Search files">
        <button class="gz-btn gz-btn-ghost" type="submit">Search</button>
    </form>
    <?php if ($can_create): ?>
    <form class="gz-filters" action="<?= site_url('admin/media/upload') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="file" name="files[]" multiple accept=".jpg,.jpeg,.png,.webp,.gif" aria-label="Choose images" required>
        <button class="gz-btn" type="submit">Upload</button>
    </form>
    <?php endif; ?>
</div>
<p class="gz-muted">JPG, PNG, WebP or GIF, up to 5 MB each. JPG and PNG files are converted to WebP automatically.</p>
<?php if ( ! $rows): ?><div class="gz-card"><p class="gz-muted">No uploaded files yet. Images that shipped with the website stay in the assets folder and are not listed here.</p></div><?php endif; ?>
<div class="gz-media-grid">
    <?php foreach ($rows as $row): ?>
    <div class="gz-card gz-media-item">
        <img src="<?= e(media_url($row['file_path'])) ?>" alt="<?= e($row['alt_text']) ?>" loading="lazy">
        <p class="gz-media-name" title="<?= e($row['original_name']) ?>"><?= e($row['original_name']) ?></p>
        <small class="gz-muted"><?= (int) $row['width'] ?>&times;<?= (int) $row['height'] ?> &middot; <?= number_format($row['file_size'] / 1024) ?> KB</small>
        <input class="gz-copy" type="text" value="<?= e($row['file_path']) ?>" readonly aria-label="File path">
        <?php if ($can_edit): ?><input type="text" value="<?= e($row['alt_text']) ?>" placeholder="Alt text" aria-label="Alt text" maxlength="255" data-gz-alt="<?= site_url('admin/media/update/'.(int) $row['id']) ?>"><?php endif; ?>
        <?php if ($can_delete): ?>
        <form action="<?= site_url('admin/media/delete/'.(int) $row['id']) ?>" method="post" data-gz-confirm="Delete this file?"><?= csrf_field() ?><button class="gz-btn gz-btn-danger gz-btn-sm" type="submit">Delete</button></form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?= $pagination ?>

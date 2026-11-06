<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$v = function ($key) use ($seo) { return isset($seo[$key]) ? e($seo[$key]) : ''; };
$robots = isset($seo['robots']) ? $seo['robots'] : '';
?>
<div class="gz-toolbar"><a class="gz-link" href="<?= site_url('admin/seo') ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to SEO</a></div>
<?php if ($error): ?><div class="gz-flash gz-flash-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form class="gz-card gz-form gz-narrow" action="<?= site_url('admin/seo/page/'.$key) ?>" method="post">
    <?= csrf_field() ?>
    <label for="meta_title">SEO title</label>
    <input id="meta_title" type="text" name="meta_title" value="<?= $v('meta_title') ?>" maxlength="255">
    <label for="meta_description">Meta description</label>
    <textarea id="meta_description" name="meta_description" rows="4" maxlength="500"><?= $v('meta_description') ?></textarea>
    <label for="focus_keyword">Focus keyword (for your planning, not published)</label>
    <input id="focus_keyword" type="text" name="focus_keyword" value="<?= $v('focus_keyword') ?>" maxlength="120">
    <label for="og_title">Open Graph title (optional)</label>
    <input id="og_title" type="text" name="og_title" value="<?= $v('og_title') ?>" maxlength="255">
    <label for="og_description">Open Graph description (optional)</label>
    <textarea id="og_description" name="og_description" rows="3" maxlength="500"><?= $v('og_description') ?></textarea>
    <label for="canonical_url">Canonical URL (optional)</label>
    <input id="canonical_url" type="url" name="canonical_url" value="<?= $v('canonical_url') ?>" placeholder="https://">
    <label for="og_image">Social image path (optional)</label>
    <input id="og_image" type="text" name="og_image" value="<?= $v('og_image') ?>" placeholder="assets/uploads/...">
    <label for="robots">Search engine indexing</label>
    <select id="robots" name="robots">
        <?php foreach (array('' => 'Default (index, follow)', 'index, follow' => 'index, follow', 'noindex, follow' => 'noindex, follow', 'noindex, nofollow' => 'noindex, nofollow') as $option => $label): ?>
        <option value="<?= e($option) ?>"<?= $robots === $option ? ' selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="gz-btn" type="submit">Save</button>
</form>

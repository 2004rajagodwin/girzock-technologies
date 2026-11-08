<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$groups = array('main' => array(), 'side' => array(), 'display' => array());
foreach ($fields as $field)
{
	$groups[$field['group']][] = $field;
}
$field_view = function ($field) use ($values, $errors) {
	$this->load->view('admin/crud/_field', array('field' => $field, 'values' => $values, 'errors' => $errors));
};
?>
<?php if ($errors): ?><div class="gz-flash gz-flash-error" role="alert">Please correct the highlighted fields. Nothing has been saved yet.</div><?php endif; ?>
<div class="gz-toolbar">
    <a class="gz-link" href="<?= site_url('admin/'.$route) ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to <?= e($plural) ?></a>
    <?php if ($public_url): ?><a class="gz-link" href="<?= e($public_url) ?>?preview=1" target="_blank" rel="noopener">Preview page <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a><?php endif; ?>
</div>
<form action="<?= site_url('admin/'.$route.'/save'.($id ? '/'.(int) $id : '')) ?>" method="post" enctype="multipart/form-data" class="gz-form" novalidate data-gz-form>
    <?= csrf_field() ?>
    <div class="gz-form-grid">
        <div>
            <div class="gz-card">
                <?php foreach ($groups['main'] as $field) { $field_view($field); } ?>
            </div>
            <?php if ($groups['display']): ?>
            <details class="gz-card gz-details">
                <summary>Where this appears on the website</summary>
                <div class="gz-two-col"><?php foreach ($groups['display'] as $field) { $field_view($field); } ?></div>
            </details>
            <?php endif; ?>
            <?php if ($has_seo): ?>
            <details class="gz-card gz-details"<?= array_filter(array_keys($errors), function ($k) { return strpos($k, 'seo_') === 0; }) ? ' open' : '' ?>>
                <summary>SEO<?= $seo_warnings ? ' <span class="gz-badge gz-badge-warn">'.count($seo_warnings).' to check</span>' : '' ?></summary>
                <div class="gz-serp" data-gz-serp data-base="<?= e($preview_base) ?>" data-company="<?= e($company_name) ?>" aria-label="Search result preview">
                    <p class="gz-serp-label">Search result preview</p>
                    <p class="gz-serp-url" data-gz-serp-url></p>
                    <p class="gz-serp-title" data-gz-serp-title></p>
                    <p class="gz-serp-desc" data-gz-serp-desc></p>
                    <p class="gz-help" data-gz-serp-count></p>
                </div>
                <?php if ($seo_warnings): ?>
                <div class="gz-seo-warnings" role="note">
                    <p><strong>Worth checking before you publish</strong> (based on the saved version):</p>
                    <ul><?php foreach ($seo_warnings as $warning): ?><li><?= e($warning) ?></li><?php endforeach; ?></ul>
                </div>
                <?php elseif ($id): ?>
                <p class="gz-help gz-seo-ok">No SEO issues found in the saved version. This is a checklist, not a ranking promise.</p>
                <?php endif; ?>
                <?php
                $field_view(array('name' => 'seo_meta_title', 'label' => 'SEO title', 'type' => 'text', 'max' => 255, 'help' => 'Left blank, a title is built from the page name.'));
                $field_view(array('name' => 'seo_meta_description', 'label' => 'Meta description', 'type' => 'textarea', 'help' => 'Aim for 120 to 160 characters.'));
                $field_view(array('name' => 'seo_focus_keyword', 'label' => 'Focus keyword', 'type' => 'text', 'max' => 120, 'help' => 'For your own planning. It is not published on the page.'));
                $field_view(array('name' => 'seo_secondary_keywords', 'label' => 'Secondary keywords', 'type' => 'text', 'max' => 255, 'help' => 'Related phrases, separated by commas. For planning; not published.'));
                $field_view(array('name' => 'seo_og_title', 'label' => 'Open Graph title', 'type' => 'text', 'max' => 255, 'help' => 'Shown when the page is shared. Left blank, the SEO title is used.'));
                $field_view(array('name' => 'seo_og_description', 'label' => 'Open Graph description', 'type' => 'textarea', 'help' => 'Left blank, the meta description is used.'));
                $field_view(array('name' => 'seo_canonical_url', 'label' => 'Canonical URL', 'type' => 'url', 'help' => 'Leave empty to use the address of this page. Only needed when the main copy of this content is at another address on this website. Noindex pages always use their own address.'));
                if ($preview_base !== ''): ?>
                <p class="gz-help" data-gz-canonical-auto>Automatic canonical: <strong data-gz-canonical-auto-url><?= e($preview_base.(isset($values['slug']) ? $values['slug'] : '')) ?></strong></p>
                <?php endif;
                $field_view(array('name' => 'seo_robots', 'label' => 'Search engine indexing', 'type' => 'select', 'options' => array('' => 'Default (index, follow)', 'index, follow' => 'index, follow', 'noindex, follow' => 'noindex, follow', 'noindex, nofollow' => 'noindex, nofollow')));
                $field_view(array('name' => 'seo_og_image', 'label' => 'Social sharing image', 'type' => 'image', 'brand' => TRUE, 'help' => 'JPG, PNG, WebP or GIF. About 1200 x 630 px suits Facebook, LinkedIn and X. Leave unchanged to keep the current image.'));
                ?>
            </details>
            <?php endif; ?>
        </div>
        <div>
            <div class="gz-card gz-sticky">
                <?php if ($has_slug): ?>
                <div class="gz-field<?= isset($errors['slug']) ? ' has-error' : '' ?>">
                    <label for="f-slug">URL slug</label>
                    <input id="f-slug" type="text" name="slug" value="<?= e(isset($values['slug']) ? $values['slug'] : '') ?>" maxlength="170" placeholder="Created from the title">
                    <p class="gz-help">If you change it, the old address redirects here automatically.</p>
                </div>
                <?php endif; ?>
                <?php foreach ($groups['side'] as $field) { $field_view($field); } ?>
                <button class="gz-btn gz-btn-block" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
<?php $this->load->view('admin/crud/_picker'); ?>

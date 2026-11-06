<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-card gz-table-wrap">
    <h2>Main pages</h2>
    <table class="gz-table">
        <thead><tr><th scope="col">Page</th><th scope="col">SEO title</th><th scope="col">Meta description</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($pages as $key => $page): ?>
        <tr>
            <td data-label="Page"><?= e($page['label']) ?></td>
            <td data-label="SEO title"><?= e(isset($page['seo']['meta_title']) ? $page['seo']['meta_title'] : '') ?></td>
            <td data-label="Description"><?= e(isset($page['seo']['meta_description']) ? plain_excerpt($page['seo']['meta_description'], 90) : '') ?></td>
            <td class="gz-right"><?php if ($can_edit): ?><a class="gz-btn gz-btn-ghost gz-btn-sm" href="<?= site_url('admin/seo/page/'.$key) ?>">Edit</a><?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php foreach ($content as $group): ?>
<details class="gz-card gz-details">
    <summary><?= e($group['label']) ?> (<?= count($group['rows']) ?>)</summary>
    <div class="gz-table-wrap">
        <table class="gz-table">
            <thead><tr><th scope="col">Item</th><th scope="col">Custom SEO title</th><th scope="col">Custom description</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($group['rows'] as $row): ?>
            <tr>
                <td data-label="Item"><?= e($row['title']) ?></td>
                <td data-label="SEO title"><?= $row['meta_title'] ? e($row['meta_title']) : '<span class="gz-muted">Automatic</span>' ?></td>
                <td data-label="Description"><?= $row['meta_description'] ? e(plain_excerpt($row['meta_description'], 70)) : '<span class="gz-muted">Automatic</span>' ?></td>
                <td class="gz-right"><a class="gz-btn gz-btn-ghost gz-btn-sm" href="<?= site_url('admin/'.$group['route'].'/edit/'.(int) $row['id']) ?>">Edit</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</details>
<?php endforeach; ?>

<div class="gz-card gz-table-wrap" id="redirects">
    <h2>Redirects</h2>
    <p class="gz-muted">Changing a URL slug adds a redirect automatically. Deleted content answers 410 Gone. You can also add your own here.</p>
    <?php if ($can_edit): ?>
    <form class="gz-inline-form" action="<?= site_url('admin/seo/redirect_save') ?>" method="post">
        <?= csrf_field() ?>
        <input type="text" name="old_path" placeholder="old/path" aria-label="Old path" required>
        <input type="text" name="new_path" placeholder="new/path" aria-label="New path">
        <select name="status_code" aria-label="Type"><option value="301">301 Moved</option><option value="410">410 Gone</option></select>
        <button class="gz-btn gz-btn-sm" type="submit">Add</button>
    </form>
    <?php endif; ?>
    <table class="gz-table">
        <thead><tr><th scope="col">From</th><th scope="col">To</th><th scope="col">Code</th><th></th></tr></thead>
        <tbody>
        <?php if ( ! $redirects): ?><tr><td colspan="4" class="gz-empty-row">No redirects.</td></tr><?php endif; ?>
        <?php foreach ($redirects as $row): ?>
        <tr>
            <td data-label="From">/<?= e($row['old_path']) ?></td>
            <td data-label="To"><?= $row['new_path'] !== NULL ? '/'.e($row['new_path']) : '-' ?></td>
            <td data-label="Code"><?= (int) $row['status_code'] ?></td>
            <td class="gz-right"><?php if ($can_edit): ?><form action="<?= site_url('admin/seo/redirect_delete/'.(int) $row['id']) ?>" method="post"><?= csrf_field() ?><button class="gz-btn gz-btn-danger gz-btn-sm" type="submit">Remove</button></form><?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

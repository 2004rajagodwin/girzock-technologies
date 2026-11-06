<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-panels">
    <?php foreach ($groups as $key => $group): ?>
    <div class="gz-card">
        <h2><?= e($group['label']) ?></h2>
        <?php if ($can_create): ?>
        <form class="gz-inline-form" action="<?= site_url('admin/categories/save/'.$key) ?>" method="post">
            <?= csrf_field() ?>
            <input type="text" name="name" placeholder="Add new..." aria-label="New name for <?= e($group['label']) ?>" maxlength="80" required>
            <?php if ($group['sortable']): ?><input class="gz-num" type="number" name="sort_order" value="0" aria-label="Display order"><?php endif; ?>
            <button class="gz-btn gz-btn-sm" type="submit">Add</button>
        </form>
        <?php endif; ?>
        <?php if ( ! $group['rows']): ?><p class="gz-muted">None yet.</p><?php endif; ?>
        <ul class="gz-cat-list">
            <?php foreach ($group['rows'] as $row): ?>
            <li>
                <form class="gz-inline-form" action="<?= site_url('admin/categories/save/'.$key.'/'.(int) $row['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="text" name="name" value="<?= e($row['name']) ?>" aria-label="Name" maxlength="80" required<?= $can_edit ? '' : ' readonly' ?>>
                    <?php if ($group['sortable']): ?><input class="gz-num" type="number" name="sort_order" value="<?= (int) $row['sort_order'] ?>" aria-label="Display order"<?= $can_edit ? '' : ' readonly' ?>><?php endif; ?>
                    <?php if ($can_edit): ?><button class="gz-btn gz-btn-ghost gz-btn-sm" type="submit">Save</button><?php endif; ?>
                </form>
                <?php if ($can_delete): ?>
                <form action="<?= site_url('admin/categories/delete/'.$key.'/'.(int) $row['id']) ?>" method="post" data-gz-confirm="Delete &quot;<?= e($row['name']) ?>&quot;? Items using it will stay published without it."><?= csrf_field() ?><button class="gz-btn gz-btn-danger gz-btn-sm" type="submit">Delete</button></form>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endforeach; ?>
</div>

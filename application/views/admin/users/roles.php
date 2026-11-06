<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar">
    <div class="gz-tabs">
        <?php foreach ($roles as $item): ?>
        <a href="<?= site_url('admin/users/roles/'.(int) $item['id']) ?>"<?= $role && (int) $item['id'] === (int) $role['id'] ? ' class="active" aria-current="page"' : '' ?>><?= e($item['name']) ?></a>
        <?php endforeach; ?>
    </div>
    <form class="gz-inline-form" action="<?= site_url('admin/users/role_create') ?>" method="post">
        <?= csrf_field() ?>
        <input type="text" name="name" placeholder="New role name" aria-label="New role name" maxlength="80" required>
        <button class="gz-btn gz-btn-sm" type="submit">Add role</button>
    </form>
</div>
<?php if ($role && $role['slug'] === 'super_admin'): ?>
<div class="gz-card"><p>The Super Admin role always has complete access to every module and cannot be restricted.</p></div>
<?php elseif ($role): ?>
<form class="gz-card gz-table-wrap" action="<?= site_url('admin/users/role_save/'.(int) $role['id']) ?>" method="post">
    <?= csrf_field() ?>
    <h2><?= e($role['name']) ?></h2>
    <table class="gz-table gz-matrix">
        <thead><tr><th scope="col">Module</th><th scope="col">View</th><th scope="col">Create</th><th scope="col">Edit</th><th scope="col">Delete</th></tr></thead>
        <tbody>
        <?php foreach ($modules as $module => $label): $p = isset($permissions[$module]) ? $permissions[$module] : array(); ?>
        <tr>
            <th scope="row"><?= e($label) ?></th>
            <?php foreach (array('view', 'create', 'edit', 'delete') as $action): ?>
            <td data-label="<?= ucfirst($action) ?>"><input type="checkbox" name="permissions[<?= e($module) ?>][<?= $action ?>]" value="1" aria-label="<?= ucfirst($action) ?> <?= e($label) ?>"<?= empty($p['can_'.$action]) ? '' : ' checked' ?>></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button class="gz-btn" type="submit">Save permissions</button>
</form>
<?php endif; ?>

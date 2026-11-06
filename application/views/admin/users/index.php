<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar">
    <?php if ($is_super): ?><a class="gz-btn gz-btn-ghost" href="<?= site_url('admin/users/roles') ?>">Roles and permissions</a><?php else: ?><span></span><?php endif; ?>
    <?php if ($can_create): ?><a class="gz-btn" href="<?= site_url('admin/users/create') ?>"><i class="fa-solid fa-plus" aria-hidden="true"></i> Add User</a><?php endif; ?>
</div>
<div class="gz-card gz-table-wrap">
    <table class="gz-table">
        <thead><tr><th scope="col">Name</th><th scope="col">Username</th><th scope="col">Email</th><th scope="col">Role</th><th scope="col">Last login</th><th scope="col">Status</th><th scope="col" class="gz-right">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td data-label="Name"><?= e($row['full_name']) ?></td>
            <td data-label="Username"><?= e($row['username']) ?></td>
            <td data-label="Email"><?= e($row['email']) ?></td>
            <td data-label="Role"><?= e($row['role_name']) ?></td>
            <td data-label="Last login"><?= e(admin_date($row['last_login_at'])) ?></td>
            <td data-label="Status"><?= status_badge($row['status']) ?></td>
            <td class="gz-right gz-actions">
                <?php if ($can_edit && ($is_super OR $row['role_slug'] !== 'super_admin')): ?><a class="gz-btn gz-btn-ghost gz-btn-sm" href="<?= site_url('admin/users/edit/'.(int) $row['id']) ?>">Edit</a><?php endif; ?>
                <?php if ($can_delete && ($is_super OR $row['role_slug'] !== 'super_admin') && (int) $row['id'] !== (int) $admin['id']): ?>
                <form action="<?= site_url('admin/users/delete/'.(int) $row['id']) ?>" method="post" data-gz-confirm="Delete this user?"><?= csrf_field() ?><button class="gz-btn gz-btn-danger gz-btn-sm" type="submit">Delete</button></form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

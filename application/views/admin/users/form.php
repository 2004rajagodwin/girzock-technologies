<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$v = function ($key) use ($values) { return isset($values[$key]) ? e($values[$key]) : ''; };
$err = function ($key) use ($errors) { return isset($errors[$key]) ? '<p class="gz-error">'.e($errors[$key]).'</p>' : ''; };
?>
<div class="gz-toolbar"><a class="gz-link" href="<?= site_url('admin/users') ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to users</a></div>
<form class="gz-card gz-form gz-narrow" action="<?= site_url('admin/users/save'.($id ? '/'.(int) $id : '')) ?>" method="post" autocomplete="off">
    <?= csrf_field() ?>
    <label for="full_name">Full name</label>
    <input id="full_name" type="text" name="full_name" value="<?= $v('full_name') ?>" maxlength="120" required><?= $err('full_name') ?>
    <label for="username">Username</label>
    <input id="username" type="text" name="username" value="<?= $v('username') ?>" maxlength="60" required><?= $err('username') ?>
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="<?= $v('email') ?>" maxlength="190" required><?= $err('email') ?>
    <label for="role_id">Role</label>
    <select id="role_id" name="role_id" required>
        <?php foreach ($roles as $role): ?><option value="<?= (int) $role['id'] ?>"<?= isset($values['role_id']) && (int) $values['role_id'] === (int) $role['id'] ? ' selected' : '' ?>><?= e($role['name']) ?></option><?php endforeach; ?>
    </select><?= $err('role_id') ?>
    <label for="status">Status</label>
    <select id="status" name="status">
        <option value="active"<?= $v('status') === 'active' ? ' selected' : '' ?>>Active</option>
        <option value="disabled"<?= $v('status') === 'disabled' ? ' selected' : '' ?>>Disabled</option>
    </select>
    <label for="password"><?= $id ? 'Set a temporary password (optional)' : 'Temporary password' ?></label>
    <input id="password" type="password" name="password" autocomplete="new-password"<?= $id ? '' : ' required' ?>><?= $err('password') ?>
    <p class="gz-help">At least 12 characters, with a letter and a number. The user must replace it at next sign-in.</p>
    <button class="gz-btn" type="submit">Save</button>
</form>

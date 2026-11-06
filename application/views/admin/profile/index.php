<?php defined('BASEPATH') OR exit('No direct script access allowed');
$err = function ($key) use ($errors) { return isset($errors[$key]) ? '<p class="gz-error">'.e($errors[$key]).'</p>' : ''; }; ?>
<form class="gz-card gz-form gz-narrow" action="<?= site_url('admin/profile/save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label for="full_name">Full name</label>
    <input id="full_name" type="text" name="full_name" value="<?= e($admin['full_name']) ?>" maxlength="120" required><?= $err('full_name') ?>
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="<?= e($admin['email']) ?>" maxlength="190" required><?= $err('email') ?>
    <label for="username">Username</label>
    <input id="username" type="text" value="<?= e($admin['username']) ?>" readonly>
    <label for="avatar">Profile picture</label>
    <input id="avatar" type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp"><?= $err('avatar') ?>
    <button class="gz-btn" type="submit">Save</button>
    <p><a class="gz-link" href="<?= site_url('admin/profile/password') ?>">Change password</a></p>
</form>

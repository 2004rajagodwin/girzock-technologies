<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($forced): ?><div class="gz-flash gz-flash-error" role="status">You are using a one-time password. Please choose your own password to continue.</div><?php endif; ?>
<?php if ($error): ?><div class="gz-flash gz-flash-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form class="gz-card gz-form gz-narrow" action="<?= site_url('admin/profile/password') ?>" method="post">
    <?= csrf_field() ?>
    <label for="current_password">Current password</label>
    <input id="current_password" type="password" name="current_password" autocomplete="current-password" required>
    <label for="new_password">New password</label>
    <input id="new_password" type="password" name="new_password" autocomplete="new-password" minlength="12" required>
    <p class="gz-help">At least 12 characters, with a letter and a number.</p>
    <label for="new_password_confirm">Repeat new password</label>
    <input id="new_password_confirm" type="password" name="new_password_confirm" autocomplete="new-password" minlength="12" required>
    <button class="gz-btn" type="submit">Change password</button>
</form>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/auth/shell_top', array('title' => 'Choose a new password')); ?>
<?php if ( ! $valid): ?>
<div class="gz-flash gz-flash-error" role="alert">This reset link is invalid or has expired. Please request a new one.</div>
<p class="gz-auth-link"><a href="<?= site_url('admin/forgot-password') ?>">Request a new link</a></p>
<?php else: ?>
<?php if ($error): ?><div class="gz-flash gz-flash-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form action="<?= site_url('admin/reset-password/'.$token) ?>" method="post" class="gz-form">
    <?= csrf_field() ?>
    <label for="password">New password</label>
    <input id="password" type="password" name="password" autocomplete="new-password" minlength="12" required autofocus>
    <p class="gz-help">At least 12 characters, with a letter and a number.</p>
    <label for="password_confirm">Repeat new password</label>
    <input id="password_confirm" type="password" name="password_confirm" autocomplete="new-password" minlength="12" required>
    <button class="gz-btn gz-btn-block" type="submit">Change password</button>
</form>
<?php endif; ?>
</main></body></html>

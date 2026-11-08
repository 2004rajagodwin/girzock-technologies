<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/auth/shell_top', array('title' => 'Choose a new password')); ?>
<?php if ( ! $valid): ?>
<div class="gz-flash gz-flash-error" role="alert">This reset link is invalid or has expired. Please request a new one.</div>
<p class="gz-auth-link"><a href="<?= site_url('admin/forgot-password') ?>">Request a new link</a></p>
<?php else: ?>
<?php if ($error): ?><div class="gz-flash gz-flash-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form action="<?= site_url('admin/reset-password/'.$token) ?>" method="post" class="gz-auth-form" data-gz-auth-form>
    <?= csrf_field() ?>
    <label for="password">New password</label>
    <div class="gz-auth-input gz-auth-input-plain"><input id="password" type="password" name="password" autocomplete="new-password" minlength="12" required autofocus><?php $this->load->view('admin/auth/reveal', array('target' => 'password')); ?></div>
    <p class="gz-help">At least 12 characters, with a letter and a number.</p>
    <label for="password_confirm">Repeat new password</label>
    <div class="gz-auth-input gz-auth-input-plain"><input id="password_confirm" type="password" name="password_confirm" autocomplete="new-password" minlength="12" required><?php $this->load->view('admin/auth/reveal', array('target' => 'password_confirm')); ?></div>
    <button class="gz-auth-submit" type="submit" data-gz-submit><span class="gz-auth-spinner" aria-hidden="true"></span>Change password</button>
</form>
<?php endif; ?>
<?php $this->load->view('admin/auth/shell_bottom'); ?>

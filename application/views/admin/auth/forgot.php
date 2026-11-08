<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/auth/shell_top', array('title' => 'Reset your password')); ?>
<?php if ($sent): ?>
<div class="gz-flash gz-flash-success" role="status">If that account exists, a reset link has been sent to its email address. The link expires in one hour.</div>
<?php else: ?>
<form action="<?= site_url('admin/forgot-password') ?>" method="post" class="gz-auth-form" data-gz-auth-form>
    <?= csrf_field() ?>
    <label for="email">Username or email</label>
    <input id="email" type="text" name="email" autocomplete="username" required autofocus>
    <button class="gz-auth-submit" type="submit" data-gz-submit><span class="gz-auth-spinner" aria-hidden="true"></span>Send reset link</button>
</form>
<?php endif; ?>
<p class="gz-auth-link"><a href="<?= site_url('admin/login') ?>">Back to sign in</a></p>
<?php $this->load->view('admin/auth/shell_bottom'); ?>

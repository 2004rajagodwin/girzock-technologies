<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/auth/shell_top', array('title' => 'Admin sign in')); ?>
<?php if ($notice): ?><div class="gz-flash gz-flash-success" role="status"><?= e($notice) ?></div><?php endif; ?>
<?php if ($error): ?><div class="gz-flash gz-flash-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form action="<?= site_url('admin/login') ?>" method="post" class="gz-form">
    <?= csrf_field() ?>
    <label for="username">Username or email</label>
    <input id="username" type="text" name="username" value="<?= e($identifier) ?>" autocomplete="username" required autofocus>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" autocomplete="current-password" required>
    <button class="gz-btn gz-btn-block" type="submit">Sign in</button>
</form>
<p class="gz-auth-link"><a href="<?= site_url('admin/forgot-password') ?>">Forgot your password?</a></p>
</main></body></html>

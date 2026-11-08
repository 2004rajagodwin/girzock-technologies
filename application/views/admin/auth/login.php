<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Admin sign in. The "Forgot your password?" link is not shown here, to keep the card clean.
 * Password recovery still works for administrators at /admin/forgot-password (see Auth::forgot).
 */
?>
<?php $this->load->view('admin/auth/shell_top', array('title' => 'Sign in to your account')); ?>
<p class="gz-auth-sub">Welcome back. Use your admin username or email.</p>
<?php if ($notice): ?><div class="gz-flash gz-flash-success" role="status"><?= e($notice) ?></div><?php endif; ?>
<?php if ($error): ?><div class="gz-flash gz-flash-error" role="alert" id="gz-login-error"><?= e($error) ?></div><?php endif; ?>
<form action="<?= site_url('admin/login') ?>" method="post" class="gz-auth-form" data-gz-auth-form novalidate>
    <?= csrf_field() ?>
    <div class="gz-auth-field">
        <label for="username">Username or email</label>
        <div class="gz-auth-input">
            <svg class="gz-auth-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 12a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z"/></svg>
            <input id="username" type="text" name="username" value="<?= e($identifier) ?>" autocomplete="username" autocapitalize="none" spellcheck="false" maxlength="190" required<?= $identifier === '' ? ' autofocus' : '' ?> aria-describedby="username-error"<?= $error ? ' aria-invalid="true"' : '' ?>>
        </div>
        <p class="gz-auth-error" id="username-error" hidden>Enter your username or email.</p>
    </div>
    <div class="gz-auth-field">
        <label for="password">Password</label>
        <div class="gz-auth-input">
            <svg class="gz-auth-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M17 9V7A5 5 0 0 0 7 7v2H5v13h14V9h-2ZM9 7a3 3 0 0 1 6 0v2H9V7Zm4 9.7V19h-2v-2.3a2 2 0 1 1 2 0Z"/></svg>
            <input id="password" type="password" name="password" autocomplete="current-password" maxlength="200" required<?= $identifier !== '' ? ' autofocus' : '' ?> aria-describedby="password-error"<?= $error ? ' aria-invalid="true"' : '' ?>>
            <?php $this->load->view('admin/auth/reveal', array('target' => 'password')); ?>
        </div>
        <p class="gz-auth-error" id="password-error" hidden>Enter your password.</p>
    </div>
    <button class="gz-auth-submit" type="submit" data-gz-submit><span class="gz-auth-spinner" aria-hidden="true"></span><span data-gz-label>Sign in</span></button>
</form>
<?php $this->load->view('admin/auth/shell_bottom'); ?>

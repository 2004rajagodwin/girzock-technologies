<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('emails/layout_top'); ?>
<p style="margin-top:0;">Hello <?= e($name) ?>,</p>
<p>We received a request to reset your admin password. This link works once and expires in one hour.</p>
<p><a href="<?= e($link) ?>" style="display:inline-block;background:#0b1f5c;color:#ffffff;padding:10px 18px;border-radius:6px;text-decoration:none;">Reset password</a></p>
<p>If you did not ask for this, you can ignore this email. Your password has not changed.</p>
<?php $this->load->view('emails/layout_bottom'); ?>

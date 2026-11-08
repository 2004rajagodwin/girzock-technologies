<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('emails/layout_top'); ?>
<p style="margin-top:0;">Dear <?= e($application['full_name']) ?>,</p>
<p>Thank you for applying to <?= e(setting('company_name')) ?>. We have successfully received your application for the position below.</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:16px 0;border:1px solid #e3e7f1;border-radius:8px;">
<tr><td style="padding:14px 16px;font-size:14px;line-height:1.7;">
<span style="color:#5d6579;">Position</span><br><strong style="font-size:16px;color:#0b1f5c;"><?= e($application['position_title']) ?></strong><br>
<span style="color:#5d6579;">Application reference</span><br><strong style="font-size:16px;color:#0b1f5c;letter-spacing:.02em;"><?= e($application['reference_no']) ?></strong>
</td></tr>
</table>
<p>Our recruitment team will review your profile and resume carefully. If your experience matches the role, we will contact you by email or phone to discuss the next steps.</p>
<p>Please quote your application reference if you write to us about this application. There is no need to apply again for the same position.</p>
<p style="margin-bottom:0;">Kind regards,<br><strong>Recruitment Team</strong><br><?= e(setting('company_name')) ?><br><span style="color:#5d6579;font-size:13px;"><?= e(setting('tagline')) ?></span></p>
<p style="margin:16px 0 0;font-size:13px;color:#5d6579;"><a href="mailto:<?= e(setting('contact_email')) ?>" style="color:#1769ff;"><?= e(setting('contact_email')) ?></a> &middot; <?= e(setting('address_short')) ?></p>
<?php $this->load->view('emails/layout_bottom'); ?>

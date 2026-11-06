<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('emails/layout_top'); ?>
<p style="margin-top:0;">Dear <?= e($enquiry['full_name']) ?>,</p>
<p>Thank you for contacting GIRZOCK Technologies. We have successfully received your enquiry. Our team will review your requirements and get in touch with you within 24 hours.</p>
<p>Your enquiry reference number is <strong><?= e($enquiry['reference_no']) ?></strong>. Please quote it if you contact us about this enquiry.</p>
<p style="margin-bottom:4px;"><strong>Your enquiry</strong></p>
<table role="presentation" cellpadding="4" cellspacing="0" style="font-size:14px;">
<tr><td style="color:#667;">Service</td><td><?= e($enquiry['service_required']) ?></td></tr>
<?php if ( ! empty($enquiry['company'])): ?><tr><td style="color:#667;">Company</td><td><?= e($enquiry['company']) ?></td></tr><?php endif; ?>
</table>
<p style="margin-bottom:0;">Regards,<br><?= e(setting('company_name')) ?></p>
<?php $this->load->view('emails/layout_bottom'); ?>

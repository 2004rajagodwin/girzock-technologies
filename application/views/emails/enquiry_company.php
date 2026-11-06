<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('emails/layout_top'); ?>
<p style="margin-top:0;"><strong>A new enquiry was received through the website.</strong></p>
<table role="presentation" cellpadding="6" cellspacing="0" style="font-size:14px;width:100%;">
<tr><td style="color:#667;width:150px;">Reference</td><td><strong><?= e($enquiry['reference_no']) ?></strong></td></tr>
<tr><td style="color:#667;">Client name</td><td><?= e($enquiry['full_name']) ?></td></tr>
<tr><td style="color:#667;">Email</td><td><?= e($enquiry['email']) ?></td></tr>
<tr><td style="color:#667;">Phone</td><td><?= e($enquiry['phone'] ? $enquiry['phone'] : 'Not given') ?></td></tr>
<tr><td style="color:#667;">Company</td><td><?= e($enquiry['company'] ? $enquiry['company'] : 'Not given') ?></td></tr>
<tr><td style="color:#667;">Service</td><td><?= e($enquiry['service_required']) ?></td></tr>
</table>
<p><strong>Project requirements</strong></p>
<p style="white-space:pre-line;background:#f4f6fb;padding:12px;border-radius:6px;"><?= e($enquiry['message']) ?></p>
<p><a href="<?= site_url('admin/enquiries/view/'.(int) $enquiry['id']) ?>" style="color:#0b1f5c;">Open in the admin panel</a></p>
<?php $this->load->view('emails/layout_bottom'); ?>

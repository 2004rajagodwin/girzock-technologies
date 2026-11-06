<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('emails/layout_top'); ?>
<p style="margin-top:0;"><strong>A new job application was received.</strong></p>
<p>Reference: <strong><?= e($application['reference_no']) ?></strong><br>
Position: <?= e($application['position_title']) ?><br>
Applicant: <?= e($application['full_name']) ?><br>
Email: <?= e($application['email']) ?><br>
Phone: <?= e($application['phone']) ?><br>
Experience: <?= e($application['experience']) ?></p>
<p><a href="<?= site_url('admin/job-applications/view/'.(int) $application['id']) ?>" style="color:#0b1f5c;">Review the application and resume</a></p>
<?php $this->load->view('emails/layout_bottom'); ?>

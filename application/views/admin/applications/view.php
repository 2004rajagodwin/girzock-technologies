<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar"><a class="gz-link" href="<?= site_url('admin/job-applications') ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to applications</a></div>
<div class="gz-form-grid">
    <div class="gz-card">
        <h2>Applicant</h2>
        <dl class="gz-dl">
            <dt>Reference</dt><dd><?= e($application['reference_no']) ?></dd>
            <dt>Full name</dt><dd><?= e($application['full_name']) ?></dd>
            <dt>Email</dt><dd><a href="mailto:<?= e($application['email']) ?>"><?= e($application['email']) ?></a></dd>
            <dt>Phone</dt><dd><?= e($application['phone']) ?></dd>
            <dt>Position</dt><dd><?= e($application['position_title']) ?></dd>
            <dt>Experience</dt><dd><?= e($application['experience']) ?></dd>
            <dt>Received</dt><dd><?= e(admin_date($application['created_at'])) ?></dd>
        </dl>
        <a class="gz-btn gz-btn-sm" href="<?= site_url('admin/job-applications/resume/'.(int) $application['id']) ?>"><i class="fa-solid fa-download" aria-hidden="true"></i> Download resume</a>
        <h3>Cover letter</h3>
        <p class="gz-pre"><?= $application['cover_letter'] ? e($application['cover_letter']) : 'None provided.' ?></p>
    </div>
    <div>
        <div class="gz-card">
            <h2>Review</h2>
            <p><?= status_badge($application['status']) ?></p>
            <?php if ($can_edit): ?>
            <form action="<?= site_url('admin/job-applications/update/'.(int) $application['id']) ?>" method="post" class="gz-form">
                <?= csrf_field() ?>
                <label for="status">Status</label>
                <select id="status" name="status"><?php foreach ($statuses as $status): ?><option value="<?= e($status) ?>"<?= $status === $application['status'] ? ' selected' : '' ?>><?= e(humanize_status($status)) ?></option><?php endforeach; ?></select>
                <label for="internal_notes">Internal notes</label>
                <textarea id="internal_notes" name="internal_notes" rows="6" maxlength="10000"><?= e($application['internal_notes']) ?></textarea>
                <button class="gz-btn gz-btn-sm" type="submit">Save</button>
            </form>
            <?php endif; ?>
            <?php if ($can_delete): ?>
            <form action="<?= site_url('admin/job-applications/archive/'.(int) $application['id']) ?>" method="post" data-gz-confirm="Archive this application?"><?= csrf_field() ?><button class="gz-btn gz-btn-ghost gz-btn-sm" type="submit">Archive</button></form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar"><a class="gz-link" href="<?= site_url('admin/enquiries') ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to enquiries</a></div>
<div class="gz-form-grid">
    <div>
        <div class="gz-card">
            <h2>Enquiry details</h2>
            <dl class="gz-dl">
                <dt>Reference</dt><dd><?= e($enquiry['reference_no']) ?></dd>
                <dt>Client name</dt><dd><?= e($enquiry['full_name']) ?></dd>
                <dt>Email</dt><dd><a href="mailto:<?= e($enquiry['email']) ?>"><?= e($enquiry['email']) ?></a></dd>
                <dt>Phone</dt><dd><?php if ($enquiry['phone']): ?><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $enquiry['phone'])) ?>"><?= e($enquiry['phone']) ?></a><?php else: ?>Not given<?php endif; ?></dd>
                <dt>Company</dt><dd><?= e($enquiry['company'] ? $enquiry['company'] : 'Not given') ?></dd>
                <dt>Service required</dt><dd><?= e($enquiry['service_required']) ?></dd>
                <dt>Submitted</dt><dd><?= e(admin_date($enquiry['created_at'])) ?></dd>
                <dt>Source page</dt><dd><?= e($enquiry['source_page']) ?></dd>
            </dl>
            <h3>Project description</h3>
            <p class="gz-pre"><?= e($enquiry['message']) ?></p>
        </div>
        <div class="gz-card">
            <h2>Internal notes</h2>
            <?php if ($can_edit): ?>
            <form action="<?= site_url('admin/enquiries/note/'.(int) $enquiry['id']) ?>" method="post" class="gz-form">
                <?= csrf_field() ?>
                <label for="note">Add a note</label>
                <textarea id="note" name="note" rows="3" maxlength="5000" required></textarea>
                <button class="gz-btn gz-btn-sm" type="submit">Add note</button>
            </form>
            <?php endif; ?>
            <?php if ( ! $notes): ?><p class="gz-muted">No notes yet.</p><?php endif; ?>
            <ul class="gz-feed">
                <?php foreach ($notes as $note): ?><li><span class="gz-pre"><?= e($note['note']) ?></span><small><?= e($note['author'] ? $note['author'] : 'Former user') ?> &middot; <?= e(admin_date($note['created_at'])) ?></small></li><?php endforeach; ?>
            </ul>
        </div>
        <div class="gz-card">
            <h2>Enquiry history</h2>
            <ul class="gz-feed">
                <?php foreach ($history as $item): ?>
                <li><span><?= e(humanize_status($item['action'])) ?><?php if ($item['old_value'] OR $item['new_value']): ?>: <?= e(humanize_status((string) $item['old_value'])) ?><?= $item['old_value'] ? ' &rarr; ' : '' ?><?= e(humanize_status((string) $item['new_value'])) ?><?php endif; ?></span><small><?= e($item['author'] ? $item['author'] : 'Website') ?> &middot; <?= e(admin_date($item['created_at'])) ?></small></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div>
        <div class="gz-card">
            <h2>Status</h2>
            <p><?= status_badge($enquiry['status']) ?></p>
            <?php if ($can_edit): ?>
            <form action="<?= site_url('admin/enquiries/status/'.(int) $enquiry['id']) ?>" method="post" class="gz-form">
                <?= csrf_field() ?>
                <label for="status">Update status</label>
                <select id="status" name="status"><?php foreach ($statuses as $status): ?><option value="<?= e($status) ?>"<?= $status === $enquiry['status'] ? ' selected' : '' ?>><?= e(humanize_status($status)) ?></option><?php endforeach; ?></select>
                <button class="gz-btn gz-btn-sm" type="submit">Update</button>
            </form>
            <form action="<?= site_url('admin/enquiries/assign/'.(int) $enquiry['id']) ?>" method="post" class="gz-form">
                <?= csrf_field() ?>
                <label for="assigned_to">Assigned admin</label>
                <select id="assigned_to" name="assigned_to"><option value="0">Unassigned</option><?php foreach ($assignees as $user): ?><option value="<?= (int) $user['id'] ?>"<?= (int) $user['id'] === (int) $enquiry['assigned_to'] ? ' selected' : '' ?>><?= e($user['full_name']) ?></option><?php endforeach; ?></select>
                <button class="gz-btn gz-btn-sm" type="submit">Assign</button>
            </form>
            <?php endif; ?>
        </div>
        <div class="gz-card">
            <h2>Emails</h2>
            <?php if ( ! $emails): ?><p class="gz-muted">No emails recorded.</p><?php endif; ?>
            <ul class="gz-feed">
                <?php foreach ($emails as $mail): ?>
                <li><span><?= e(ucfirst($mail['recipient_type'])) ?></span><?= status_badge($mail['status']) ?><small><?= e($mail['recipient']) ?><?= $mail['error_message'] ? ' &middot; '.e($mail['error_message']) : '' ?></small></li>
                <?php endforeach; ?>
            </ul>
            <?php if ($can_edit && array_filter($emails, function ($m) { return $m['status'] !== 'sent'; })): ?>
            <form action="<?= site_url('admin/enquiries/resend/'.(int) $enquiry['id']) ?>" method="post"><?= csrf_field() ?><button class="gz-btn gz-btn-ghost gz-btn-sm" type="submit">Retry undelivered emails</button></form>
            <?php endif; ?>
        </div>
        <?php if ($can_edit): ?>
        <div class="gz-card">
            <h2>Archive</h2>
            <form action="<?= site_url('admin/enquiries/archive/'.(int) $enquiry['id']) ?>" method="post"<?= $enquiry['archived_at'] ? '' : ' data-gz-confirm="Archive this enquiry?"' ?>><?= csrf_field() ?><button class="gz-btn gz-btn-ghost gz-btn-sm" type="submit"><?= $enquiry['archived_at'] ? 'Restore' : 'Archive' ?></button></form>
            <?php if ($can_delete): ?>
            <form action="<?= site_url('admin/enquiries/delete/'.(int) $enquiry['id']) ?>" method="post" data-gz-confirm="Permanently delete enquiry <?= e($enquiry['reference_no']) ?> from <?= e($enquiry['full_name']) ?>, with its notes and history? This cannot be undone."><?= csrf_field() ?><button class="gz-btn gz-btn-danger gz-btn-sm" type="submit">Delete permanently</button></form>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

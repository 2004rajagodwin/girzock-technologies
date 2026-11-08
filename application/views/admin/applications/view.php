<?php defined('BASEPATH') OR exit('No direct script access allowed');
$email_state = array();
foreach ($emails as $mail) { $email_state[$mail['recipient_type']] = $mail; }
$email_row = function ($type, $label) use ($email_state) {
	$m = isset($email_state[$type]) ? $email_state[$type] : NULL;
	$status = $m ? $m['status'] : 'not sent';
	$tone = array('sent' => 'gz-badge-success', 'failed' => 'gz-badge-danger', 'skipped' => 'gz-badge-warn', 'pending' => 'gz-badge-info');
	$when = $m && $m['sent_at'] ? admin_date($m['sent_at']) : ($m ? 'Attempts: '.(int) $m['attempts'] : 'No record');
	return '<dt>'.e($label).'</dt><dd><span class="gz-badge '.(isset($tone[$status]) ? $tone[$status] : 'gz-badge-primary').'">'.e(ucfirst($status)).'</span> <span class="gz-muted">'.e($when).'</span></dd>';
};
?>
<div class="gz-toolbar"><a class="gz-link" href="<?= site_url('admin/job-applications') ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to applications</a></div>
<div class="gz-form-grid gz-app">
    <div class="gz-app-main">
        <section class="gz-card gz-app-card" aria-labelledby="gz-app-applicant">
            <div class="gz-app-head">
                <div>
                    <h2 id="gz-app-applicant"><?= e($application['full_name']) ?></h2>
                    <p class="gz-muted gz-app-sub"><?= e($application['position_title']) ?> &middot; <?= e($application['reference_no']) ?></p>
                </div>
                <?= status_badge($application['status']) ?>
            </div>
            <dl class="gz-dl gz-app-dl">
                <dt>Reference</dt><dd><?= e($application['reference_no']) ?></dd>
                <dt>Full name</dt><dd><?= e($application['full_name']) ?></dd>
                <dt>Email</dt><dd><a href="mailto:<?= e($application['email']) ?>"><?= e($application['email']) ?></a></dd>
                <dt>Phone</dt><dd><a href="tel:<?= e(preg_replace('/[^\d+]/', '', (string) $application['phone'])) ?>"><?= e($application['phone']) ?></a></dd>
                <dt>Position</dt><dd><?= e($application['position_title']) ?></dd>
                <dt>Experience</dt><dd><?= e($application['experience']) ?></dd>
                <dt>Received</dt><dd><?= e(admin_date($application['created_at'])) ?></dd>
            </dl>
            <div class="gz-app-foot">
                <a class="gz-btn gz-btn-sm" href="<?= site_url('admin/job-applications/resume/'.(int) $application['id']) ?>"><i class="fa-solid fa-download" aria-hidden="true"></i> Download resume</a>
                <a class="gz-btn gz-btn-ghost gz-btn-sm" href="mailto:<?= e($application['email']) ?>?subject=<?= rawurlencode('Your application '.$application['reference_no']) ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Email applicant</a>
            </div>
        </section>
        <section class="gz-card gz-app-card" aria-labelledby="gz-app-cover">
            <h2 id="gz-app-cover">Cover letter</h2>
            <p class="gz-pre gz-app-letter"><?= $application['cover_letter'] ? e($application['cover_letter']) : '<span class="gz-muted">None provided.</span>' ?></p>
        </section>
        <section class="gz-card gz-app-card" aria-labelledby="gz-app-emails">
            <h2 id="gz-app-emails">Emails</h2>
            <dl class="gz-dl gz-app-dl">
                <?= $email_row('company', 'Notification to the company') ?>
                <?= $email_row('client', 'Confirmation to the applicant') ?>
            </dl>
            <p class="gz-help gz-app-note">Failed emails are retried automatically by the scheduled email job.</p>
        </section>
    </div>
    <aside class="gz-app-side">
        <section class="gz-card gz-app-card" aria-labelledby="gz-app-review">
            <h2 id="gz-app-review">Review</h2>
            <?php if ($can_edit): ?>
            <form action="<?= site_url('admin/job-applications/update/'.(int) $application['id']) ?>" method="post" class="gz-form gz-app-form">
                <?= csrf_field() ?>
                <label for="status">Status</label>
                <select id="status" name="status"><?php foreach ($statuses as $status): ?><option value="<?= e($status) ?>"<?= $status === $application['status'] ? ' selected' : '' ?>><?= e(humanize_status($status)) ?></option><?php endforeach; ?></select>
                <label for="internal_notes">Internal notes</label>
                <textarea id="internal_notes" name="internal_notes" rows="6" maxlength="10000" placeholder="Visible to admins only"><?= e($application['internal_notes']) ?></textarea>
                <button class="gz-btn gz-btn-block" type="submit">Save review</button>
            </form>
            <?php else: ?>
            <p><?= status_badge($application['status']) ?></p>
            <?php endif; ?>
        </section>
        <?php if ($can_delete): ?>
        <section class="gz-card gz-app-card" aria-labelledby="gz-app-actions">
            <h2 id="gz-app-actions">Actions</h2>
            <div class="gz-app-actions">
                <form action="<?= site_url('admin/job-applications/archive/'.(int) $application['id']) ?>" method="post" data-gz-confirm="Archive this application? It leaves the list but is kept."><?= csrf_field() ?><button class="gz-btn gz-btn-ghost gz-btn-block" type="submit"><i class="fa-solid fa-box-archive" aria-hidden="true"></i> Archive</button></form>
                <form action="<?= site_url('admin/job-applications/delete/'.(int) $application['id']) ?>" method="post" data-gz-app-delete data-reference="<?= e($application['reference_no']) ?>" data-name="<?= e($application['full_name']) ?>" data-redirect="<?= site_url('admin/job-applications') ?>"><?= csrf_field() ?><button class="gz-btn gz-btn-danger gz-btn-block" type="submit"><i class="fa-solid fa-trash-can" aria-hidden="true"></i> Delete permanently</button></form>
            </div>
            <p class="gz-help gz-app-note">Delete removes the application, its email log and its resume file. Archive keeps everything.</p>
        </section>
        <?php endif; ?>
    </aside>
</div>
<?php if ($can_delete) { $this->load->view('admin/applications/_delete_dialog'); } ?>

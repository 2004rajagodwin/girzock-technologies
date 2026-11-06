<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar">
    <form class="gz-filters" method="get" action="<?= site_url('admin/enquiries') ?>">
        <input type="search" name="q" value="<?= e($filters['q']) ?>" placeholder="Name, email, phone, reference..." aria-label="Search enquiries">
        <select name="status" aria-label="Filter by status">
            <option value="">All statuses</option>
            <?php foreach ($statuses as $status): ?><option value="<?= e($status) ?>"<?= $filters['status'] === $status ? ' selected' : '' ?>><?= e(humanize_status($status)) ?></option><?php endforeach; ?>
        </select>
        <label class="gz-inline">From <input type="date" name="from" value="<?= e($filters['from']) ?>"></label>
        <label class="gz-inline">To <input type="date" name="to" value="<?= e($filters['to']) ?>"></label>
        <label class="gz-check"><input type="checkbox" name="archived" value="1"<?= $filters['archived'] ? ' checked' : '' ?>> Archived</label>
        <button class="gz-btn gz-btn-ghost" type="submit">Filter</button>
    </form>
    <a class="gz-btn gz-btn-ghost" href="<?= site_url('admin/enquiries/export').($export_query ? '?'.e($export_query) : '') ?>"><i class="fa-solid fa-file-csv" aria-hidden="true"></i> Export CSV</a>
</div>
<div class="gz-card gz-table-wrap">
    <table class="gz-table">
        <thead><tr><th scope="col">Enquiry ID</th><th scope="col">Client</th><th scope="col">Phone</th><th scope="col">Company</th><th scope="col">Service</th><th scope="col">Submitted</th><th scope="col">Status</th><th scope="col">Assigned</th><th scope="col" class="gz-right">Actions</th></tr></thead>
        <tbody>
        <?php if ( ! $rows): ?><tr><td colspan="9" class="gz-empty-row">No enquiries found.</td></tr><?php endif; ?>
        <?php foreach ($rows as $row): ?>
        <tr<?= $row['is_read'] ? '' : ' class="gz-unread"' ?>>
            <td data-label="Enquiry ID"><a href="<?= site_url('admin/enquiries/view/'.(int) $row['id']) ?>"><?= e($row['reference_no']) ?></a></td>
            <td data-label="Client"><?= e($row['full_name']) ?><small class="gz-block"><?= e($row['email']) ?></small></td>
            <td data-label="Phone"><?= e($row['phone']) ?></td>
            <td data-label="Company"><?= e($row['company']) ?></td>
            <td data-label="Service"><?= e($row['service_required']) ?></td>
            <td data-label="Submitted"><?= e(admin_date($row['created_at'])) ?></td>
            <td data-label="Status"><?= status_badge($row['status']) ?></td>
            <td data-label="Assigned"><?= e($row['assigned_name'] ? $row['assigned_name'] : '-') ?></td>
            <td class="gz-right gz-actions">
                <a class="gz-icon-action" href="<?= site_url('admin/enquiries/view/'.(int) $row['id']) ?>" aria-label="View enquiry <?= e($row['reference_no']) ?>" title="View"><i class="fa-solid fa-eye" aria-hidden="true"></i></a>
                <?php if ($can_delete): ?>
                <form action="<?= site_url('admin/enquiries/delete/'.(int) $row['id']) ?>" method="post" data-gz-enquiry-delete data-reference="<?= e($row['reference_no']) ?>" data-name="<?= e($row['full_name']) ?>"><?= csrf_field() ?><button class="gz-icon-action gz-icon-danger" type="submit" aria-label="Delete enquiry <?= e($row['reference_no']) ?>" title="Delete"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></button></form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<p class="gz-muted" data-gz-enquiry-total><?= (int) $total ?> enquir<?= $total === 1 ? 'y' : 'ies' ?></p>
<?= $pagination ?>
<dialog class="gz-confirm" id="gz-delete-dialog" aria-labelledby="gz-delete-title">
    <h2 id="gz-delete-title">Delete this enquiry?</h2>
    <p data-gz-delete-text></p>
    <p class="gz-muted">Its notes and history are deleted too. This cannot be undone. To keep a copy, use Archive on the enquiry page instead.</p>
    <div class="gz-confirm-actions">
        <button type="button" class="gz-btn gz-btn-ghost" data-gz-delete-cancel>Cancel</button>
        <button type="button" class="gz-btn gz-btn-solid-danger" data-gz-delete-confirm>Delete enquiry</button>
    </div>
</dialog>
<div class="gz-toast" id="gz-toast" role="status" aria-live="polite" hidden></div>

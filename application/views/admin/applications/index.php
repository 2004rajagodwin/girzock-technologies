<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar">
    <form class="gz-filters" method="get" action="<?= site_url('admin/job-applications') ?>">
        <input type="search" name="q" value="<?= e($filters['q']) ?>" placeholder="Name, email, position..." aria-label="Search applications">
        <select name="status" aria-label="Filter by status">
            <option value="">All statuses</option>
            <?php foreach ($statuses as $status): ?><option value="<?= e($status) ?>"<?= $filters['status'] === $status ? ' selected' : '' ?>><?= e(humanize_status($status)) ?></option><?php endforeach; ?>
        </select>
        <button class="gz-btn gz-btn-ghost" type="submit">Filter</button>
    </form>
</div>
<div class="gz-card gz-table-wrap">
    <table class="gz-table">
        <thead><tr><th scope="col">Reference</th><th scope="col">Applicant</th><th scope="col">Position</th><th scope="col">Experience</th><th scope="col">Received</th><th scope="col">Status</th><th scope="col" class="gz-right">Actions</th></tr></thead>
        <tbody>
        <?php if ( ! $rows): ?><tr><td colspan="7" class="gz-empty-row">No applications found.</td></tr><?php endif; ?>
        <?php foreach ($rows as $row): ?>
        <tr<?= $row['is_read'] ? '' : ' class="gz-unread"' ?>>
            <td data-label="Reference"><a href="<?= site_url('admin/job-applications/view/'.(int) $row['id']) ?>"><?= e($row['reference_no']) ?></a></td>
            <td data-label="Applicant"><?= e($row['full_name']) ?><small class="gz-block"><?= e($row['email']) ?></small></td>
            <td data-label="Position"><?= e($row['position_title']) ?></td>
            <td data-label="Experience"><?= e($row['experience']) ?></td>
            <td data-label="Received"><?= e(admin_date($row['created_at'])) ?></td>
            <td data-label="Status"><?= status_badge($row['status']) ?></td>
            <td class="gz-right gz-actions">
                <a class="gz-icon-action" href="<?= site_url('admin/job-applications/view/'.(int) $row['id']) ?>" aria-label="View application <?= e($row['reference_no']) ?>" title="View"><i class="fa-solid fa-eye" aria-hidden="true"></i></a>
                <?php if ($can_delete): ?>
                <form action="<?= site_url('admin/job-applications/delete/'.(int) $row['id']) ?>" method="post" data-gz-app-delete data-reference="<?= e($row['reference_no']) ?>" data-name="<?= e($row['full_name']) ?>"><?= csrf_field() ?><button class="gz-icon-action gz-icon-danger" type="submit" aria-label="Delete application <?= e($row['reference_no']) ?>" title="Delete"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></button></form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<p class="gz-muted" data-gz-app-total><?= (int) $total ?> application<?= $total === 1 ? '' : 's' ?></p>
<?= $pagination ?>
<?php if ($can_delete) { $this->load->view('admin/applications/_delete_dialog'); } ?>

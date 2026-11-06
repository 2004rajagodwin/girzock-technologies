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
        <thead><tr><th scope="col">Reference</th><th scope="col">Applicant</th><th scope="col">Position</th><th scope="col">Experience</th><th scope="col">Received</th><th scope="col">Status</th></tr></thead>
        <tbody>
        <?php if ( ! $rows): ?><tr><td colspan="6" class="gz-empty-row">No applications found.</td></tr><?php endif; ?>
        <?php foreach ($rows as $row): ?>
        <tr<?= $row['is_read'] ? '' : ' class="gz-unread"' ?>>
            <td data-label="Reference"><a href="<?= site_url('admin/job-applications/view/'.(int) $row['id']) ?>"><?= e($row['reference_no']) ?></a></td>
            <td data-label="Applicant"><?= e($row['full_name']) ?><small class="gz-block"><?= e($row['email']) ?></small></td>
            <td data-label="Position"><?= e($row['position_title']) ?></td>
            <td data-label="Experience"><?= e($row['experience']) ?></td>
            <td data-label="Received"><?= e(admin_date($row['created_at'])) ?></td>
            <td data-label="Status"><?= status_badge($row['status']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<p class="gz-muted"><?= (int) $total ?> application<?= $total === 1 ? '' : 's' ?></p>
<?= $pagination ?>

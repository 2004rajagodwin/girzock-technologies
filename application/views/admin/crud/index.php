<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="gz-toolbar">
    <form class="gz-filters" method="get" action="<?= site_url('admin/'.$route) ?>">
        <input type="search" name="q" value="<?= e($filters['q']) ?>" placeholder="Search..." aria-label="Search">
        <?php if ($status_filter): ?>
        <select name="status" aria-label="Filter by status">
            <option value="">All statuses</option>
            <?php foreach ($status_filter as $status): ?><option value="<?= e($status) ?>"<?= $filters['status'] === $status ? ' selected' : '' ?>><?= e(humanize_status($status)) ?></option><?php endforeach; ?>
        </select>
        <?php endif; ?>
        <button class="gz-btn gz-btn-ghost" type="submit">Filter</button>
    </form>
    <?php if ($can_create): ?><a class="gz-btn" href="<?= site_url('admin/'.$route.'/create') ?>"><i class="fa-solid fa-plus" aria-hidden="true"></i> Add <?= e($singular) ?></a><?php endif; ?>
</div>
<div class="gz-card gz-table-wrap">
    <table class="gz-table">
        <thead><tr>
            <?php foreach ($columns as $column): ?><th scope="col"><?= e($column[0]) ?></th><?php endforeach; ?>
            <th scope="col" class="gz-right">Actions</th>
        </tr></thead>
        <tbody>
        <?php if ( ! $rows): ?><tr><td colspan="<?= count($columns) + 1 ?>" class="gz-empty-row">Nothing found.</td></tr><?php endif; ?>
        <?php foreach ($rows as $row): ?>
        <tr>
            <?php foreach ($columns as $key => $column): $value = isset($row[$key]) ? $row[$key] : ''; ?>
            <td data-label="<?= e($column[0]) ?>">
                <?php switch ($column[1]):
                    case 'image': ?><?php if ($value): ?><img class="gz-thumb" src="<?= e(media_url($value)) ?>" alt="" loading="lazy"><?php endif; ?><?php break;
                    case 'date': ?><?= e(admin_date($value, 'd M Y')) ?><?php break;
                    case 'human': ?><?= e(humanize_status(strtolower((string) $value))) ?><?php break;
                    case 'yesno': ?><?= $value ? 'Open' : 'Closed' ?><?php break;
                    case 'status': ?>
                        <?php if ($can_edit && $status_toggle && in_array($value, $status_toggle, TRUE)): ?>
                        <button type="button" class="gz-badge-btn" data-gz-toggle="<?= site_url('admin/'.$route.'/toggle/'.(int) $row['id']) ?>" title="Switch status"><?= status_badge($value) ?></button>
                        <?php else: ?><?= status_badge($value) ?><?php endif; ?>
                        <?php break;
                    default: ?><?= e($value) ?><?php endswitch; ?>
            </td>
            <?php endforeach; ?>
            <td class="gz-right gz-actions">
                <?php if ($can_edit): ?><a class="gz-btn gz-btn-ghost gz-btn-sm" href="<?= site_url('admin/'.$route.'/edit/'.(int) $row['id']) ?>">Edit</a><?php endif; ?>
                <?php if ($can_delete): ?>
                <form action="<?= site_url('admin/'.$route.'/delete/'.(int) $row['id']) ?>" method="post" data-gz-confirm="Delete &quot;<?= e($row['title']) ?>&quot;? Its public page will stop working."><?= csrf_field() ?><button class="gz-btn gz-btn-danger gz-btn-sm" type="submit">Delete</button></form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<p class="gz-muted"><?= (int) $total ?> record<?= $total === 1 ? '' : 's' ?></p>
<?= $pagination ?>

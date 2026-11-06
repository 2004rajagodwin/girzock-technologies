<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$tiles = array(
	array('total_enquiries', 'Total Enquiries', 'enquiries', 'fa-inbox'),
	array('new_enquiries', 'New Enquiries', 'enquiries?status=new', 'fa-bell'),
	array('pending_enquiries', 'Pending Enquiries', 'enquiries', 'fa-hourglass-half'),
	array('completed_enquiries', 'Completed Enquiries', 'enquiries?status=converted', 'fa-circle-check'),
	array('services', 'Total Services', 'services', 'fa-layer-group'),
	array('products', 'Total Products', 'products', 'fa-cube'),
	array('portfolio', 'Portfolio Projects', 'portfolio', 'fa-briefcase'),
	array('blog_posts', 'Published Blog Posts', 'blog', 'fa-pen-nib'),
	array('careers', 'Active Careers', 'careers', 'fa-user-tie'),
	array('applications', 'Job Applications', 'job-applications', 'fa-file-lines'),
);
?>
<section class="gz-tiles" aria-label="Key figures">
    <?php foreach ($tiles as $tile): ?>
    <a class="gz-tile" href="<?= site_url('admin/'.$tile[2]) ?>">
        <span class="gz-tile-icon" aria-hidden="true"><i class="fa-solid <?= $tile[3] ?>"></i></span>
        <span class="gz-tile-value" data-gz-stat="<?= $tile[0] ?>"><?= (int) $stats[$tile[0]] ?></span>
        <span class="gz-tile-label"><?= e($tile[1]) ?></span>
    </a>
    <?php endforeach; ?>
</section>

<section class="gz-charts" data-gz-charts="<?= site_url('admin/dashboard/chart_data') ?>" aria-label="Charts">
    <figure class="gz-card gz-chart-card gz-chart-wide">
        <figcaption>Monthly enquiries<small>Enquiries received in the last 12 months</small></figcaption>
        <div class="gz-chart-box"><canvas id="gz-chart-monthly" role="img" aria-label="Bar chart of enquiries per month"></canvas></div>
        <details class="gz-chart-table"><summary>View as table</summary><div data-gz-table="monthly"></div></details>
    </figure>
    <figure class="gz-card gz-chart-card">
        <figcaption>Enquiry status<small>Current enquiries by status</small></figcaption>
        <div class="gz-chart-box"><canvas id="gz-chart-status" role="img" aria-label="Bar chart of enquiries by status"></canvas></div>
        <details class="gz-chart-table"><summary>View as table</summary><div data-gz-table="status"></div></details>
    </figure>
    <figure class="gz-card gz-chart-card gz-chart-wide">
        <figcaption>Enquiry conversion<small><span data-gz-conversion>Calculating...</span></small></figcaption>
        <div class="gz-chart-box"><canvas id="gz-chart-conversion" role="img" aria-label="Line chart of total and converted enquiries per month"></canvas></div>
        <details class="gz-chart-table"><summary>View as table</summary><div data-gz-table="conversion"></div></details>
    </figure>
    <figure class="gz-card gz-chart-card">
        <figcaption>Blog publishing<small>Posts published per month</small></figcaption>
        <div class="gz-chart-box"><canvas id="gz-chart-posts" role="img" aria-label="Bar chart of blog posts published per month"></canvas></div>
        <details class="gz-chart-table"><summary>View as table</summary><div data-gz-table="posts"></div></details>
    </figure>
</section>
<script src="<?= asset('assets/admin/vendor/chart.umd.min.js') ?>" defer></script>

<section class="gz-panels" aria-label="Recent activity">
    <?php if ($can_enquiries): ?>
    <div class="gz-card">
        <h2>Latest enquiries</h2>
        <?php if ( ! $latest_enquiries): ?><p class="gz-muted">No enquiries yet.</p><?php endif; ?>
        <ul class="gz-feed">
            <?php foreach ($latest_enquiries as $row): ?>
            <li><a href="<?= site_url('admin/enquiries/view/'.(int) $row['id']) ?>"><?= e($row['full_name']) ?></a><?= status_badge($row['status']) ?><small><?= e($row['service_required']) ?> &middot; <?= e(admin_date($row['created_at'])) ?></small></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="gz-card">
        <h2>Recently published posts</h2>
        <?php if ( ! $latest_posts): ?><p class="gz-muted">No published posts yet.</p><?php endif; ?>
        <ul class="gz-feed">
            <?php foreach ($latest_posts as $row): ?>
            <li><a href="<?= site_url('blog/'.$row['slug']) ?>" target="_blank" rel="noopener"><?= e($row['title']) ?></a><small><?= e(admin_date($row['published_at'], 'd M Y')) ?></small></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if ($can_applications): ?>
    <div class="gz-card">
        <h2>Latest job applications</h2>
        <?php if ( ! $latest_applications): ?><p class="gz-muted">No applications yet.</p><?php endif; ?>
        <ul class="gz-feed">
            <?php foreach ($latest_applications as $row): ?>
            <li><a href="<?= site_url('admin/job-applications/view/'.(int) $row['id']) ?>"><?= e($row['full_name']) ?></a><?= status_badge($row['status']) ?><small><?= e($row['position_title']) ?> &middot; <?= e(admin_date($row['created_at'])) ?></small></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <?php if ($activities): ?>
    <div class="gz-card">
        <h2>Recent admin activity</h2>
        <ul class="gz-feed">
            <?php foreach ($activities as $row): ?>
            <li><span><?= e($row['full_name'] ? $row['full_name'] : 'System') ?>: <?= e($row['description'] ? $row['description'] : $row['action']) ?></span><small><?= e(humanize_status($row['module'])) ?> &middot; <?= e(admin_date($row['created_at'])) ?></small></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</section>

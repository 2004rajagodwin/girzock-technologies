<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$value = function ($field) use ($old) { return isset($old[$field]) ? e($old[$field]) : ''; };
$error = function ($field) use ($errors) { return isset($errors[$field]) ? '<span class="gz-field-error">'.e($errors[$field]).'</span>' : ''; };
$types = array('FULL_TIME' => 'Full time', 'PART_TIME' => 'Part time', 'CONTRACTOR' => 'Contract', 'TEMPORARY' => 'Temporary', 'INTERN' => 'Internship', 'OTHER' => 'Other');
?>
<?php $this->load->view('frontend/partials/page_banner', array('staff' => 'Careers', 'heading' => $job['title'], 'crumbs' => array('Careers' => 'careers', $job['title'] => NULL))); ?>

<section class="faq-sec5 ibt-section-gap">
    <button class="sidebar-toggle" aria-label="Open sidebar"></button>
    <div class="sidebar-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="side-bar2">
                    <button class="sidebar-close" aria-label="Close sidebar"></button>
                    <div class="ser-widget side-widget">
                        <?php foreach ($openings as $item): ?>
                        <a href="<?= site_url('careers/'.$item['slug']) ?>"<?= $item['id'] === $job['id'] ? ' aria-current="page"' : '' ?>><?= e($item['title']) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="faq-content5">
                    <h2 class="title"><?= e($job['title']) ?></h2>
                    <p class="girzock-careers-note"><?= e($job['summary']) ?></p>
                    <ul class="gz-job-facts">
                        <?php if ($job['location']): ?><li><strong>Location:</strong> <?= e($job['location']) ?></li><?php endif; ?>
                        <li><strong>Employment type:</strong> <?= e($types[$job['employment_type']]) ?></li>
                        <?php if ($job['experience_required']): ?><li><strong>Experience:</strong> <?= e($job['experience_required']) ?></li><?php endif; ?>
                    </ul>
                    <?php if ($job['description']): ?><div class="faq-block5 gz-rich-text"><?= rich_text($job['description']) ?></div><?php endif; ?>
                    <?php if (text_lines($job['responsibilities'])): ?>
                    <div class="faq-block5">
                        <h3 class="title2 h4">Responsibilities</h3>
                        <ul class="ser-detail-list"><?php foreach (text_lines($job['responsibilities']) as $line): ?><li><i class="fontello icon-button-arrow-down"></i><?= e($line) ?></li><?php endforeach; ?></ul>
                    </div>
                    <?php endif; ?>
                    <?php if (text_lines($job['qualifications'])): ?>
                    <div class="faq-block5">
                        <h3 class="title2 h4">Qualifications</h3>
                        <ul class="ser-detail-list"><?php foreach (text_lines($job['qualifications']) as $line): ?><li><i class="fontello icon-button-arrow-down"></i><?= e($line) ?></li><?php endforeach; ?></ul>
                    </div>
                    <?php endif; ?>

                    <div class="faq-block5 mb-0" id="apply">
                        <h3 class="title2 h4">Apply for this position</h3>
                        <?php if ($success): ?>
                        <p class="gz-alert gz-alert-success" role="status"><?= e($success) ?></p>
                        <?php elseif ( ! $accepting): ?>
                        <p class="gz-alert" role="status">This position is not accepting applications at the moment. You are welcome to write to <a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a>.</p>
                        <?php else: ?>
                        <?php if ($errors): ?><p class="gz-alert gz-alert-error" role="alert"><?= isset($errors['form']) ? e($errors['form']) : 'Please check the highlighted fields.' ?></p><?php endif; ?>
                        <div class="contact-form v2 gz-apply-form">
                            <form action="<?= site_url('careers/apply') ?>#apply" method="post" enctype="multipart/form-data" class="custom-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="job" value="<?= e($job['slug']) ?>">
                                <label for="ap-position">Position</label>
                                <input id="ap-position" type="text" value="<?= e($job['title']) ?>" readonly>
                                <label for="ap-name">Full Name</label>
                                <input id="ap-name" type="text" name="full_name" value="<?= $value('full_name') ?>" autocomplete="name" required maxlength="120"><?= $error('full_name') ?>
                                <label for="ap-email">Email</label>
                                <input id="ap-email" type="email" name="email" value="<?= $value('email') ?>" autocomplete="email" required maxlength="190"><?= $error('email') ?>
                                <label for="ap-phone">Phone</label>
                                <input id="ap-phone" type="tel" name="phone" value="<?= $value('phone') ?>" autocomplete="tel" required maxlength="30"><?= $error('phone') ?>
                                <label for="ap-experience">Experience</label>
                                <input id="ap-experience" type="text" name="experience" value="<?= $value('experience') ?>" placeholder="For example: 2 years, or Fresher" required maxlength="120"><?= $error('experience') ?>
                                <label for="ap-resume">Resume (PDF, DOC or DOCX, up to 5 MB)</label>
                                <input id="ap-resume" type="file" name="resume" accept=".pdf,.doc,.docx" required><?= $error('resume') ?>
                                <label for="ap-cover">Cover Letter (optional)</label>
                                <textarea id="ap-cover" name="cover_letter" rows="5" maxlength="5000" data-lenis-prevent><?= $value('cover_letter') ?></textarea><?= $error('cover_letter') ?>
                                <div class="girzock-hp" aria-hidden="true"><label>Leave this empty<input name="website" type="text" tabindex="-1" autocomplete="off"></label></div>
                                <button type="submit" class="ibt-btn ibt-btn-outline">
                                    <span>Submit application</span>
                                    <i class="icon-arrow-top"></i>
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/contact_cta'); ?>

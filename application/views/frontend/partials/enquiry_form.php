<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* $form_options lets a second copy of this form share a page: ids, heading, button and source page. */
$gz_form = isset($form_options) ? $form_options : array();
$gz_id = isset($gz_form['prefix']) ? $gz_form['prefix'] : 'gz-';
$gz_source = uri_string() === '' ? 'home' : uri_string();
?>
<form class="girzock-enquiry" action="<?= site_url('contact/submit') ?>" method="post" data-girzock-enquiry data-endpoint="<?= site_url('contact/submit') ?>" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="form_type" value="<?= e(isset($gz_form['form_type']) ? $gz_form['form_type'] : 'enquiry') ?>">
    <input type="hidden" name="source_page" value="<?= e(isset($gz_form['source']) ? $gz_form['source'].'/'.$gz_source : $gz_source) ?>">
    <div class="girzock-enquiry-intro">
        <h3 class="girzock-enquiry-title"<?= isset($gz_form['title_id']) ? ' id="'.e($gz_form['title_id']).'"' : '' ?>><?= isset($gz_form['title_html']) ? $gz_form['title_html'] : 'Send Us a Message' ?></h3>
        <p><?= e(isset($gz_form['description']) ? $gz_form['description'] : "Fill out the form below and we'll get back to you as soon as possible.") ?></p>
    </div>
    <div class="girzock-field girzock-field-name">
        <label class="girzock-sr-only" id="<?= $gz_id ?>name-label" for="<?= $gz_id ?>name">Full Name</label>
        <input id="<?= $gz_id ?>name" name="name" type="text" autocomplete="name" placeholder="Enter your full name" required maxlength="120" aria-describedby="<?= $gz_id ?>name-error">
        <span class="girzock-field-error" id="<?= $gz_id ?>name-error"></span>
    </div>
    <div class="girzock-field girzock-field-email">
        <label class="girzock-sr-only" id="<?= $gz_id ?>email-label" for="<?= $gz_id ?>email">Email Address</label>
        <input id="<?= $gz_id ?>email" name="email" type="email" autocomplete="email" placeholder="Enter your email address" required maxlength="190" aria-describedby="<?= $gz_id ?>email-error">
        <span class="girzock-field-error" id="<?= $gz_id ?>email-error"></span>
    </div>
    <div class="girzock-field girzock-field-phone">
        <label class="girzock-sr-only" id="<?= $gz_id ?>phone-label" for="<?= $gz_id ?>phone">Phone Number</label>
        <input id="<?= $gz_id ?>phone" name="phone" type="tel" autocomplete="tel" placeholder="Enter your phone number" required maxlength="30" aria-describedby="<?= $gz_id ?>phone-error">
        <span class="girzock-field-error" id="<?= $gz_id ?>phone-error"></span>
    </div>
    <div class="girzock-field girzock-field-company">
        <label class="girzock-sr-only" id="<?= $gz_id ?>company-label" for="<?= $gz_id ?>company">Company Name (optional)</label>
        <input id="<?= $gz_id ?>company" name="company" type="text" autocomplete="organization" placeholder="<?= empty($gz_form['short_placeholders']) ? 'Enter your company name (optional)' : 'Company name (optional)' ?>" maxlength="160" aria-describedby="<?= $gz_id ?>company-error">
        <span class="girzock-field-error" id="<?= $gz_id ?>company-error"></span>
    </div>
    <div class="girzock-field girzock-field-wide girzock-field-service">
        <label class="girzock-sr-only" id="<?= $gz_id ?>service-label" for="<?= $gz_id ?>service">Service Required</label>
        <select id="<?= $gz_id ?>service" name="service" required aria-describedby="<?= $gz_id ?>service-error"><option value="">Select a service</option><?php foreach ($this->settings_model->form_services() as $label): ?><option><?= e($label) ?></option><?php endforeach; ?><option>Other</option></select>
        <span class="girzock-field-error" id="<?= $gz_id ?>service-error"></span>
    </div>
    <div class="girzock-field girzock-field-wide girzock-field-details">
        <label class="girzock-sr-only" id="<?= $gz_id ?>details-label" for="<?= $gz_id ?>details">Project Details<?= empty($gz_form['message_optional']) ? '' : ' (optional)' ?></label>
        <textarea id="<?= $gz_id ?>details" name="details" rows="4" placeholder="<?= empty($gz_form['message_optional']) ? 'Tell us about your project requirements' : 'Tell us about your project requirements (optional)' ?>"<?= empty($gz_form['message_optional']) ? ' required' : ' data-optional="1"' ?> maxlength="5000" aria-describedby="<?= $gz_id ?>details-error" data-lenis-prevent></textarea>
        <span class="girzock-field-error" id="<?= $gz_id ?>details-error"></span>
    </div>
    <div class="girzock-hp" aria-hidden="true"><label for="<?= $gz_id ?>website">Leave this empty</label><input id="<?= $gz_id ?>website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
    <div class="girzock-enquiry-foot">
        <button type="submit" class="ibt-btn ibt-btn-secondary girzock-enquiry-submit"><span><?= e(isset($gz_form['button']) ? $gz_form['button'] : 'Send Project Enquiry') ?></span><i class="icon-arrow-top"></i></button>
        <p class="girzock-enquiry-status" role="status" aria-live="polite"></p>
    </div>
</form>

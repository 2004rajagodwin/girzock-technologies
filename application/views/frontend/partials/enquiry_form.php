<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form class="girzock-enquiry" action="<?= site_url('contact/submit') ?>" method="post" data-girzock-enquiry data-endpoint="<?= site_url('contact/submit') ?>" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="form_type" value="enquiry">
    <input type="hidden" name="source_page" value="<?= e(uri_string() === '' ? 'home' : uri_string()) ?>">
    <div class="girzock-enquiry-intro">
        <h3 class="girzock-enquiry-title">Send Us a Message</h3>
        <p>Fill out the form below and we'll get back to you as soon as possible.</p>
    </div>
    <div class="girzock-field">
        <label class="girzock-sr-only" id="gz-name-label" for="gz-name">Full Name</label>
        <input id="gz-name" name="name" type="text" autocomplete="name" placeholder="Enter your full name" required maxlength="120" aria-describedby="gz-name-error">
        <span class="girzock-field-error" id="gz-name-error"></span>
    </div>
    <div class="girzock-field">
        <label class="girzock-sr-only" id="gz-email-label" for="gz-email">Email Address</label>
        <input id="gz-email" name="email" type="email" autocomplete="email" placeholder="Enter your email address" required maxlength="190" aria-describedby="gz-email-error">
        <span class="girzock-field-error" id="gz-email-error"></span>
    </div>
    <div class="girzock-field">
        <label class="girzock-sr-only" id="gz-phone-label" for="gz-phone">Phone Number</label>
        <input id="gz-phone" name="phone" type="tel" autocomplete="tel" placeholder="Enter your phone number" required maxlength="30" aria-describedby="gz-phone-error">
        <span class="girzock-field-error" id="gz-phone-error"></span>
    </div>
    <div class="girzock-field">
        <label class="girzock-sr-only" id="gz-company-label" for="gz-company">Company Name (optional)</label>
        <input id="gz-company" name="company" type="text" autocomplete="organization" placeholder="Enter your company name (optional)" maxlength="160" aria-describedby="gz-company-error">
        <span class="girzock-field-error" id="gz-company-error"></span>
    </div>
    <div class="girzock-field girzock-field-wide">
        <label class="girzock-sr-only" id="gz-service-label" for="gz-service">Service Required</label>
        <select id="gz-service" name="service" required aria-describedby="gz-service-error"><option value="">Select a service</option><?php foreach ($this->settings_model->services_by('form_order') as $service): ?><option><?= e($service['form_label'] ? $service['form_label'] : $service['title']) ?></option><?php endforeach; ?><option>Other</option></select>
        <span class="girzock-field-error" id="gz-service-error"></span>
    </div>
    <div class="girzock-field girzock-field-wide">
        <label class="girzock-sr-only" id="gz-details-label" for="gz-details">Project Details</label>
        <textarea id="gz-details" name="details" rows="4" placeholder="Tell us about your project requirements" required maxlength="5000" aria-describedby="gz-details-error" data-lenis-prevent></textarea>
        <span class="girzock-field-error" id="gz-details-error"></span>
    </div>
    <div class="girzock-hp" aria-hidden="true"><label for="gz-website">Leave this empty</label><input id="gz-website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
    <div class="girzock-enquiry-foot">
        <button type="submit" class="ibt-btn ibt-btn-secondary girzock-enquiry-submit"><span>Send Project Enquiry</span><i class="icon-arrow-top"></i></button>
        <p class="girzock-enquiry-status" role="status" aria-live="polite"></p>
    </div>
</form>

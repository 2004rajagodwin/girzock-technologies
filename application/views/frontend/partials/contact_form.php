<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form action="<?= site_url('contact/submit') ?>" method="post" class="custom-form gz-contact-form" data-girzock-form>
    <?= csrf_field() ?>
    <input type="hidden" name="form_type" value="contact">
    <input type="hidden" name="source_page" value="<?= e(uri_string()) ?>">
    <h2>Get in Touch</h2>
    <input type="text" name="name" placeholder="Full name" aria-label="Full name" autocomplete="name" required maxlength="120">
    <input type="email" name="email" placeholder="Email address" aria-label="Email address" autocomplete="email" required maxlength="190">
    <input type="tel" name="phone" placeholder="Phone number" aria-label="Phone number" autocomplete="tel" required maxlength="30">
    <input type="text" name="company" placeholder="Company name (optional)" aria-label="Company name (optional)" autocomplete="organization" maxlength="160">
    <label class="girzock-sr-only" id="gz-contact-service-label" for="gz-contact-service">Service</label>
    <select id="gz-contact-service" name="service" required aria-describedby="gz-contact-service-error">
        <option value="">Select a service</option>
        <?php foreach ($this->settings_model->form_services() as $label): ?><option><?= e($label) ?></option><?php endforeach; ?>
        <option>Other</option>
    </select>
    <span class="girzock-field-error" id="gz-contact-service-error"></span>
    <textarea name="message" rows="5" placeholder="Write your message..." aria-label="Message" required maxlength="5000"></textarea>
    <div class="girzock-hp" aria-hidden="true"><label>Leave this empty<input name="website" type="text" tabindex="-1" autocomplete="off"></label></div>

    <button type="submit" class="ibt-btn ibt-btn-outline">
        <span>Send message</span>
        <i class="icon-arrow-top"></i>
    </button>
    <p class="girzock-form-status" role="status" aria-live="polite"></p>
</form>

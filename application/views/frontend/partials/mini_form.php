<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form action="<?= site_url('contact/submit') ?>" method="post" class="custom-form" data-girzock-form>
    <?= csrf_field() ?>
    <input type="hidden" name="form_type" value="message">
    <input type="hidden" name="source_page" value="<?= e(uri_string()) ?>">
    <h2>Get in Touch</h2>
    <input type="text" name="name" placeholder="Full name" aria-label="Full name" autocomplete="name" required maxlength="120">
    <input type="email" name="email" placeholder="Email" aria-label="Email" autocomplete="email" required maxlength="190">
    <input type="text" name="subject" placeholder="Subject" aria-label="Subject" required maxlength="160">
    <textarea name="message" rows="5" placeholder="Write your message..." aria-label="Message" required maxlength="5000"></textarea>
    <div class="girzock-hp" aria-hidden="true"><label>Leave this empty<input name="website" type="text" tabindex="-1" autocomplete="off"></label></div>

    <button type="submit" class="ibt-btn ibt-btn-outline">
        <span>Send message</span>
        <i class="icon-arrow-top"></i>
    </button>
    <p class="girzock-form-status" role="status" aria-live="polite"></p>
</form>

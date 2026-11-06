<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$posted = $errors ? $this->input->post(NULL, FALSE) : array();
$v = function ($key) use ($values, $posted) {
	if (isset($posted[$key])) { return e($posted[$key]); }
	return isset($values[$key]) ? e($values[$key]) : '';
};
$err = function ($key) use ($errors) { return isset($errors[$key]) ? '<p class="gz-error">'.e($errors[$key]).'</p>' : ''; };
$text = function ($key, $label, $help = '', $type = 'text') use ($v, $err) {
	echo '<div class="gz-field"><label for="s-'.$key.'">'.e($label).'</label><input id="s-'.$key.'" type="'.$type.'" name="'.$key.'" value="'.$v($key).'">'.$err($key).($help ? '<p class="gz-help">'.e($help).'</p>' : '').'</div>';
};
$area = function ($key, $label, $help = '') use ($v, $err) {
	echo '<div class="gz-field"><label for="s-'.$key.'">'.e($label).'</label><textarea id="s-'.$key.'" name="'.$key.'" rows="3">'.$v($key).'</textarea>'.$err($key).($help ? '<p class="gz-help">'.e($help).'</p>' : '').'</div>';
};
$image = function ($key, $label) use ($values, $err) {
	echo '<div class="gz-field"><label for="s-'.$key.'">'.e($label).'</label>';
	if ( ! empty($values[$key])) { echo '<img class="gz-image-preview gz-on-dark" src="'.e(media_url($values[$key])).'" alt="">'; }
	echo '<input id="s-'.$key.'" type="file" name="'.$key.'" accept=".jpg,.jpeg,.png,.webp,.gif">'.$err($key).'</div>';
};
?>
<?php if ($errors): ?><div class="gz-flash gz-flash-error" role="alert">Please correct the highlighted fields. Nothing has been saved yet.</div><?php endif; ?>
<form action="<?= site_url('admin/settings/save') ?>" method="post" enctype="multipart/form-data" class="gz-form">
    <?= csrf_field() ?>
    <div class="gz-panels">
        <div class="gz-card">
            <h2>Company</h2>
            <?php $text('company_name', 'Company name'); $text('tagline', 'Tagline'); $text('website_url', 'Website URL', '', 'url'); $area('footer_description', 'Footer description'); ?>
        </div>
        <div class="gz-card">
            <h2>Contact details</h2>
            <?php $text('contact_email', 'Public contact email', '', 'email'); $text('notification_email', 'Enquiry notification email', 'New enquiries are sent here.', 'email'); $text('phone', 'Phone number'); $area('business_address', 'Business address', 'Line breaks are kept.'); $text('address_short', 'Short address'); ?>
            <div class="gz-two-col"><?php $text('address_locality', 'Locality'); $text('address_region', 'Region'); $text('address_country', 'Country code'); ?></div>
        </div>
        <div class="gz-card">
            <h2>Logo and icons</h2>
            <?php $image('logo_color', 'Logo (colour)'); $image('logo_white', 'Logo (white)'); $image('logo_icon', 'Icon'); $image('favicon', 'Favicon'); ?>
        </div>
        <div class="gz-card">
            <h2>Social media</h2>
            <p class="gz-muted">Use only your verified company profiles. Leave a field empty to show that icon as "coming soon".</p>
            <?php foreach ($socials as $link): $key = 'social_'.$link['platform']; ?>
            <div class="gz-field"><label for="<?= $key ?>"><?= e($link['label']) ?></label><input id="<?= $key ?>" type="url" name="<?= $key ?>" value="<?= e(isset($posted[$key]) ? $posted[$key] : $link['url']) ?>" placeholder="https://"><?= $err($key) ?></div>
            <?php endforeach; ?>
        </div>
        <div class="gz-card">
            <h2>SEO defaults</h2>
            <?php $text('default_meta_title', 'Default title'); $area('default_meta_description', 'Default meta description'); $image('default_og_image', 'Default social image'); $text('google_analytics_id', 'Google Analytics ID', 'For example G-XXXXXXXXXX. Leave empty to load no analytics.'); $text('gsc_verification', 'Google Search Console verification code'); ?>
        </div>
        <div class="gz-card" id="smtp">
            <h2>Email (SMTP)</h2>
            <?php if ($env_smtp_set): ?><p class="gz-muted">Empty fields fall back to the values in the private .env file.</p><?php endif; ?>
            <?php $text('smtp_host', 'SMTP host'); ?>
            <div class="gz-two-col">
                <?php $text('smtp_port', 'Port'); ?>
                <div class="gz-field"><label for="s-smtp_crypto">Encryption</label><select id="s-smtp_crypto" name="smtp_crypto"><?php foreach (array('' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL') as $option => $label): ?><option value="<?= $option ?>"<?= $v('smtp_crypto') === $option ? ' selected' : '' ?>><?= $label ?></option><?php endforeach; ?></select><?= $err('smtp_crypto') ?></div>
            </div>
            <?php $text('smtp_user', 'Username'); ?>
            <div class="gz-field">
                <label for="s-smtp_password">Password</label>
                <input id="s-smtp_password" type="password" name="smtp_password" autocomplete="new-password" placeholder="<?= empty($values['smtp_password_is_set']) ? '' : 'Saved. Leave empty to keep it.' ?>">
                <p class="gz-help">Stored encrypted and never shown again.</p>
                <?php if ( ! empty($values['smtp_password_is_set'])): ?><label class="gz-check"><input type="checkbox" name="smtp_password_clear" value="1"> Remove the saved password</label><?php endif; ?>
            </div>
            <?php $text('smtp_from_email', 'From email', 'Many SMTP providers require this to match the account.', 'email'); $text('smtp_from_name', 'From name'); ?>
        </div>
        <div class="gz-card">
            <h2>Page text</h2>
            <?php $area('portfolio_intro', 'Portfolio note', 'Update this when the gallery shows real client work.'); $area('case_studies_intro', 'Case studies introduction', 'Update this when you publish verified client case studies.'); ?>
        </div>
    </div>
    <?php if ($can_edit): ?><button class="gz-btn" type="submit">Save settings</button><?php endif; ?>
</form>
<?php if ($can_edit): ?>
<form class="gz-card gz-narrow" action="<?= site_url('admin/settings/test_email') ?>" method="post">
    <?= csrf_field() ?>
    <h2>Test email</h2>
    <p class="gz-muted">Sends a test message to your own address using the saved settings.</p>
    <button class="gz-btn gz-btn-ghost" type="submit">Send test email</button>
</form>
<?php endif; ?>

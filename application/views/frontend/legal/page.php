<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$company = setting('company_name');
$email = setting('contact_email');
$phone = setting('phone');
$address = setting('address_short', setting('business_address'));
$contact = '<a href="mailto:'.e($email).'">'.e($email).'</a>';
$this->load->view('frontend/partials/page_banner', array('staff' => 'Legal', 'heading' => $legal_title, 'crumbs' => array($legal_title => NULL)));
?>
<section class="gz-post ibt-section-gap gz-legal">
    <div class="container">
        <div class="gz-rich-text gz-post-text" style="max-width:860px;margin:0 auto">
            <p class="gz-legal-updated">Last updated: 7 November 2026</p>
<?php if ($legal_page === 'privacy'): ?>
            <p>This policy explains what personal information <?= e($company) ?> collects through this website, why, and the choices you have.</p>
            <h2>What we collect</h2>
            <ul>
                <li><strong>Enquiry forms:</strong> your name, email address, phone number, company name (optional), the service you are interested in and your message.</li>
                <li><strong>Job applications:</strong> your name, email address, phone number, experience, cover letter and the resume you upload.</li>
                <li><strong>Technical details:</strong> your IP address and browser details, stored with enquiries and used to prevent spam and abuse.</li>
            </ul>
            <h2>How we use it</h2>
            <ul>
                <li>To reply to your enquiry and send you a confirmation.</li>
                <li>To consider your job application.</li>
                <li>To protect the website from spam and misuse.</li>
            </ul>
            <p>We do not sell your personal information.</p>
            <h2>Who can see it</h2>
            <p>Your information can be read by authorised <?= e($company) ?> staff. Emails are sent through our email service provider, and the website is stored with our hosting provider. We share information beyond this only when the law requires it.</p>
            <h2>How long we keep it</h2>
            <p>We keep enquiries and applications for as long as we need them for the purposes above, or as the law requires. You can ask us to delete your information at any time.</p>
            <h2>Your choices</h2>
            <p>You can ask to see, correct or delete the personal information we hold about you. Write to <?= $contact ?>.</p>
            <h2>Cookies</h2>
            <p>See our <a href="<?= site_url('cookie-policy') ?>">Cookie Policy</a>.</p>
            <h2>Contact</h2>
            <p><?= e($company) ?><?= $address ? ', '.e($address) : '' ?><br>Email: <?= $contact ?><?= $phone ? '<br>Phone: '.e($phone) : '' ?></p>
<?php elseif ($legal_page === 'terms'): ?>
            <p>These terms apply when you use this website, operated by <?= e($company) ?>. By using the website, you agree to them.</p>
            <h2>Using this website</h2>
            <p>You may browse this website and contact us through it. Please do not misuse it, try to break its security, or send unlawful or misleading content through its forms.</p>
            <h2>Information on this website</h2>
            <p>We work to keep the information here accurate, but it is general information and may change. It is not a quotation or a contract. Projects and prices are agreed separately in writing.</p>
            <h2>Offers</h2>
            <p>Any promotional offer applies on the terms stated with it, and we confirm how it applies to your project before work begins.</p>
            <h2>Sample work</h2>
            <p>Portfolio items and case studies marked as sample concepts show the kind of work we can do. They are not client projects.</p>
            <h2>Intellectual property</h2>
            <p>The content, design and branding of this website belong to <?= e($company) ?> or its licensors. Please do not reuse them without permission.</p>
            <h2>Links to other websites</h2>
            <p>This website links to other services, such as WhatsApp and Instagram. We do not control them and are not responsible for their content or practices.</p>
            <h2>Changes</h2>
            <p>We may update these terms from time to time. The version on this page applies.</p>
            <h2>Contact</h2>
            <p>Questions about these terms: <?= $contact ?>.</p>
<?php else: ?>
            <p>This policy explains how this website uses cookies and similar browser storage.</p>
            <h2>What we use</h2>
            <table>
                <thead><tr><th>Name</th><th>Purpose</th><th>How long</th></tr></thead>
                <tbody>
                    <tr><td>gz_csrf</td><td>Security cookie that protects our forms from forged submissions</td><td>2 hours</td></tr>
                    <tr><td>themeMode</td><td>Remembers your light or dark theme choice (browser storage)</td><td>Until you clear it</td></tr>
                    <tr><td>gzPageLoaded</td><td>Skips the loading screen on later pages (browser storage)</td><td>Until the tab closes</td></tr>
                    <tr><td>gzPopup</td><td>Remembers when you closed the offer or sent its form, so it is not repeated too soon. It holds only those dates, no personal details (browser storage)</td><td>Until you clear it; the offer may show again after the set number of days</td></tr>
                    <tr><td>gzPopupSession</td><td>Remembers that the offer was shown during this visit (browser storage)</td><td>Until the tab closes</td></tr>
                </tbody>
            </table>
            <p>Staff who sign in to the admin area also use a session cookie, gz_admin_session.</p>
<?php if (setting('google_analytics_id')): ?>
            <h2>Analytics</h2>
            <p>We use Google Analytics to understand how the website is used. Google Analytics sets its own cookies.</p>
<?php endif; ?>
            <h2>Other services</h2>
            <p>The map on our Contact page is provided by Google Maps, which may set its own cookies when the map loads. Links to WhatsApp and Instagram take you to those services, and their own policies apply.</p>
            <h2>Your choices</h2>
            <p>You can block or delete cookies in your browser settings. Forms may not work if the security cookie is blocked.</p>
            <h2>Contact</h2>
            <p>Questions about this policy: <?= $contact ?>.</p>
<?php endif; ?>
        </div>
    </div>
</section>

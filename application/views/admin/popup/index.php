<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$posted = $errors ? $this->input->post(NULL, FALSE) : array();
$v = function ($key) use ($values, $posted) {
	if (isset($posted[$key]) && is_string($posted[$key])) { return e($posted[$key]); }
	return isset($values[$key]) ? e($values[$key]) : '';
};
$err = function ($key) use ($errors) { return isset($errors[$key]) ? '<p class="gz-error">'.e($errors[$key]).'</p>' : ''; };
$is_on = function ($key) use ($values, $posted, $errors) { return $errors ? ! empty($posted[$key]) : $values[$key] === '1'; };
$size = function ($bytes) { return $bytes >= 1048576 ? round($bytes / 1048576, 1).' MB' : round($bytes / 1024).' KB'; };
$enabled = $values['popup_enabled'] === '1';
?>
<?php if ($errors): ?><div class="gz-flash gz-flash-error" role="alert">Please correct the highlighted fields. Nothing has been saved yet.</div><?php endif; ?>

<div class="gz-card">
    <h2>Status: <?= $enabled ? 'On' : 'Off' ?></h2>
    <p class="gz-help"><?= $enabled ? 'Visitors see the popup, subject to the dates and screen settings below.' : 'Visitors do not see the popup.' ?></p>
    <div class="gz-actions">
        <?php if ($can_edit): ?>
        <form action="<?= site_url('admin/popup/toggle') ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="gz-btn" type="submit"><?= $enabled ? 'Turn off' : 'Turn on' ?></button></form>
        <?php endif; ?>
        <button class="gz-btn gz-btn-ghost" type="button" data-gz-popup-preview="desktop">Preview desktop popup</button>
        <button class="gz-btn gz-btn-ghost" type="button" data-gz-popup-preview="mobile">Preview mobile popup</button>
        <?php if ($can_edit): ?>
        <form action="<?= site_url('admin/popup/reset_visitors') ?>" method="post" style="display:inline" data-gz-confirm="Show the popup again to every visitor who closed it or sent the form?"><?= csrf_field() ?><button class="gz-btn gz-btn-ghost" type="submit">Reset visitor dismissals</button></form>
        <form action="<?= site_url('admin/popup/reset') ?>" method="post" style="display:inline" data-gz-confirm="Reset all popup settings and images to the defaults? Uploaded files stay in the Media Library."><?= csrf_field() ?><button class="gz-btn gz-btn-ghost" type="submit">Reset to default settings</button></form>
        <?php endif; ?>
    </div>
    <p class="gz-help">Previews show saved settings, in this browser only.</p>
</div>

<form action="<?= site_url('admin/popup/save') ?>" method="post" enctype="multipart/form-data" class="gz-form">
    <?= csrf_field() ?>
    <div class="gz-panels">
        <div class="gz-card">
            <h2>General settings</h2>
            <div class="gz-field"><label class="gz-check"><input type="checkbox" name="popup_enabled" value="1"<?= $is_on('popup_enabled') ? ' checked' : '' ?>> Enable popup</label></div>
            <div class="gz-field"><label for="p-title">Popup title</label><input id="p-title" type="text" name="popup_title" maxlength="120" required value="<?= $v('popup_title') ?>"><?= $err('popup_title') ?></div>
            <div class="gz-field"><label for="p-desc">Popup description</label><textarea id="p-desc" name="popup_description" rows="2" maxlength="300"><?= $v('popup_description') ?></textarea><?= $err('popup_description') ?></div>
            <div class="gz-field"><label for="p-alt">Image description (alt text)</label><input id="p-alt" type="text" name="popup_image_alt" maxlength="255" value="<?= $v('popup_image_alt') ?>"><p class="gz-help">Read aloud by screen readers. Say what the offer is.</p><?= $err('popup_image_alt') ?></div>
            <div class="gz-two-col">
                <div class="gz-field"><label for="p-delay">Display delay (seconds)</label><input id="p-delay" type="number" name="popup_delay" min="0" max="120" required value="<?= $v('popup_delay') ?>"><?= $err('popup_delay') ?></div>
                <div class="gz-field"><label for="p-re">When it may appear again</label><select id="p-re" name="popup_reappear">
                    <?php $current = $errors && isset($posted['popup_reappear']) ? $posted['popup_reappear'] : $values['popup_reappear']; foreach (array('days' => 'After a set number of days (recommended)', 'closed' => 'Never again once the visitor closes it', 'session' => 'Once per browser session', 'refresh' => 'On every page load') as $key => $label): ?>
                    <option value="<?= $key ?>"<?= $current === $key ? ' selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select><p class="gz-help">Whatever you choose, a visitor who has sent the form does not see the popup again for the number of days set below.</p><?= $err('popup_reappear') ?></div>
            </div>
            <div class="gz-two-col">
                <div class="gz-field"><label for="p-dd">Days hidden after the visitor closes it</label><input id="p-dd" type="number" name="popup_dismiss_days" min="1" max="365" required value="<?= $v('popup_dismiss_days') ?>"><p class="gz-help">Used with "After a set number of days". Default 7.</p><?= $err('popup_dismiss_days') ?></div>
                <div class="gz-field"><label for="p-sd">Days hidden after the visitor sends the form</label><input id="p-sd" type="number" name="popup_submit_days" min="1" max="365" required value="<?= $v('popup_submit_days') ?>"><p class="gz-help">Default 30.</p><?= $err('popup_submit_days') ?></div>
            </div>
            <div class="gz-two-col">
                <div class="gz-field"><label for="p-start">Start date (optional)</label><input id="p-start" type="date" name="popup_start_date" value="<?= $v('popup_start_date') ?>"><?= $err('popup_start_date') ?></div>
                <div class="gz-field"><label for="p-end">End date (optional)</label><input id="p-end" type="date" name="popup_end_date" value="<?= $v('popup_end_date') ?>"><p class="gz-help">The popup runs through the end of this day. Set this for a limited-time offer.</p><?= $err('popup_end_date') ?></div>
            </div>
            <div class="gz-field"><label class="gz-check"><input type="checkbox" name="popup_show_desktop" value="1"<?= $is_on('popup_show_desktop') ? ' checked' : '' ?>> Show on desktop and tablet (768 px and wider)</label></div>
            <div class="gz-field"><label class="gz-check"><input type="checkbox" name="popup_show_mobile" value="1"<?= $is_on('popup_show_mobile') ? ' checked' : '' ?>> Show on mobile (under 768 px)</label></div>
        </div>
        <?php foreach (array('desktop' => array('popup_desktop_image', 'Desktop image'), 'mobile' => array('popup_mobile_image', 'Mobile image')) as $which => $item): $image = $images[$which]; ?>
        <div class="gz-card">
            <h2><?= $item[1] ?></h2>
            <?php if ($image['exists']): ?>
            <img class="gz-image-preview" style="max-height:240px" src="<?= e($image['url']) ?>" alt="Current <?= $which ?> popup image">
            <p class="gz-help" data-gz-image-facts="<?= $which ?>"><?= (int) $image['width'] ?> x <?= (int) $image['height'] ?> px, <?= $size($image['bytes']) ?><br><?= e($image['path']) ?></p>
            <?php elseif ($image['path'] !== ''): ?>
            <p class="gz-error">The saved file is missing: <?= e($image['path']) ?>. The popup shows only the form until you upload a new image.</p>
            <?php else: ?>
            <p class="gz-help">No image. The popup shows only the form on this screen size.</p>
            <?php endif; ?>
            <div class="gz-field"><label for="p-<?= $which ?>"><?= $image['exists'] ? 'Replace image' : 'Upload image' ?></label><input id="p-<?= $which ?>" type="file" name="<?= $item[0] ?>" accept=".webp,.png,.jpg,.jpeg"><p class="gz-help">WebP, PNG or JPG. Up to 5 MB, 300 to 6000 px on each side. The file is kept exactly as uploaded.</p><?= $err($item[0]) ?></div>
            <?php if ($image['path'] !== ''): ?>
            <button class="gz-btn gz-btn-danger gz-btn-sm" type="submit" name="confirm_delete" value="1" formaction="<?= site_url('admin/popup/delete_image/'.$which) ?>" formnovalidate data-gz-confirm="<?= $enabled ? 'This image is in use on the live popup. ' : '' ?>Delete this <?= $which ?> image? Visitors will see only the form on this screen size until you add another.">Delete image</button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if ($can_edit): ?><div class="gz-actions"><button class="gz-btn" type="submit">Save settings</button></div><?php endif; ?>
</form>

<div class="gz-popup-preview" data-gz-popup-preview-box hidden style="position:fixed;inset:0;z-index:1000;display:flex;flex-direction:column;align-items:center;gap:12px;padding:16px;background:rgba(10,16,48,.75)">
    <button class="gz-btn gz-btn-ghost" type="button" data-gz-popup-preview-close>Close preview</button>
    <iframe title="Popup preview" data-gz-popup-frame style="border:0;border-radius:12px;background:#fff;max-width:100%;flex:1"></iframe>
</div>
<script>
(function () {
  var box = document.querySelector("[data-gz-popup-preview-box]"), frame = document.querySelector("[data-gz-popup-frame]");
  box.hidden = true; box.style.display = "none";
  document.querySelectorAll("[data-gz-popup-preview]").forEach(function (button) {
    button.addEventListener("click", function () {
      var mode = button.getAttribute("data-gz-popup-preview");
      frame.style.width = mode === "mobile" ? "390px" : "1280px";
      frame.src = <?= json_encode(site_url()) ?> + "?gz_popup_preview=" + mode;
      box.hidden = false; box.style.display = "flex";
    });
  });
  document.querySelector("[data-gz-popup-preview-close]").addEventListener("click", function () {
    box.hidden = true; box.style.display = "none"; frame.src = "about:blank";
  });
})();
</script>

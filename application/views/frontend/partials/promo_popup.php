<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Promotional popup. Images are added by JavaScript when needed, so a visitor downloads only one of them. */
$words = explode(' ', trim($popup['title']));
$last = count($words) > 1 ? array_pop($words) : '';
$title_html = e(implode(' ', $words)).($last !== '' ? ' <span>'.e($last).'</span>' : '');
?>
<div id="gz-popup" class="gz-popup" hidden data-delay="<?= (int) $popup['delay'] ?>" data-reappear="<?= e($popup['reappear']) ?>" data-dismiss-days="<?= (int) $popup['dismiss_days'] ?>" data-submit-days="<?= (int) $popup['submit_days'] ?>" data-version="<?= e($popup['version']) ?>" data-show-desktop="<?= $popup['show_desktop'] ? '1' : '0' ?>" data-show-mobile="<?= $popup['show_mobile'] ? '1' : '0' ?>" data-desktop-src="<?= e($popup['desktop']['url']) ?>" data-desktop-w="<?= (int) $popup['desktop']['width'] ?>" data-desktop-h="<?= (int) $popup['desktop']['height'] ?>" data-mobile-src="<?= e($popup['mobile']['url']) ?>" data-mobile-w="<?= (int) $popup['mobile']['width'] ?>" data-mobile-h="<?= (int) $popup['mobile']['height'] ?>" data-alt="<?= e($popup['alt']) ?>"<?= $popup['preview'] ? ' data-preview="1"' : '' ?>>
    <div class="gz-popup-dialog" role="dialog" aria-modal="true" aria-labelledby="gz-pop-title" tabindex="-1">
        <button type="button" class="gz-popup-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="gz-popup-scroll" data-lenis-prevent>
            <div class="gz-popup-media"></div>
            <div class="gz-popup-body" data-lenis-prevent>
                <?php $this->load->view('frontend/partials/enquiry_form', array('form_options' => array('prefix' => 'gz-pop-', 'title_html' => $title_html, 'title_id' => 'gz-pop-title', 'description' => $popup['description'], 'button' => 'Send Message', 'source' => 'popup', 'form_type' => 'popup', 'message_optional' => TRUE, 'short_placeholders' => TRUE))); ?>
            </div>
        </div>
    </div>
</div>

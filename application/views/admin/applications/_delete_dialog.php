<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<dialog class="gz-confirm" id="gz-app-delete-dialog" aria-labelledby="gz-app-delete-title" aria-describedby="gz-app-delete-text">
    <h2 id="gz-app-delete-title">Delete this application?</h2>
    <p id="gz-app-delete-text" data-gz-app-delete-text></p>
    <p class="gz-muted">Its resume file and email log are deleted too. This cannot be undone. To keep a copy, use Archive on the application page instead.</p>
    <div class="gz-confirm-actions">
        <button type="button" class="gz-btn gz-btn-ghost" data-gz-app-delete-cancel>Cancel</button>
        <button type="button" class="gz-btn gz-btn-solid-danger" data-gz-app-delete-confirm>Delete application</button>
    </div>
</dialog>
<div class="gz-toast" id="gz-app-toast" role="status" aria-live="polite" hidden></div>

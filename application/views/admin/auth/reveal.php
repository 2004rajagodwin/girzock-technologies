<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Show or hide a password field. It only changes the field type in this browser; the value is never sent or stored anywhere else. */
?>
<button type="button" class="gz-auth-reveal" data-gz-reveal="<?= e($target) ?>" aria-controls="<?= e($target) ?>" aria-pressed="false" aria-label="Show password" title="Show password">
    <svg class="gz-eye" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 5C6.5 5 2.7 9.1 1.5 12c1.2 2.9 5 7 10.5 7s9.3-4.1 10.5-7C21.3 9.1 17.5 5 12 5Zm0 11.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Zm0-2.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/></svg>
    <svg class="gz-eye-off" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M2.3 3.7 3.7 2.3l18 18-1.4 1.4-3.3-3.3A11.6 11.6 0 0 1 12 19c-5.5 0-9.3-4.1-10.5-7a13 13 0 0 1 4-5L2.3 3.7Zm5.2 5.2A4.5 4.5 0 0 0 13.6 15l-1.6-1.6a2 2 0 0 1-2.4-2.4L7.5 8.9ZM12 5c5.5 0 9.3 4.1 10.5 7a13.2 13.2 0 0 1-3 4.3l-3.1-3.1A4.5 4.5 0 0 0 10.8 7.6L8.9 5.7C9.9 5.3 10.9 5 12 5Z"/></svg>
</button>

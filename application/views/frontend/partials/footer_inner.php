<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Inner pages: close the page's main section when the page opened one, then the same footer as the homepage. */
if ( ! empty($main_sec_open)): ?>
    </section>
    <!-- End main-sec -->
<?php endif; ?>
<?php $this->load->view('frontend/partials/footer_home'); ?>
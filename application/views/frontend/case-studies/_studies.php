<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Same running order as the original page: lead study, video banner, second study, process gallery, then the rest. */
foreach ($studies as $i => $study):
	if ($i === 0):
		$this->load->view('frontend/case-studies/_lead', array('study' => $study, 'anchor' => 'study-1'));
		$this->load->view('frontend/case-studies/_video_banner');
	else:
		$this->load->view('frontend/case-studies/_process', array('study' => $study, 'anchor' => 'study-'.($i + 1)));
		if ($i === 1):
			$this->load->view('frontend/case-studies/_process_gallery', array('first_study_anchor' => '#study-1'));
		endif;
	endif;
endforeach;

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** 404 override for unknown URLs. Public_Controller::not_found() also applies url_redirects. */
class Errors extends Public_Controller {

	public function not_found()
	{
		parent::not_found();
	}
}

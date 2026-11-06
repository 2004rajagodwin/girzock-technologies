<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Sends the two notifications for an enquiry. Used on submission and for retries. */
class Enquiry_mailer {

	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('mailer');
	}

	public function notify(array $enquiry)
	{
		$data = array('enquiry' => $enquiry, 'company_name' => setting('company_name'));
		$company_to = setting('notification_email', setting('contact_email'));
		$company = $this->CI->mailer->send_once('enquiry', $enquiry['id'], 'company', $company_to,
			'New enquiry '.$enquiry['reference_no'].': '.mb_substr(clean_header_value($enquiry['service_required']), 0, 80),
			'emails/enquiry_company', $data, $enquiry['email']);
		$client = $this->CI->mailer->send_once('enquiry', $enquiry['id'], 'client', $enquiry['email'],
			'Thank You for Contacting GIRZOCK Technologies',
			'emails/enquiry_client', $data, setting('contact_email'));
		return array('company' => $company, 'client' => $client);
	}
}

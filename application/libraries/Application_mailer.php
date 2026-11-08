<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Sends the two emails for a job application: to the company and a confirmation to the candidate. Used on submission and for retries. */
class Application_mailer {

	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('mailer');
	}

	/** Each email is sent at most once (see Mailer::send_once); failures are logged in email_log and can be retried. */
	public function notify(array $application)
	{
		$company = $this->CI->mailer->send_once('application', $application['id'], 'company', setting('notification_email', setting('contact_email')),
			'New job application '.$application['reference_no'], 'emails/application_company', array('application' => $application), $application['email']);
		$client = $this->CI->mailer->send_once('application', $application['id'], 'client', $application['email'],
			'Application received: '.mb_substr(clean_header_value($application['position_title']), 0, 120).' | '.setting('company_name'),
			'emails/application_client', array('application' => $application), setting('contact_email'));
		return array('company' => $company, 'client' => $client);
	}
}

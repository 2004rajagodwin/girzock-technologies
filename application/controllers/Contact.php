<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Public_Controller {

	public function index($result = NULL)
	{
		$this->render('frontend/contact/index', array(
			'footer_gap_top' => TRUE,
			'form_result' => $result,
			'seo' => $this->seo->build(array('entity' => array('page', 'contact'), 'path' => 'contact', 'webpage_type' => 'ContactPage',
				'breadcrumbs' => array('Home' => '', 'Contact' => NULL))),
		));
	}

	/**
	 * Receives both website forms. CSRF is verified by the framework before this runs.
	 * The enquiry is saved first; a mail problem can never lose it.
	 */
	public function submit()
	{
		if ($this->input->method() !== 'post')
		{
			redirect('contact');
		}
		$ajax = $this->wants_json();

		// Spam trap: report success, store nothing.
		if ((string) $this->input->post('website') !== '')
		{
			return $this->respond($ajax, 200, array('ok' => TRUE, 'message' => $this->success_message('')));
		}

		$input = $this->read_input();
		$errors = $this->validate($input);
		if ($errors)
		{
			return $this->respond($ajax, 422, array('ok' => FALSE, 'message' => 'Please check the highlighted fields.', 'errors' => $errors));
		}

		$this->load->model('enquiry_model');
		$duplicate = $this->enquiry_model->find_recent_duplicate($this->enquiry_model->content_hash($input));
		if ($duplicate)
		{
			return $this->respond($ajax, 200, array('ok' => TRUE, 'reference' => $duplicate['reference_no'], 'message' => $this->success_message($duplicate['reference_no'])));
		}

		if ( ! $this->settings_model->throttle('enquiry', 5, 600))
		{
			return $this->respond($ajax, 429, array('ok' => FALSE, 'message' => 'Too many enquiries from this connection. Please try again in a few minutes.'));
		}

		$input['ip_address'] = $this->input->ip_address();
		$input['user_agent'] = mb_substr((string) $this->input->user_agent(), 0, 255);
		$enquiry = $this->enquiry_model->create($input);
		if ( ! $enquiry)
		{
			return $this->respond($ajax, 500, array('ok' => FALSE, 'message' => 'Sorry, your enquiry could not be saved.'));
		}

		$this->load->library('enquiry_mailer');
		$this->enquiry_mailer->notify($enquiry);

		$this->respond($ajax, 200, array('ok' => TRUE, 'reference' => $enquiry['reference_no'], 'message' => $this->success_message($enquiry['reference_no'])));
	}

	/** Maps both forms onto the enquiry fields. Values are stored as typed and escaped on output. */
	private function read_input()
	{
		$post = function ($name) { return trim((string) $this->input->post($name)); };
		$is_message_form = $post('form_type') === 'message';
		return array(
			'full_name' => clean_header_value($post('name')),
			'email' => clean_header_value($post('email')),
			'phone' => $post('phone') === '' ? NULL : $post('phone'),
			'company' => $post('company') === '' ? NULL : $post('company'),
			'service_required' => clean_header_value($is_message_form ? $post('subject') : $post('service')),
			'message' => $is_message_form ? $post('message') : $post('details'),
			'source_page' => mb_substr(preg_replace('#[^a-zA-Z0-9/_-]#', '', $post('source_page')), 0, 120),
			'_phone_required' => ! $is_message_form,
			'_is_message_form' => $is_message_form,
		);
	}

	private function validate(array &$input)
	{
		$is_message_form = $input['_is_message_form'];
		$phone_required = $input['_phone_required'];
		unset($input['_is_message_form'], $input['_phone_required']);

		$errors = array();
		if (mb_strlen($input['full_name']) < 2 OR mb_strlen($input['full_name']) > 120)
		{
			$errors['name'] = 'Please enter your full name.';
		}
		if ($input['email'] === '' OR ! filter_var($input['email'], FILTER_VALIDATE_EMAIL) OR mb_strlen($input['email']) > 190)
		{
			$errors['email'] = 'Please enter a valid email address, like name@company.com.';
		}
		if ($phone_required OR $input['phone'] !== NULL)
		{
			$digits = strlen(preg_replace('/\D/', '', (string) $input['phone']));
			if ( ! preg_match('/^\+?[0-9(][0-9\s()-]{6,20}$/', (string) $input['phone']) OR $digits < 8 OR $digits > 15)
			{
				$errors['phone'] = 'Please enter a valid phone number, with the country code if you are outside India.';
			}
		}
		if ($input['company'] !== NULL && mb_strlen($input['company']) > 160)
		{
			$errors['company'] = 'Please shorten the company name.';
		}
		if ($is_message_form)
		{
			if ($input['service_required'] === '' OR mb_strlen($input['service_required']) > 160)
			{
				$errors['subject'] = 'Please enter a subject.';
			}
		}
		else
		{
			$allowed = array('Other');
			foreach ($this->settings_model->services_by('form_order') as $service)
			{
				$allowed[] = $service['form_label'] ? $service['form_label'] : $service['title'];
			}
			if ( ! in_array($input['service_required'], $allowed, TRUE))
			{
				$errors['service'] = 'Please choose a service.';
			}
		}
		if (mb_strlen($input['message']) < 10)
		{
			$errors[$is_message_form ? 'message' : 'details'] = 'Please tell us a little about your project.';
		}
		elseif (mb_strlen($input['message']) > 5000)
		{
			$errors[$is_message_form ? 'message' : 'details'] = 'Please keep your message under 5000 characters.';
		}
		return $errors;
	}

	private function success_message($reference)
	{
		$message = 'Thank you. We have received your enquiry';
		$message .= $reference !== '' ? ' (reference '.$reference.').' : '.';
		return $message.' Our team will review your requirements and get in touch with you within 24 hours.';
	}

	/** AJAX gets JSON. A browser with JavaScript disabled gets the contact page with the result. */
	private function respond($ajax, $status, array $payload)
	{
		if ($ajax)
		{
			return $this->json($payload, $status);
		}
		$this->output->set_status_header($status);
		$this->index($payload);
	}
}

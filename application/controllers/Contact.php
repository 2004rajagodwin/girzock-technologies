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
			return $this->respond($ajax, 422, array('ok' => FALSE, 'message' => 'Please check the highlighted fields and try again.', 'errors' => $errors));
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

		$payload = array('ok' => TRUE, 'reference' => $enquiry['reference_no'], 'message' => $this->success_message($enquiry['reference_no']));
		$this->load->library('enquiry_mailer');
		if ($ajax)
		{
			// The enquiry is saved, so the visitor can be told now. The emails follow in the same request
			// after the reply has been sent; each result is recorded in email_log and failures are retried.
			$this->reply_now($payload);
			$this->enquiry_mailer->notify($enquiry);
			exit;
		}
		$this->enquiry_mailer->notify($enquiry);
		$this->respond($ajax, 200, $payload);
	}

	/** Sends a JSON reply and closes the connection, so work after this does not keep the visitor waiting. */
	private function reply_now(array $payload)
	{
		ignore_user_abort(TRUE);
		@set_time_limit(120);
		// Releases the session file, so the visitor's next page does not wait for the emails to finish.
		if (session_status() === PHP_SESSION_ACTIVE)
		{
			session_write_close();
		}
		$body = json_encode($payload);
		if (function_exists('apache_setenv'))
		{
			@apache_setenv('no-gzip', '1');
		}
		while (ob_get_level() > 0)
		{
			ob_end_clean();
		}
		if ( ! headers_sent())
		{
			http_response_code(200);
			header('Content-Type: application/json; charset=utf-8');
			header('Cache-Control: no-store');
			header('X-Content-Type-Options: nosniff');
			header('Content-Length: '.strlen($body));
			header('Connection: close');
		}
		echo $body;
		flush();
		if (function_exists('fastcgi_finish_request'))
		{
			fastcgi_finish_request();
		}
	}

	/** Maps the three forms onto the enquiry fields. Values are stored as typed and escaped on output. */
	private function read_input()
	{
		$post = function ($name) { return trim((string) $this->input->post($name)); };
		$is_message_form = $post('form_type') === 'message';
		$is_popup_form = $post('form_type') === 'popup';
		$is_contact_form = $post('form_type') === 'contact';
		return array(
			'full_name' => clean_header_value($post('name')),
			'email' => clean_header_value($post('email')),
			'phone' => $post('phone') === '' ? NULL : $post('phone'),
			'company' => $post('company') === '' ? NULL : $post('company'),
			'service_required' => clean_header_value($is_message_form ? $post('subject') : $post('service')),
			'message' => ($is_message_form OR $is_contact_form) ? $post('message') : $post('details'),
			'source_page' => mb_substr(preg_replace('#[^a-zA-Z0-9/_-]#', '', $post('source_page')), 0, 120),
			'_phone_required' => ! $is_message_form,
			'_is_message_form' => $is_message_form,
			'_message_key' => ($is_message_form OR $is_contact_form) ? 'message' : 'details',
			'_message_optional' => $is_popup_form,
		);
	}

	private function validate(array &$input)
	{
		$is_message_form = $input['_is_message_form'];
		$phone_required = $input['_phone_required'];
		$message_key = $input['_message_key'];
		$message_optional = ! empty($input['_message_optional']);
		unset($input['_is_message_form'], $input['_phone_required'], $input['_message_key'], $input['_message_optional']);

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
			$allowed = array_merge($this->settings_model->form_services(), array('Other'));
			if ( ! in_array($input['service_required'], $allowed, TRUE))
			{
				$errors['service'] = 'Please choose a service.';
			}
		}
		if ($message_optional && $input['message'] === '')
		{
			// The popup form may be sent without a message.
		}
		elseif (mb_strlen($input['message']) < 10)
		{
			$errors[$message_key] = 'Please tell us a little about your project.';
		}
		elseif (mb_strlen($input['message']) > 5000)
		{
			$errors[$message_key] = 'Please keep your message under 5000 characters.';
		}
		return $errors;
	}

	private function success_message($reference)
	{
		return 'Thank you! Your enquiry has been submitted successfully.';
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

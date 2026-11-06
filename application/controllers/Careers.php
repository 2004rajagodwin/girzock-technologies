<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('career_model');
	}

	public function index()
	{
		$this->render('frontend/careers/index', array(
			'seo' => $this->seo->build(array('entity' => array('page', 'careers'), 'path' => 'careers',
				'breadcrumbs' => array('Home' => '', 'Careers' => NULL))),
			'openings' => $this->career_model->active(),
		));
	}

	public function detail($slug = '', array $form = array())
	{
		$job = $this->career_model->find_public($slug);
		$is_preview = FALSE;
		if ( ! $job && $this->preview_allowed('careers'))
		{
			$job = $this->career_model->find_for_preview($slug);
			$is_preview = (bool) $job;
		}
		if ( ! $job)
		{
			$this->not_found();
		}
		$path = 'careers/'.$job['slug'];
		$description = $job['summary'] ? $job['summary'] : plain_excerpt($job['description']);
		$posting = array(
			'@context' => 'https://schema.org', '@type' => 'JobPosting', 'title' => $job['title'],
			'description' => $job['description'] ? $job['description'] : '<p>'.$job['summary'].'</p>',
			'datePosted' => date('Y-m-d', strtotime($job['created_at'])),
			'employmentType' => $job['employment_type'],
			'hiringOrganization' => array('@type' => 'Organization', 'name' => setting('company_name'), 'sameAs' => $this->seo->canonical()),
			'jobLocation' => array('@type' => 'Place', 'address' => array('@type' => 'PostalAddress', 'addressLocality' => setting('address_locality'), 'addressRegion' => setting('address_region'), 'addressCountry' => setting('address_country'))),
		);
		if ($job['closes_at'])
		{
			$posting['validThrough'] = $job['closes_at'].'T23:59:59';
		}
		$this->render('frontend/careers/detail', array(
			'job' => $job,
			'is_preview' => $is_preview,
			'openings' => $this->career_model->active(),
			'accepting' => $this->career_model->accepts_applications($job),
			'errors' => isset($form['errors']) ? $form['errors'] : array(),
			'old' => isset($form['old']) ? $form['old'] : array(),
			'success' => isset($form['success']) ? $form['success'] : NULL,
			'seo' => $this->seo->build(array(
				'entity' => array('career', $job['id']),
				'is_preview' => $is_preview,
				'title' => $job['title'].' Job in Tirunelveli | '.setting('company_name'),
				'description' => $description,
				'path' => $path,
				'breadcrumbs' => array('Home' => '', 'Careers' => 'careers', $job['title'] => NULL),
				'schema' => $this->career_model->accepts_applications($job) ? array($posting) : array(),
			)),
		));
	}

	/** Handles the application form on a job page. */
	public function apply()
	{
		if ($this->input->method() !== 'post')
		{
			redirect('careers');
		}
		$job = $this->career_model->find_public((string) $this->input->post('job'));
		if ( ! $job)
		{
			$this->not_found();
		}
		$old = array();
		foreach (array('full_name', 'email', 'phone', 'experience', 'cover_letter') as $field)
		{
			$old[$field] = trim((string) $this->input->post($field));
		}

		// Spam trap: pretend success, store nothing.
		if ((string) $this->input->post('website') !== '')
		{
			return $this->detail($job['slug'], array('success' => 'Thank you. Your application has been received.'));
		}
		if ( ! $this->career_model->accepts_applications($job))
		{
			return $this->detail($job['slug'], array('errors' => array('form' => 'This position is not accepting applications at the moment.'), 'old' => $old));
		}

		$errors = array();
		if (mb_strlen($old['full_name']) < 2 OR mb_strlen($old['full_name']) > 120) { $errors['full_name'] = 'Please enter your full name.'; }
		if ( ! filter_var($old['email'], FILTER_VALIDATE_EMAIL) OR mb_strlen($old['email']) > 190) { $errors['email'] = 'Please enter a valid email address.'; }
		$digits = strlen(preg_replace('/\D/', '', $old['phone']));
		if ( ! preg_match('/^\+?[0-9(][0-9\s()-]{6,20}$/', $old['phone']) OR $digits < 8 OR $digits > 15) { $errors['phone'] = 'Please enter a valid phone number.'; }
		if ($old['experience'] === '' OR mb_strlen($old['experience']) > 120) { $errors['experience'] = 'Please tell us your experience, for example "2 years" or "Fresher".'; }
		if (mb_strlen($old['cover_letter']) > 5000) { $errors['cover_letter'] = 'Please keep the cover letter under 5000 characters.'; }
		if (empty($_FILES['resume']) OR ! is_array($_FILES['resume']) OR $_FILES['resume']['error'] === UPLOAD_ERR_NO_FILE) { $errors['resume'] = 'Please attach your resume.'; }

		if ($errors)
		{
			return $this->detail($job['slug'], array('errors' => $errors, 'old' => $old));
		}
		if ( ! $this->settings_model->throttle('application', 5, 3600))
		{
			return $this->detail($job['slug'], array('errors' => array('form' => 'Too many applications from this connection. Please try again later.'), 'old' => $old));
		}

		$this->load->model('application_model');
		$hash = hash('sha256', strtolower($old['email']).'|'.$job['id']);
		$duplicate = $this->application_model->find_duplicate($hash);
		if ($duplicate)
		{
			return $this->detail($job['slug'], array('success' => 'We already have your application for this position (reference '.$duplicate['reference_no'].'). We will be in touch.'));
		}

		$this->load->library('media_manager');
		$resume = $this->media_manager->store_resume($_FILES['resume']);
		if ( ! $resume)
		{
			return $this->detail($job['slug'], array('errors' => array('resume' => $this->media_manager->error), 'old' => $old));
		}

		$application = $this->application_model->create(array(
			'career_id' => $job['id'], 'position_title' => $job['title'],
			'full_name' => $old['full_name'], 'email' => $old['email'], 'phone' => $old['phone'], 'experience' => $old['experience'],
			'cover_letter' => $old['cover_letter'] === '' ? NULL : $old['cover_letter'],
			'resume_path' => $resume['path'], 'resume_original_name' => $resume['original_name'], 'resume_mime' => $resume['mime'],
			'content_hash' => $hash, 'ip_address' => $this->input->ip_address(),
		));
		if ( ! $application)
		{
			return $this->detail($job['slug'], array('errors' => array('form' => 'Your application could not be saved. Please try again.'), 'old' => $old));
		}

		$this->load->library('mailer');
		$this->mailer->send_once('application', $application['id'], 'company', setting('notification_email', setting('contact_email')),
			'New job application '.$application['reference_no'], 'emails/application_company', array('application' => $application), $application['email']);

		$this->detail($job['slug'], array('success' => 'Thank you. Your application has been received. Your reference number is '.$application['reference_no'].'.'));
	}
}

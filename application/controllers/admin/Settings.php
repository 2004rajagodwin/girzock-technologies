<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

	protected $module = 'settings';

	private function plain_fields()
	{
		return array(
			'general' => array('company_name' => 120, 'tagline' => 160, 'website_url' => 255, 'footer_description' => 500),
			'contact' => array('contact_email' => 190, 'notification_email' => 190, 'phone' => 30, 'business_address' => 300, 'address_short' => 160, 'address_locality' => 80, 'address_region' => 80, 'address_country' => 2),
			'seo' => array('default_meta_title' => 255, 'default_meta_description' => 500, 'google_analytics_id' => 30, 'gsc_verification' => 200, 'home_meta_keywords' => 1000, 'home_twitter_title' => 120, 'home_twitter_description' => 300, 'home_og_image_alt' => 255),
			'smtp' => array('smtp_host' => 190, 'smtp_port' => 6, 'smtp_user' => 190, 'smtp_crypto' => 3, 'smtp_from_email' => 190, 'smtp_from_name' => 120),
			'page_text' => array('portfolio_intro' => 600, 'case_studies_intro' => 600),
		);
	}

	public function index($errors = array())
	{
		$values = $this->settings_model->all();
		foreach (Settings_model::SECRET_KEYS as $secret)
		{
			$values[$secret.'_is_set'] = ! empty($values[$secret]);
			unset($values[$secret]); // a stored secret never reaches a browser
		}
		$this->load->library('mailer');
		$this->render('admin/settings/index', array(
			'page_title' => 'Website Settings',
			'values' => $values,
			'socials' => $this->settings_model->socials(),
			'errors' => $errors,
			'can_edit' => $this->auth->can('settings', 'edit'),
			'env_smtp_set' => (string) girzock_env('SMTP_HOST', '') !== '',
		));
	}

	public function save()
	{
		$this->require_post();
		$this->require_can('edit');
		$errors = array();
		$save = array();
		foreach ($this->plain_fields() as $group => $fields)
		{
			foreach ($fields as $key => $max)
			{
				$value = trim(str_replace("\r\n", "\n", (string) $this->input->post($key)));
				if (mb_strlen($value) > $max)
				{
					$errors[$key] = 'This value is too long.';
				}
				$save[$group][$key] = $value;
			}
		}
		foreach (array('company_name', 'contact_email', 'website_url') as $required)
		{
			$group = $required === 'contact_email' ? 'contact' : 'general';
			if ($save[$group][$required] === '')
			{
				$errors[$required] = 'This is required.';
			}
		}
		foreach (array('contact' => array('contact_email', 'notification_email'), 'smtp' => array('smtp_from_email')) as $group => $keys)
		{
			foreach ($keys as $key)
			{
				if ($save[$group][$key] !== '' && ! filter_var($save[$group][$key], FILTER_VALIDATE_EMAIL))
				{
					$errors[$key] = 'Enter a valid email address.';
				}
			}
		}
		if ($save['general']['website_url'] !== '' && ! is_safe_http_url($save['general']['website_url']))
		{
			$errors['website_url'] = 'Enter a full URL starting with https://.';
		}
		if ($save['smtp']['smtp_port'] !== '' && ! ctype_digit($save['smtp']['smtp_port']))
		{
			$errors['smtp_port'] = 'The port must be a number.';
		}
		if ( ! in_array($save['smtp']['smtp_crypto'], array('', 'tls', 'ssl'), TRUE))
		{
			$errors['smtp_crypto'] = 'Choose TLS, SSL or none.';
		}
		if ($save['seo']['google_analytics_id'] !== '' && ! preg_match('/^(G-[A-Z0-9]+|UA-[0-9-]+)$/', $save['seo']['google_analytics_id']))
		{
			$errors['google_analytics_id'] = 'Enter an ID like G-XXXXXXXXXX.';
		}

		$socials = array();
		foreach ($this->settings_model->socials() as $link)
		{
			$url = trim((string) $this->input->post('social_'.$link['platform']));
			if ($url !== '' && ! valid_social_url($link['platform'], $url))
			{
				$examples = array('linkedin' => 'https://www.linkedin.com/company/your-page', 'facebook' => 'https://www.facebook.com/your-page', 'instagram' => 'https://www.instagram.com/your-account/', 'whatsapp' => 'https://wa.me/91XXXXXXXXXX');
				$errors['social_'.$link['platform']] = 'Enter the full https address of your '.$link['label'].' profile'.(isset($examples[$link['platform']]) ? ', for example '.$examples[$link['platform']] : '').', or leave it empty to hide the icon.';
			}
			$socials[$link['platform']] = $url;
		}

		$this->load->library('media_manager');
		$branding = array();
		foreach (array('logo_color', 'logo_white', 'logo_icon', 'favicon', 'default_og_image') as $key)
		{
			if ( ! empty($_FILES[$key]) && $_FILES[$key]['error'] !== UPLOAD_ERR_NO_FILE)
			{
				$stored = $this->media_manager->store_image($_FILES[$key], $this->user['id']);
				if ($stored)
				{
					$branding[$key] = $stored['file_path'];
				}
				else
				{
					$errors[$key] = $this->media_manager->error;
				}
			}
		}

		if ($errors)
		{
			$this->output->set_status_header(422);
			$this->index($errors);
			return;
		}

		$this->db->trans_start();
		foreach ($save as $group => $values)
		{
			$this->settings_model->save_many($values, $group);
		}
		if ($branding)
		{
			$this->settings_model->save_many($branding, 'branding');
		}
		foreach ($socials as $platform => $url)
		{
			$this->settings_model->save_social($platform, $url);
		}
		$new_password = (string) $this->input->post('smtp_password');
		if ($this->input->post('smtp_password_clear'))
		{
			$this->settings_model->save_many(array('smtp_password' => ''), 'smtp');
		}
		elseif ($new_password !== '')
		{
			$encrypted = secret_encrypt($new_password);
			if ($encrypted === FALSE)
			{
				$this->flash_error('SECRET_BOX_KEY is missing from the private .env file, so the SMTP password was not saved.');
			}
			else
			{
				$this->settings_model->save_many(array('smtp_password' => $encrypted), 'smtp');
			}
		}
		$this->db->trans_complete();
		$this->log_action('update', NULL, 'Website settings changed');
		$this->flash_success('Settings saved. The website now uses the new values.');
		redirect('admin/settings');
	}

	public function test_email()
	{
		$this->require_post();
		$this->require_can('edit');
		$this->load->library('mailer');
		$html = '<p>This is a test message from your website settings. If you can read it, SMTP is working.</p>';
		if ($this->mailer->send($this->user['email'], 'Test email from '.setting('company_name'), $html))
		{
			$this->flash_success('Test email sent to '.$this->user['email'].'.');
		}
		else
		{
			$this->flash_error($this->mailer->last_error);
		}
		redirect('admin/settings#smtp');
	}
}

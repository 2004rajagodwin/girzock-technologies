<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Promotional Popup Management: every popup setting and image, with no source code editing. */
class Popup extends Admin_Controller {

	protected $module = 'popup';

	const MIN_IMAGE_SIDE = 300;
	const MAX_IMAGE_SIDE = 6000;
	const MAX_DELAY = 120;

	public function index(array $errors = array())
	{
		$this->render('admin/popup/index', array(
			'page_title' => 'Promotional Popup',
			'values' => $this->values(),
			'images' => array('desktop' => $this->image_details('popup_desktop_image'), 'mobile' => $this->image_details('popup_mobile_image')),
			'errors' => $errors,
			'can_edit' => $this->auth->can('popup', 'edit'),
		));
	}

	public function save()
	{
		$this->require_post();
		$this->require_can('edit');
		$input = $this->input->post(NULL, FALSE);
		$read = function ($key) use ($input) { return isset($input[$key]) && is_string($input[$key]) ? trim($input[$key]) : ''; };
		$errors = array();

		$title = $read('popup_title');
		if ($title === '' OR mb_strlen($title) > 120) { $errors['popup_title'] = 'Enter a title of up to 120 characters.'; }
		$description = $read('popup_description');
		if (mb_strlen($description) > 300) { $errors['popup_description'] = 'Keep the description to 300 characters or fewer.'; }
		$alt = $read('popup_image_alt');
		if (mb_strlen($alt) > 255) { $errors['popup_image_alt'] = 'Keep the image description to 255 characters or fewer.'; }
		$delay = $read('popup_delay');
		if ( ! ctype_digit($delay) OR (int) $delay > self::MAX_DELAY) { $errors['popup_delay'] = 'Enter a whole number of seconds from 0 to '.self::MAX_DELAY.'.'; }
		$reappear = $read('popup_reappear');
		if ( ! in_array($reappear, array('refresh', 'session', 'closed', 'days'), TRUE)) { $errors['popup_reappear'] = 'Choose when the popup may appear again.'; }
		foreach (array('popup_dismiss_days' => 365, 'popup_submit_days' => 365) as $key => $max)
		{
			if ( ! ctype_digit($read($key)) OR (int) $read($key) < 1 OR (int) $read($key) > $max) { $errors[$key] = 'Enter a whole number of days from 1 to '.$max.'.'; }
		}
		$start = $read('popup_start_date');
		$end = $read('popup_end_date');
		foreach (array('popup_start_date' => $start, 'popup_end_date' => $end) as $key => $date)
		{
			if ($date !== '' && ! $this->valid_date($date)) { $errors[$key] = 'Enter a valid date.'; }
		}
		if ($start !== '' && $end !== '' && ! isset($errors['popup_start_date']) && ! isset($errors['popup_end_date']) && $end < $start)
		{
			$errors['popup_end_date'] = 'The end date cannot be before the start date.';
		}

		$values = array(
			'popup_enabled' => empty($input['popup_enabled']) ? '0' : '1',
			'popup_title' => $title, 'popup_description' => $description, 'popup_image_alt' => $alt,
			'popup_delay' => $delay, 'popup_reappear' => $reappear,
			'popup_dismiss_days' => $read('popup_dismiss_days'), 'popup_submit_days' => $read('popup_submit_days'),
			'popup_start_date' => $start, 'popup_end_date' => $end,
			'popup_show_desktop' => empty($input['popup_show_desktop']) ? '0' : '1',
			'popup_show_mobile' => empty($input['popup_show_mobile']) ? '0' : '1',
		);

		// Checked before anything is stored, so a rejected form leaves no orphan upload behind.
		if ($errors)
		{
			$this->output->set_status_header(422);
			$this->index($errors);
			return;
		}

		$this->load->library('media_manager');
		foreach (array('popup_desktop_image', 'popup_mobile_image') as $key)
		{
			if ( ! empty($_FILES[$key]) && $_FILES[$key]['error'] !== UPLOAD_ERR_NO_FILE)
			{
				$stored = $this->media_manager->store_original_image($_FILES[$key], $this->user['id'], self::MIN_IMAGE_SIDE, self::MAX_IMAGE_SIDE);
				if ($stored)
				{
					$values[$key] = $stored['file_path'];
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

		$this->settings_model->save_many($values, 'popup');
		$this->log_action('update', NULL, 'Popup settings saved');
		$this->flash_success('Popup settings saved.');
		redirect('admin/popup');
	}

	/** Switches the popup on or off without touching any other setting. */
	public function toggle()
	{
		$this->require_post();
		$this->require_can('edit');
		$on = setting('popup_enabled', '0') !== '1';
		$this->settings_model->save_many(array('popup_enabled' => $on ? '1' : '0'), 'popup');
		$this->log_action('update', NULL, 'Popup turned '.($on ? 'on' : 'off'));
		$this->flash_success($on ? 'The popup is on.' : 'The popup is off.');
		redirect('admin/popup');
	}

	/** Removes an image from the popup. It needs an explicit confirmation sent with the request. */
	public function delete_image($which = '')
	{
		$this->require_post();
		$this->require_can('delete');
		$key = array('desktop' => 'popup_desktop_image', 'mobile' => 'popup_mobile_image');
		if ( ! isset($key[$which]))
		{
			show_404();
		}
		if ($this->input->post('confirm_delete') !== '1')
		{
			$this->flash_error('The image was not deleted, because the deletion was not confirmed.');
			redirect('admin/popup');
		}
		$path = setting($key[$which], '');
		$this->settings_model->save_many(array($key[$which] => ''), 'popup');
		$this->remove_upload_if_unused($path);
		$this->log_action('delete', NULL, 'Popup '.$which.' image removed');
		$this->flash_success('The '.$which.' image was removed. The popup shows only the form on that screen size until you add another image.');
		redirect('admin/popup');
	}

	/** Makes the popup appear again for every visitor who closed it or sent the form, for example after testing. */
	public function reset_visitors()
	{
		$this->require_post();
		$this->require_can('edit');
		$next = (string) ((int) setting('popup_visitor_version', '1') + 1);
		$this->settings_model->save_many(array('popup_visitor_version' => $next), 'popup');
		$this->log_action('update', NULL, 'Popup visitor dismissals reset');
		$this->flash_success('Done. Visitors who closed the popup or sent the form will see it again, following the rules below.');
		redirect('admin/popup');
	}

	/** Back to the original settings and images. Uploaded files stay in the Media Library. */
	public function reset()
	{
		$this->require_post();
		$this->require_can('edit');
		$defaults = Settings_model::popup_defaults();
		unset($defaults['popup_visitor_version']);
		$this->settings_model->save_many($defaults, 'popup');
		$this->log_action('update', NULL, 'Popup settings reset to defaults');
		$this->flash_success('Popup settings are back to the defaults.');
		redirect('admin/popup');
	}

	private function values()
	{
		$values = array();
		foreach (Settings_model::popup_defaults() as $key => $default)
		{
			$values[$key] = setting($key, '');
		}
		return $values;
	}

	private function image_details($key)
	{
		$path = setting($key, '');
		$file = FCPATH.ltrim($path, '/');
		if ($path === '' OR strpos($path, '..') !== FALSE OR ! is_file($file))
		{
			return array('path' => $path, 'exists' => FALSE);
		}
		$info = @getimagesize($file);
		return array('path' => $path, 'exists' => TRUE, 'width' => $info ? $info[0] : 0, 'height' => $info ? $info[1] : 0, 'bytes' => filesize($file), 'url' => base_url($path).'?v='.filemtime($file));
	}

	private function valid_date($date)
	{
		$parsed = DateTime::createFromFormat('Y-m-d', $date);
		return $parsed && $parsed->format('Y-m-d') === $date;
	}

	/** Only uploads are ever removed, never the supplied default images, and only if nothing else uses them. */
	private function remove_upload_if_unused($path)
	{
		if (strpos((string) $path, 'assets/uploads/') !== 0)
		{
			return;
		}
		$in_use = $this->db->where('setting_value', $path)->count_all_results('website_settings') > 0;
		if ($in_use)
		{
			return;
		}
		$this->load->library('media_manager');
		$this->media_manager->delete_files($path);
		$this->db->where('file_path', $path)->update('media_library', array('deleted_at' => date('Y-m-d H:i:s')));
	}
}

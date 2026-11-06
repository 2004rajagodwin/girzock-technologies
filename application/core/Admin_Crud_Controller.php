<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The list, create, edit and delete flow shared by Services, Products, Portfolio, Case Studies,
 * Blog and Careers. A subclass declares its fields and columns and can hook into saving.
 *
 * Field keys: name, label, type, required, max, help, options, group (main, side or display).
 * Types: text, textarea, richtext, lines, image, gallery, select, checkbox, number, url, date, datetime.
 */
abstract class Admin_Crud_Controller extends Admin_Controller {

	protected $model_name = '';
	protected $route = '';            // admin URL after admin/
	protected $public_base = NULL;    // public URL prefix, for slug redirects and view links
	protected $seo_type = NULL;       // seo_metadata entity_type
	protected $title_plural = '';
	protected $title_singular = '';
	protected $status_toggle = array(); // two statuses the list can flip between
	protected $status_filter = array();

	abstract protected function fields();
	abstract protected function columns();

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->model_name);
	}

	protected function model()
	{
		return $this->{$this->model_name};
	}

	/* ---------- hooks ---------- */

	/** Final adjustments to the row before saving. Add messages to $errors to refuse the save. */
	protected function prepare(array $data, $id, array &$errors)
	{
		return $data;
	}

	/** Runs inside the save transaction. */
	protected function after_save($id, array $data)
	{
	}

	/** Extra values for the form view, such as loaded relations. */
	protected function form_values(array $values, $id)
	{
		return $values;
	}

	protected function public_path(array $row)
	{
		return $this->public_base === NULL ? NULL : $this->public_base.'/'.$row['slug'];
	}

	/* ---------- actions ---------- */

	public function index()
	{
		$filters = array(
			'q' => mb_substr(trim((string) $this->input->get('q')), 0, 100),
			'status' => in_array($this->input->get('status'), $this->status_filter, TRUE) ? $this->input->get('status') : '',
		);
		$per_page = (int) $this->config->item('gz_admin_per_page');
		$per_page = $per_page ? $per_page : 15;
		$page = $this->page_number();
		$total = $this->model()->count_filtered($filters);

		$this->render('admin/crud/index', array(
			'page_title' => $this->title_plural,
			'route' => $this->route,
			'singular' => $this->title_singular,
			'columns' => $this->columns(),
			'rows' => $this->model()->list_filtered($filters, $per_page, ($page - 1) * $per_page),
			'filters' => $filters,
			'status_filter' => $this->status_filter,
			'status_toggle' => $this->status_toggle,
			'total' => $total,
			'pagination' => $this->pagination($total, $per_page, $page),
			'can_create' => $this->auth->can($this->module, 'create'),
			'can_edit' => $this->auth->can($this->module, 'edit'),
			'can_delete' => $this->auth->can($this->module, 'delete'),
			'public_base' => $this->public_base,
		));
	}

	public function create()
	{
		$this->require_can('create');
		$this->show_form(NULL, $this->form_values(array(), NULL));
	}

	public function edit($id = 0)
	{
		$this->require_can('edit');
		$row = $this->model()->find($id);
		if ( ! $row)
		{
			show_404();
		}
		if ($this->seo_type)
		{
			$row = array_merge($row, $this->seo_values($row['id']));
		}
		$this->show_form($row['id'], $this->form_values($row, $row['id']));
	}

	private function seo_values($id)
	{
		$seo = $this->settings_model->seo($this->seo_type, $id);
		$out = array();
		foreach (array('meta_title', 'meta_description', 'focus_keyword', 'og_title', 'og_description', 'canonical_url', 'og_image', 'robots') as $key)
		{
			$out['seo_'.$key] = isset($seo[$key]) ? $seo[$key] : '';
		}
		return $out;
	}

	protected function show_form($id, array $values, array $errors = array())
	{
		$this->render('admin/crud/form', array(
			'page_title' => ($id ? 'Edit ' : 'Add ').$this->title_singular,
			'route' => $this->route,
			'plural' => $this->title_plural,
			'id' => $id,
			'fields' => $this->fields(),
			'values' => $values,
			'errors' => $errors,
			'has_seo' => (bool) $this->seo_type,
			'has_slug' => (bool) $this->public_base,
			'public_url' => ($id && $this->public_base && ! empty($values['slug'])) ? site_url($this->public_base.'/'.$values['slug']) : NULL,
		));
	}

	public function save($id = 0)
	{
		$this->require_post();
		$id = (int) $id;
		$this->require_can($id ? 'edit' : 'create');
		$existing = NULL;
		if ($id)
		{
			$existing = $this->model()->find($id);
			if ( ! $existing)
			{
				show_404();
			}
		}

		$errors = array();
		$data = $this->collect($errors, $existing);

		if ($this->public_base)
		{
			$source = trim((string) $this->input->post('slug'));
			$source = $source !== '' ? $source : (string) $data['title'];
			$data['slug'] = $this->model()->unique_slug($source, $id ? $id : NULL);
		}
		$data = $this->prepare($data, $id, $errors);

		$seo = array();
		if ($this->seo_type)
		{
			foreach (array('meta_title' => 255, 'meta_description' => 500, 'focus_keyword' => 120, 'og_title' => 255, 'og_description' => 500, 'canonical_url' => 255, 'robots' => 40) as $key => $max)
			{
				$seo[$key] = trim((string) $this->input->post('seo_'.$key));
				if (mb_strlen($seo[$key]) > $max)
				{
					$errors['seo_'.$key] = 'This is too long.';
				}
			}
			if ($seo['canonical_url'] !== '' && ! is_safe_http_url($seo['canonical_url']))
			{
				$errors['seo_canonical_url'] = 'Enter a full URL starting with http:// or https://.';
			}
			if ( ! in_array($seo['robots'], array('', 'index, follow', 'noindex, follow', 'noindex, nofollow'), TRUE))
			{
				$errors['seo_robots'] = 'Choose a value from the list.';
			}
			$seo['og_image'] = $this->image_value('seo_og_image', 'Social sharing image', $errors);
		}

		if ($errors)
		{
			$values = array_merge($existing ? $existing : array(), $this->input->post(NULL, FALSE));
			$this->output->set_status_header(422);
			$this->show_form($id ? $id : NULL, $values, $errors);
			return;
		}

		$this->db->trans_start();
		if ($id)
		{
			$this->model()->update_by_id($id, $data);
		}
		else
		{
			$id = $this->model()->create($data);
		}
		if ($this->seo_type)
		{
			$this->settings_model->save_seo($this->seo_type, $id, $seo);
		}
		if ($this->public_base && $existing && $existing['slug'] !== $data['slug'])
		{
			$this->settings_model->add_redirect($this->public_base.'/'.$existing['slug'], $this->public_base.'/'.$data['slug']);
		}
		$this->after_save($id, $data);
		$this->db->trans_complete();

		if ( ! $this->db->trans_status())
		{
			log_message('error', 'Admin save failed in '.$this->route);
			$this->flash_error('The record could not be saved. Please try again.');
			redirect('admin/'.$this->route);
		}
		$this->log_action($existing ? 'update' : 'create', $id, $data['title']);
		$this->flash_success($this->title_singular.' saved.');
		redirect('admin/'.$this->route.'/edit/'.$id);
	}

	/** Soft delete. The public URL then answers 410 Gone. */
	public function delete($id = 0)
	{
		$this->require_post();
		$this->require_can('delete');
		$row = $this->model()->find($id);
		if ( ! $row)
		{
			show_404();
		}
		$this->db->trans_start();
		$this->model()->remove($row['id']);
		if ($this->public_base)
		{
			$this->settings_model->add_redirect($this->public_path($row), NULL, 410);
		}
		$this->db->trans_complete();
		$this->log_action('delete', $row['id'], $row['title']);
		$this->flash_success($this->title_singular.' deleted.');
		redirect('admin/'.$this->route);
	}

	/** AJAX status switch from the list. */
	public function toggle($id = 0)
	{
		$this->require_post();
		$this->require_can('edit');
		$row = $this->model()->find($id);
		if ( ! $row OR ! $this->status_toggle OR ! in_array($row['status'], $this->status_toggle, TRUE))
		{
			return $this->json(array('ok' => FALSE, 'message' => 'This status cannot be switched from the list.'), 422);
		}
		$new = $row['status'] === $this->status_toggle[0] ? $this->status_toggle[1] : $this->status_toggle[0];
		$this->model()->update_by_id($row['id'], array('status' => $new));
		$this->log_action('status', $row['id'], $row['title'].' set to '.$new);
		$this->json(array('ok' => TRUE, 'status' => $new, 'badge' => status_badge($new)));
	}

	/* ---------- input handling ---------- */

	private function collect(array &$errors, $existing)
	{
		$this->load->library('html_sanitizer');
		$data = array();
		foreach ($this->fields() as $field)
		{
			$name = $field['name'];
			$type = $field['type'];
			$label = $field['label'];
			if ( ! empty($field['virtual']))
			{
				continue;
			}
			if ($type === 'checkbox')
			{
				$data[$name] = $this->input->post($name) ? 1 : 0;
				continue;
			}
			if ($type === 'image')
			{
				$data[$name] = $this->image_value($name, $label, $errors);
				if ( ! empty($field['required']) && ! $data[$name])
				{
					$errors[$name] = $label.' is required.';
				}
				continue;
			}
			if ($type === 'gallery')
			{
				$data[$name] = $this->gallery_value($name, $label, $errors);
				continue;
			}

			$value = trim((string) $this->input->post($name));
			if ($type === 'richtext')
			{
				$value = $this->html_sanitizer->clean($value);
			}
			if ( ! empty($field['required']) && trim(strip_tags($value)) === '')
			{
				$errors[$name] = $label.' is required.';
			}
			if ( ! empty($field['max']) && mb_strlen($value) > $field['max'])
			{
				$errors[$name] = $label.' must be '.$field['max'].' characters or fewer.';
			}
			if ($value !== '')
			{
				if ($type === 'url' && ! is_safe_http_url($value))
				{
					$errors[$name] = 'Enter a full URL starting with http:// or https://.';
				}
				if ($type === 'number' && ! is_numeric($value))
				{
					$errors[$name] = $label.' must be a number.';
				}
				if ($type === 'select' && ! array_key_exists($value, $field['options']))
				{
					$errors[$name] = 'Choose a value from the list.';
				}
				if ($type === 'date' && ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value))
				{
					$errors[$name] = 'Enter a valid date.';
				}
				if ($type === 'datetime')
				{
					$time = strtotime($value);
					if ($time === FALSE)
					{
						$errors[$name] = 'Enter a valid date and time.';
					}
					else
					{
						$value = date('Y-m-d H:i:s', $time);
					}
				}
			}
			if ($value === '')
			{
				$value = $type === 'number' ? 0 : NULL;
			}
			$data[$name] = $value;
		}
		return $data;
	}

	/** A new upload wins; otherwise the posted path, which must be inside assets/. */
	protected function image_value($name, $label, array &$errors)
	{
		$this->load->library('media_manager');
		if ( ! empty($_FILES[$name]) && ! is_array($_FILES[$name]['name']) && $_FILES[$name]['error'] !== UPLOAD_ERR_NO_FILE)
		{
			$stored = $this->media_manager->store_image($_FILES[$name], $this->user['id']);
			if ( ! $stored)
			{
				$errors[$name] = $label.': '.$this->media_manager->error;
				return trim((string) $this->input->post($name));
			}
			return $stored['file_path'];
		}
		$path = trim((string) $this->input->post($name));
		if ($path !== '' && ! is_safe_asset_path($path))
		{
			$errors[$name] = $label.': choose a file from the media library.';
			return NULL;
		}
		return $path === '' ? NULL : $path;
	}

	private function gallery_value($name, $label, array &$errors)
	{
		$lines = array();
		foreach (text_lines($this->input->post($name)) as $path)
		{
			if (is_safe_asset_path($path))
			{
				$lines[] = $path;
			}
			else
			{
				$errors[$name] = $label.': one image path per line, from the media library.';
			}
		}
		$this->load->library('media_manager');
		$key = $name.'_files';
		if ( ! empty($_FILES[$key]['name']) && is_array($_FILES[$key]['name']))
		{
			foreach ($_FILES[$key]['name'] as $i => $original)
			{
				if ($_FILES[$key]['error'][$i] === UPLOAD_ERR_NO_FILE)
				{
					continue;
				}
				$file = array('name' => $original, 'type' => $_FILES[$key]['type'][$i], 'tmp_name' => $_FILES[$key]['tmp_name'][$i], 'error' => $_FILES[$key]['error'][$i], 'size' => $_FILES[$key]['size'][$i]);
				$stored = $this->media_manager->store_image($file, $this->user['id']);
				if ($stored)
				{
					$lines[] = $stored['file_path'];
				}
				else
				{
					$errors[$name] = $label.': '.$this->media_manager->error;
				}
			}
		}
		return $lines ? implode("\n", $lines) : NULL;
	}

	/** select options from content_categories. */
	protected function content_category_options($type)
	{
		$options = array('' => 'No category');
		foreach ($this->db->where('type', $type)->order_by('sort_order', 'ASC')->get('content_categories')->result_array() as $row)
		{
			$options[$row['id']] = $row['name'];
		}
		return $options;
	}
}

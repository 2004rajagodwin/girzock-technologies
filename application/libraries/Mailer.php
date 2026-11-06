<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SMTP email using the CodeIgniter email library. Settings from the admin panel override the
 * private .env defaults. A failed send is logged and never throws, so a saved record survives
 * any mail problem. send_once() guarantees one delivery per record and recipient.
 */
class Mailer {

	private $CI;
	public $last_error = '';

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function smtp_config()
	{
		$s = $this->CI->settings_model;
		$stored_password = $s->get('smtp_password');
		$server = array(
			'host' => (string) girzock_env('SMTP_HOST', ''),
			'port' => (int) girzock_env('SMTP_PORT', '587'),
			'user' => (string) girzock_env('SMTP_USER', ''),
			'pass' => (string) girzock_env('SMTP_PASS', ''),
			'crypto' => (string) girzock_env('SMTP_CRYPTO', 'tls'),
		);
		// A host saved in the admin panel means the panel's values apply as one set, so that
		// "no encryption" or "no login" there is not overridden by the .env defaults.
		if ($s->get('smtp_host') !== '')
		{
			$server = array(
				'host' => $s->get('smtp_host'),
				'port' => (int) $s->get('smtp_port', '587'),
				'user' => $s->get('smtp_user'),
				'pass' => $stored_password !== '' ? secret_decrypt($stored_password) : '',
				'crypto' => $s->get('smtp_crypto'),
			);
		}
		return $server + array(
			'from_email' => $s->get('smtp_from_email', $s->get('contact_email')),
			'from_name' => $s->get('smtp_from_name', $s->get('company_name')),
		);
	}

	public function is_configured()
	{
		$config = $this->smtp_config();
		return $config['host'] !== '';
	}

	/**
	 * Why the SMTP login cannot be attempted, or NULL if it can. An account with an empty
	 * password is never sent to the mail server. An empty username means no login is needed.
	 */
	public function credential_problem()
	{
		$smtp = $this->smtp_config();
		if ($smtp['host'] === '')
		{
			return NULL;
		}
		$s = $this->CI->settings_model;
		if ($s->get('smtp_host') !== '' && $s->get('smtp_password') !== '' && $smtp['pass'] === '')
		{
			return 'The saved SMTP password cannot be decrypted. Check SECRET_BOX_KEY in the private .env file, or enter the password again in Website Settings.';
		}
		if ($smtp['user'] !== '' && $smtp['pass'] === '')
		{
			return 'An SMTP username is set but no password is saved.';
		}
		return NULL;
	}

	/**
	 * Sends one message. Returns TRUE or FALSE, with the reason in $last_error.
	 */
	public function send($to, $subject, $html, $reply_to = NULL)
	{
		$this->last_error = '';
		$to = clean_header_value($to);
		if ( ! filter_var($to, FILTER_VALIDATE_EMAIL))
		{
			$this->last_error = 'Invalid recipient address.';
			return FALSE;
		}
		$smtp = $this->smtp_config();
		if ($smtp['host'] === '')
		{
			$this->last_error = 'SMTP is not configured.';
			return FALSE;
		}
		$credential_problem = $this->credential_problem();
		if ($credential_problem !== NULL)
		{
			$this->last_error = $credential_problem;
			log_message('error', 'Mailer: '.$credential_problem);
			return FALSE;
		}

		$this->CI->load->library('email');
		$this->CI->email->clear(TRUE);
		$this->CI->email->initialize(array(
			'protocol' => 'smtp',
			'smtp_host' => $smtp['host'],
			'smtp_port' => $smtp['port'],
			'smtp_user' => $smtp['user'],
			'smtp_pass' => $smtp['pass'],
			'smtp_crypto' => in_array($smtp['crypto'], array('tls', 'ssl'), TRUE) ? $smtp['crypto'] : '',
			'smtp_timeout' => 8,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n",
			'crlf' => "\r\n",
			'wordwrap' => FALSE,
			'validate' => TRUE,
		));

		try
		{
			$this->CI->email->from(clean_header_value($smtp['from_email']), clean_header_value($smtp['from_name']));
			if ($reply_to && filter_var(clean_header_value($reply_to), FILTER_VALIDATE_EMAIL))
			{
				$this->CI->email->reply_to(clean_header_value($reply_to));
			}
			$this->CI->email->to($to);
			$this->CI->email->subject(clean_header_value($subject));
			$this->CI->email->message($html);
			$this->CI->email->set_alt_message(trim(html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8')));
			if (@$this->CI->email->send(FALSE))
			{
				return TRUE;
			}
			$this->last_error = 'SMTP delivery failed: '.$this->failure_reason();
		}
		catch (Throwable $exception)
		{
			$this->last_error = 'SMTP delivery failed: '.mb_substr($exception->getMessage(), 0, 200);
		}
		log_message('error', 'Mailer: '.$this->last_error);
		return FALSE;
	}

	/**
	 * Picks the line of the SMTP transcript that explains the failure. The transcript is never
	 * stored whole, and lines from the login exchange are skipped, so credentials cannot be logged.
	 */
	private function failure_reason()
	{
		$reason = 'the mail server did not accept the message.';
		foreach (preg_split('/\r\n|\r|\n/', strip_tags((string) $this->CI->email->print_debugger(array()))) as $line)
		{
			$line = trim($line);
			if ($line === '' OR stripos($line, 'auth') !== FALSE OR stripos($line, 'password') !== FALSE)
			{
				continue;
			}
			if (preg_match('/unable|failed|error|denied|refused|timed out|^[45]\d\d\b/i', $line))
			{
				$reason = $line;
				break;
			}
		}
		return mb_substr($reason, 0, 200);
	}

	/**
	 * One email per (entity, recipient type). A row already marked sent is never re-sent, so
	 * retries and double submissions cannot create duplicates. Failed rows can be retried.
	 */
	public function send_once($entity_type, $entity_id, $recipient_type, $to, $subject, $view, array $view_data, $reply_to = NULL)
	{
		$key = array('entity_type' => $entity_type, 'entity_id' => (int) $entity_id, 'recipient_type' => $recipient_type);
		$row = $this->CI->db->get_where('email_log', $key, 1)->row_array();
		if ($row && $row['status'] === 'sent')
		{
			return TRUE;
		}
		if ( ! $row)
		{
			// INSERT IGNORE plus the unique key closes the race between two parallel requests.
			$this->CI->db->query('INSERT IGNORE INTO email_log (entity_type, entity_id, recipient_type, recipient, subject, status) VALUES (?, ?, ?, ?, ?, ?)',
				array($entity_type, (int) $entity_id, $recipient_type, $to, mb_substr($subject, 0, 255), 'pending'));
			if ($this->CI->db->affected_rows() === 0)
			{
				return TRUE;
			}
		}

		if ( ! $this->is_configured())
		{
			$this->record($key, 'skipped', 'SMTP is not configured.');
			log_message('error', 'Mailer: skipped '.$entity_type.' #'.$entity_id.' '.$recipient_type.': SMTP is not configured.');
			return FALSE;
		}

		$html = $this->CI->load->view($view, $view_data, TRUE);
		$ok = $this->send($to, $subject, $html, $reply_to);
		$this->record($key, $ok ? 'sent' : 'failed', $ok ? NULL : $this->last_error);
		return $ok;
	}

	private function record(array $key, $status, $error)
	{
		$data = array('status' => $status, 'error_message' => $error === NULL ? NULL : mb_substr($error, 0, 500));
		if ($status === 'sent')
		{
			$data['sent_at'] = date('Y-m-d H:i:s');
		}
		$this->CI->db->set('attempts', 'attempts + 1', FALSE)->where($key)->update('email_log', $data);
	}
}

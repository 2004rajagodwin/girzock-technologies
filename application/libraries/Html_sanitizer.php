<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Allowlist sanitiser for rich text saved from the admin editor. Anything not listed is removed:
 * scripts, event handlers, iframes, styles and javascript: URLs cannot reach a public page.
 */
class Html_sanitizer {

	private $allowed = array(
		'p' => array('class'), 'br' => array(), 'hr' => array(), 'strong' => array(), 'b' => array(), 'em' => array(), 'i' => array(),
		'u' => array(), 's' => array(), 'blockquote' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(), 'code' => array(), 'pre' => array(),
		'h2' => array('class'), 'h3' => array('class'), 'h4' => array('class'), 'h5' => array('class'),
		'a' => array('href', 'title', 'target', 'rel'), 'img' => array('src', 'alt', 'width', 'height', 'loading'),
		'div' => array('class'), 'span' => array('class'),
		'table' => array(), 'thead' => array(), 'tbody' => array(), 'tr' => array(), 'th' => array(), 'td' => array(),
	);

	public function clean($html)
	{
		$html = trim((string) $html);
		if ($html === '')
		{
			return '';
		}
		$dom = new DOMDocument('1.0', 'UTF-8');
		$previous = libxml_use_internal_errors(TRUE);
		$dom->loadHTML('<?xml encoding="UTF-8"><!DOCTYPE html><html><body><div id="gz-root">'.$html.'</div></body></html>', LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
		libxml_clear_errors();
		libxml_use_internal_errors($previous);

		$root = $dom->getElementById('gz-root');
		if ( ! $root)
		{
			return '';
		}
		$this->walk($root);

		$out = '';
		foreach ($root->childNodes as $child)
		{
			$out .= $dom->saveHTML($child);
		}
		return trim($out);
	}

	private function walk(DOMNode $node)
	{
		foreach (iterator_to_array($node->childNodes) as $child)
		{
			if ($child instanceof DOMComment OR $child instanceof DOMProcessingInstruction)
			{
				$node->removeChild($child);
				continue;
			}
			if ( ! ($child instanceof DOMElement))
			{
				continue;
			}
			$tag = strtolower($child->tagName);
			if (in_array($tag, array('script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'svg', 'math', 'link', 'meta', 'base'), TRUE))
			{
				$node->removeChild($child);
				continue;
			}
			if ( ! isset($this->allowed[$tag]))
			{
				// Unknown wrapper: keep the text and safe children, drop the element.
				$this->walk($child);
				while ($child->firstChild)
				{
					$node->insertBefore($child->firstChild, $child);
				}
				$node->removeChild($child);
				continue;
			}
			foreach (iterator_to_array($child->attributes) as $attribute)
			{
				$name = strtolower($attribute->name);
				if ( ! in_array($name, $this->allowed[$tag], TRUE))
				{
					$child->removeAttribute($attribute->name);
					continue;
				}
				if (in_array($name, array('href', 'src'), TRUE) && ! $this->safe_url($attribute->value, $name))
				{
					$child->removeAttribute($attribute->name);
				}
			}
			if ($tag === 'a' && $child->getAttribute('target') === '_blank')
			{
				$child->setAttribute('rel', 'noopener noreferrer');
			}
			$this->walk($child);
		}
	}

	private function safe_url($url, $attribute)
	{
		// Browsers ignore whitespace and control characters inside a scheme, so remove them first.
		$url = preg_replace('/[\x00-\x20]+/', '', html_entity_decode((string) $url, ENT_QUOTES, 'UTF-8'));
		if (preg_match('#^https?://#i', $url) OR preg_match('#^assets/[^:]*$#', $url))
		{
			return TRUE;
		}
		if ($attribute === 'href')
		{
			return (bool) preg_match('#^(mailto:|tel:|\#|/[^/]|site:[a-z0-9/-]*$)#i', $url);
		}
		return FALSE;
	}
}

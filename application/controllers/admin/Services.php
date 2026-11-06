<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends Admin_Crud_Controller {

	protected $module = 'services';
	protected $model_name = 'service_model';
	protected $route = 'services';
	protected $public_base = 'services';
	protected $seo_type = 'service';
	protected $title_plural = 'Services';
	protected $title_singular = 'Service';
	protected $status_toggle = array('active', 'disabled');
	protected $status_filter = array('active', 'disabled', 'archived');

	protected function columns()
	{
		return array('image' => array('Image', 'image'), 'title' => array('Service', 'text'), 'page_order' => array('Order', 'text'), 'updated_at' => array('Updated', 'date'), 'status' => array('Status', 'status'));
	}

	protected function fields()
	{
		$order_help = '0 hides the service from this place. Lower numbers appear first.';
		return array(
			array('name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => TRUE, 'max' => 160, 'group' => 'main'),
			array('name' => 'short_description', 'label' => 'Short description', 'type' => 'textarea', 'max' => 500, 'group' => 'main', 'help' => 'Shown on service cards and as the default SEO description.'),
			array('name' => 'headline', 'label' => 'Page heading', 'type' => 'text', 'max' => 200, 'group' => 'main', 'help' => 'The H2 heading at the top of the service page.'),
			array('name' => 'description', 'label' => 'Introduction', 'type' => 'richtext', 'group' => 'main'),
			array('name' => 'problems', 'label' => 'Customer problems and solutions', 'type' => 'lines', 'group' => 'main', 'help' => 'One per line: Problem | How we solve it'),
			array('name' => 'benefits', 'label' => 'Features and benefits', 'type' => 'lines', 'group' => 'main', 'help' => 'One per line: Feature | Benefit'),
			array('name' => 'workflow', 'label' => 'How we work', 'type' => 'lines', 'group' => 'main', 'help' => 'One step per line: Step | What happens'),
			array('name' => 'use_cases', 'label' => 'Suitable for', 'type' => 'lines', 'group' => 'main', 'help' => 'One use case per line.'),
			array('name' => 'faqs', 'label' => 'FAQs', 'type' => 'lines', 'group' => 'main', 'help' => 'One per line: Question | Answer'),
			array('name' => 'cta_text', 'label' => 'Call to action', 'type' => 'text', 'max' => 300, 'group' => 'main'),
			array('name' => 'related_services', 'label' => 'Related services', 'type' => 'text', 'max' => 500, 'group' => 'main', 'help' => 'URL slugs of related services, separated by commas.'),
			array('name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => TRUE, 'options' => array('active' => 'Active', 'disabled' => 'Disabled', 'archived' => 'Archived'), 'group' => 'side'),
			array('name' => 'image', 'label' => 'Service image', 'type' => 'image', 'group' => 'side'),
			array('name' => 'icon', 'label' => 'Icon', 'type' => 'image', 'group' => 'side'),
			array('name' => 'page_layout', 'label' => 'Services page position', 'type' => 'select', 'required' => TRUE, 'options' => array('card' => 'Large card (first five)', 'feature' => '"More services" card', 'none' => 'Not listed'), 'group' => 'side'),
			array('name' => 'page_order', 'label' => 'Services page order', 'type' => 'number', 'group' => 'side'),
			array('name' => 'legacy_anchor', 'label' => 'Page anchor', 'type' => 'text', 'max' => 60, 'group' => 'side', 'help' => 'Keeps older links such as /services#web-design working.'),
			array('name' => 'menu_title', 'label' => 'Menu title', 'type' => 'text', 'max' => 160, 'group' => 'display'),
			array('name' => 'menu_description', 'label' => 'Menu description', 'type' => 'text', 'max' => 255, 'group' => 'display'),
			array('name' => 'menu_image', 'label' => 'Mega menu image', 'type' => 'image', 'group' => 'display'),
			array('name' => 'menu_order', 'label' => 'Homepage mega menu order', 'type' => 'number', 'group' => 'display', 'help' => $order_help),
			array('name' => 'footer_title', 'label' => 'Footer and sub-menu title', 'type' => 'text', 'max' => 160, 'group' => 'display'),
			array('name' => 'footer_order', 'label' => 'Footer and sub-menu order', 'type' => 'number', 'group' => 'display', 'help' => $order_help),
			array('name' => 'home_core_label', 'label' => 'Homepage slider label', 'type' => 'text', 'max' => 40, 'group' => 'display'),
			array('name' => 'home_core_title', 'label' => 'Homepage slider title', 'type' => 'text', 'max' => 160, 'group' => 'display'),
			array('name' => 'home_core_image', 'label' => 'Homepage slider image', 'type' => 'image', 'group' => 'display'),
			array('name' => 'home_core_order', 'label' => 'Homepage slider order', 'type' => 'number', 'group' => 'display', 'help' => $order_help),
			array('name' => 'home_overview_title', 'label' => 'Homepage overview title', 'type' => 'text', 'max' => 160, 'group' => 'display'),
			array('name' => 'home_overview_text', 'label' => 'Homepage overview text', 'type' => 'textarea', 'max' => 500, 'group' => 'display'),
			array('name' => 'home_overview_image', 'label' => 'Homepage overview image', 'type' => 'image', 'group' => 'display'),
			array('name' => 'home_overview_order', 'label' => 'Homepage overview order', 'type' => 'number', 'group' => 'display', 'help' => 'The first five services with a value above 0 are shown.'),
			array('name' => 'form_label', 'label' => 'Enquiry form label', 'type' => 'text', 'max' => 160, 'group' => 'display'),
			array('name' => 'form_order', 'label' => 'Enquiry form order', 'type' => 'number', 'group' => 'display', 'help' => $order_help),
		);
	}
}

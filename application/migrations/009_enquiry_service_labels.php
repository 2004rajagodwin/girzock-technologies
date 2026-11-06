<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gives every service a clear enquiry form label and order, so AWS appears too. A label an admin
 * has already changed is kept. Past enquiries store the label as sent, so they are not affected.
 */
class Migration_Enquiry_service_labels extends CI_Migration {

	public function up()
	{
		$labels = array(
			// slug => array(order, old label, new label)
			'website-development' => array(1, 'Website Development', 'Website Development'),
			'custom-software-development' => array(2, 'Custom Software Development', 'Custom Software Development'),
			'web-application-development' => array(3, 'Web Application Development', 'Web Application Development'),
			'ui-ux-design' => array(4, 'UI/UX Design', 'UI/UX Design'),
			'wordpress-development' => array(5, 'WordPress Development', 'WordPress Development'),
			'e-commerce-development' => array(6, 'E-commerce Development', 'E-commerce Development'),
			'mobile-app-development' => array(7, 'Mobile Application Development', 'Mobile App Development'),
			'cloud-solutions' => array(8, 'Cloud & AWS Solutions', 'Cloud Solutions'),
			'aws-cloud-solutions' => array(9, NULL, 'AWS Cloud Solutions'),
			'crm-business-management-software' => array(10, 'CRM & Business Management Software', 'CRM & Business Software'),
			'api-development-integration' => array(11, 'API Development & Integration', 'API Development'),
			'website-maintenance-support' => array(12, 'Website Maintenance & Support', 'Website Maintenance'),
			'seo-services' => array(13, 'Search Engine Optimization (SEO)', 'SEO Services'),
			'digital-marketing-services' => array(14, 'Digital Marketing', 'Digital Marketing'),
			'digital-transformation' => array(15, 'Digital Transformation & Automation', 'Digital Transformation'),
			'it-consulting' => array(16, 'IT Consulting', 'IT Consulting'),
		);
		$this->db->trans_start();
		foreach ($labels as $slug => $item)
		{
			$row = $this->db->select('id, form_label')->get_where('services', array('slug' => $slug), 1)->row_array();
			if ( ! $row)
			{
				continue;
			}
			$update = array('form_order' => $item[0]);
			if ((string) $row['form_label'] === (string) $item[1])
			{
				$update['form_label'] = $item[2];
			}
			$this->db->where('id', $row['id'])->update('services', $update);
		}
		$this->db->trans_complete();
		if ( ! $this->db->trans_status())
		{
			show_error('The service label migration could not be applied, and no changes were kept.');
		}
	}

	public function down()
	{
		// Labels are ordinary admin content and are not reverted automatically.
	}
}

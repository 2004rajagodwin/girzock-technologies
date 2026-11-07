<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* Admin modules used by the role permission matrix. */
$config['gz_modules'] = array(
	'dashboard' => 'Dashboard', 'enquiries' => 'Enquiries', 'services' => 'Services', 'products' => 'Products',
	'portfolio' => 'Portfolio', 'case_studies' => 'Case Studies', 'blog' => 'Blog', 'careers' => 'Careers',
	'applications' => 'Job Applications', 'media' => 'Media Library', 'categories' => 'Categories', 'seo' => 'SEO',
	'users' => 'Admin Users', 'settings' => 'Website Settings', 'popup' => 'Promotional Popup',
);

$config['gz_enquiry_statuses'] = array('new', 'contacted', 'in_progress', 'follow_up', 'converted', 'closed');
$config['gz_application_statuses'] = array('new', 'reviewing', 'shortlisted', 'interview', 'offered', 'hired', 'rejected');

$config['gz_upload_max_bytes'] = 5242880;   // 5 MB, images and resumes
$config['gz_login_max_failures'] = 5;       // per username + IP
$config['gz_login_max_ip_failures'] = 20;   // per IP
$config['gz_login_window'] = 900;           // seconds
$config['gz_admin_per_page'] = 15;
$config['gz_blog_per_page'] = 6;

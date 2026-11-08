<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Fuller product pages and job role details. Written from what each page already says; no prices, timelines,
 * clients or results are stated. Qualifications and experience are left for the owner to fill in.
 */
return array(
	'products' => array(
		'business-website-platform' => <<<'HTML'
<p>A professional website that your own team can keep up to date. It is built for businesses that want a clear online presence, a steady flow of enquiries and pages that search engines can read, without calling a developer for every small change.</p>
<h2>Who it is for</h2>
<p>Shops, clinics, schools, consultancies and service firms that need more than a social media page: a place where customers can see what you offer, check that you are genuine and contact you directly.</p>
<h2>What is included</h2>
<p>Pages your staff can edit from a simple admin screen, enquiry forms that save every message and email it to you, layouts that work on phones, and page titles and descriptions set up for search engines. An optional blog or news section lets you share updates and answer common customer questions.</p>
<h2>How we set it up</h2>
<p>We start with a short conversation about your services and customers, agree the pages and content, then build and test the site on phones and computers before it goes live. You get a walkthrough of the admin screens so your team is comfortable making changes.</p>
<h2>After launch</h2>
<p>Hosting, updates and backups can be handled through our <a href="site:products/cloud-hosting-care-plan">Cloud Hosting Care Plan</a>. If you need features beyond a standard business site, see our <a href="site:services/website-development">website design and development service</a> or <a href="site:contact">tell us what you have in mind</a>.</p>
HTML
		,
		'online-store-platform' => <<<'HTML'
<p>An online store for businesses that want to take orders on their own website, not only through marketplaces. Customers browse your catalogue, add items to a cart and pay online, while you manage orders and stock from one dashboard.</p>
<h2>Who it is for</h2>
<p>Retailers, wholesalers and makers who already sell in person or by phone and want customers across the district, or further away, to order directly.</p>
<h2>What is included</h2>
<p>A product catalogue with categories, a cart and checkout designed for phones, a connection to the payment gateway you choose, an order status dashboard and settings for stock and delivery. Product pages are set up with their own titles and descriptions so they can be found in search.</p>
<h2>How we set it up</h2>
<p>We agree how your products are organised, which payment method suits your business and how delivery charges should work. We load a first set of products with you, test orders from start to finish and show your team how to add products and process orders.</p>
<h2>Growing the store</h2>
<p>Larger catalogues, custom pricing rules or links to your billing software are handled through our <a href="site:services/e-commerce-development">e-commerce development service</a>. For ongoing hosting and updates, see the <a href="site:products/cloud-hosting-care-plan">Cloud Hosting Care Plan</a>.</p>
HTML
		,
		'business-management-software' => <<<'HTML'
<p>One place for your customers, tasks, invoices and reports, shaped around the way your business already works. It replaces scattered spreadsheets, notebooks and message threads with a single system your staff can share.</p>
<h2>Who it is for</h2>
<p>Growing businesses where information lives in several spreadsheets, where jobs are tracked on paper or in chats, and where the owner spends evenings pulling reports together by hand.</p>
<h2>What is included</h2>
<p>Customer and contact records, task and job tracking, invoices and basic reports, and role-based access so each staff member sees what they need. Existing data can be imported from your spreadsheets, so you do not start from an empty system.</p>
<h2>How we set it up</h2>
<p>We map your current process first: who records what, who approves what, and which reports you rely on. The system is configured around that process, then tested with your real data before your team starts using it. We train the people who will use it every day.</p>
<h2>When you need more</h2>
<p>If your workflow needs features beyond this platform, our <a href="site:services/custom-software-development">custom software development</a> and <a href="site:services/crm-business-management-software">CRM and business management software</a> services build them. Read <a href="site:blog/custom-software-or-off-the-shelf-how-to-choose">custom software or off-the-shelf: how to choose</a> before you decide.</p>
HTML
		,
		'customer-portal' => <<<'HTML'
<p>A secure area where your customers sign in to help themselves: checking the services they use, downloading documents and raising requests. It reduces routine calls to your office and gives customers answers outside working hours.</p>
<h2>Who it is for</h2>
<p>Businesses that regularly send documents, statements or status updates to the same customers, such as service providers, consultancies, training centres and firms with maintenance contracts.</p>
<h2>What is included</h2>
<p>Secure customer logins, document downloads, a history of services and requests, email notifications when something changes, and admin screens where your staff manage customers and respond to requests.</p>
<h2>How we set it up</h2>
<p>We agree what each customer should see, how documents are organised and who on your team handles requests. Access is tested so customers see only their own information, and staff are shown how to add customers and answer requests.</p>
<h2>Related services</h2>
<p>A portal often connects to systems you already use. Our <a href="site:services/web-application-development">web application development</a> and <a href="site:services/api-development-integration">API development and integration</a> services cover those links. <a href="site:contact">Contact us</a> to talk through what your customers need.</p>
HTML
		,
		'booking-enquiry-system' => <<<'HTML'
<p>Online bookings and enquiry tracking for service businesses. Customers book or enquire from your website at any time, your staff see everything in one calendar, and every enquiry has a clear status so nothing is forgotten.</p>
<h2>Who it is for</h2>
<p>Clinics, salons, training centres, consultants, repair services and any business that takes appointments or receives enquiries by phone and message today.</p>
<h2>What is included</h2>
<p>Booking and enquiry forms on your website, a calendar view for staff, a status for each enquiry from new to completed, email notifications, and reports that show how many bookings and enquiries come in and where they come from.</p>
<h2>How we set it up</h2>
<p>We agree your services, time slots and the details you need from customers. Notifications go to the right people, and the forms are tested on phones, where most bookings are made. Your staff are shown how to manage the calendar and update each enquiry.</p>
<h2>Related services</h2>
<p>The system can sit on your existing website or on a new one built through our <a href="site:services/website-development">website design and development service</a>. For connections to other tools, see <a href="site:services/api-development-integration">API development and integration</a>.</p>
HTML
		,
		'cloud-hosting-care-plan' => <<<'HTML'
<p>Managed cloud hosting for your website or web application, with updates, monitoring and backups handled for you. It is meant for businesses that want their site to stay fast, secure and available without managing servers themselves.</p>
<h2>Who it is for</h2>
<p>Owners whose website brings in enquiries or orders, and who would rather not deal with hosting panels, software updates or security alerts.</p>
<h2>What is included</h2>
<p>Cloud hosting sized to your site, software updates, monitoring with alerts, regular backups and support for small technical issues. The exact update and backup schedule is agreed with you when the plan starts, so you know what is covered.</p>
<h2>How we set it up</h2>
<p>We review your current site and hosting, move it to a suitable cloud setup with care to avoid downtime, and confirm that backups can be restored before relying on them.</p>
<h2>Related services</h2>
<p>Larger systems and migrations are handled through our <a href="site:services/cloud-solutions">cloud solutions</a> and <a href="site:services/aws-cloud-solutions">AWS cloud solutions</a> services. Ongoing site care is covered in more detail under <a href="site:services/website-maintenance-support">website maintenance and support</a>, and in our guide to <a href="site:blog/website-maintenance-and-security-business-guide">website maintenance and security</a>.</p>
HTML
		,
	),
	'careers' => array(
		'web-developer' => array(
			'description' => '<p>You will build and maintain websites and web applications for businesses across Tirunelveli District and nearby areas, working from our office in Thisaiyanvilai. Projects range from business websites with enquiry forms to online stores and custom web tools, so you will see work through from first layout to launch.</p>',
			'responsibilities' => "Build responsive pages from agreed designs\nConnect forms, databases and admin screens\nTest every page on phones and computers before launch\nImprove page speed and fix issues reported after launch\nWrite clear notes so others can maintain your work",
		),
		'software-developer' => array(
			'description' => '<p>You will develop custom business software such as customer records, job tracking and billing systems, shaped around how each client works. You will help turn a client\'s process into screens and data, then build, test and improve it.</p>',
			'responsibilities' => "Understand client requirements with the project team\nDesign database tables and application screens\nBuild and test features, including access rules for different staff roles\nImport existing data from spreadsheets where needed\nDocument the system and support the client after go-live",
		),
		'wordpress-developer' => array(
			'description' => '<p>You will build and look after business websites on WordPress, from theme setup to the plugins and settings that keep a site fast and secure. Many clients edit their own content, so a clean, easy admin experience matters as much as the front end.</p>',
			'responsibilities' => "Set up and customise WordPress themes\nChoose and configure plugins carefully\nBuild pages that clients can edit themselves\nKeep sites updated, backed up and secure\nImprove loading speed and basic on-page SEO",
		),
		'ui-ux-designer' => array(
			'description' => '<p>You will design screens for websites, web applications and business software, from early wireframes to finished designs that developers can build. Our clients\' customers use their phones first, so clear layouts that work on small screens are central to the role.</p>',
			'responsibilities' => "Turn requirements into wireframes and user flows\nCreate visual designs that follow each client's brand\nPrepare designs and specifications for developers\nCheck built screens on real devices and suggest fixes\nKeep designs readable and accessible",
		),
		'cloud-engineer' => array(
			'description' => '<p>You will set up and look after the cloud hosting behind client websites and applications, including moves from older hosting. The work covers reliability, security, backups and keeping hosting costs sensible.</p>',
			'responsibilities' => "Set up servers and cloud services for client projects\nPlan and carry out migrations with minimal downtime\nConfigure monitoring, alerts and backups, and test restores\nApply security updates and review access\nReview hosting costs and suggest savings",
		),
		'internships' => array(
			'description' => '<p>Internships give students and recent graduates hands-on experience on real projects in web development, software, design or cloud, alongside our team in Thisaiyanvilai. You will learn how client work is planned, built, tested and delivered.</p>',
			'responsibilities' => "Work on real tasks with guidance from the team\nLearn our tools and the way projects are delivered\nTest features and report issues clearly\nShare what you build in short reviews",
		),
	),
);

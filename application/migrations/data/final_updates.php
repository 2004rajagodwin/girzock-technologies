<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Final content review. Patches apply only where the original text is still present, so an
 * edit made in the admin panel is never overwritten. Nothing here claims a client, result,
 * certification or partnership.
 */
$B = 'assets/images/blog/';

return array(

'settings' => array(
	'business_address' => array("Thisaiyanvilai, Tirunelveli,\nTamil Nadu, India", "Thisaiyanvilai,\nTirunelveli District,\nTamil Nadu, India"),
	'address_short' => array('Thisaiyanvilai, Tirunelveli, Tamil Nadu', 'Thisaiyanvilai, Tirunelveli District, Tamil Nadu'),
),

'services' => array(
	'website-development' => array(
		'replace' => array('description' => array("Read our guide to <a href=\"site:blog/wordpress-or-a-custom-built-website-which-suits-you\">WordPress or a custom-built website</a>.</p>", "Read our guide to <a href=\"site:blog/wordpress-or-a-custom-built-website-which-suits-you\">WordPress or a custom-built website</a>. If you are comparing quotes, see <a href=\"site:blog/website-development-cost-in-tamil-nadu-business-guide\">what drives website cost</a> and <a href=\"site:blog/how-to-choose-a-web-development-company-in-tirunelveli\">how to choose a web development company</a>.</p>")),
	),
	'web-application-development' => array(
		'append' => "<p>We work from Thisaiyanvilai, so teams in Tirunelveli District can meet us during planning. Clients further away, such as in Thoothukudi or Nagercoil, can work with us by video call.</p>",
	),
	'e-commerce-development' => array(
		'replace' => array('short_description' => array('and a smooth checkout', 'and a smooth checkout.')),
		'append' => "<p>Before you start, our guide to <a href=\"site:blog/ecommerce-website-development-for-growing-businesses-in-tamil-nadu\">e-commerce for growing businesses in Tamil Nadu</a> covers what to settle first.</p>",
	),
	'wordpress-development' => array(
		'append' => "<p>It often suits organisations around Tirunelveli that publish regular updates, such as schools announcing admissions or shops sharing offers, because staff can make those changes without waiting for a developer.</p>",
	),
	'ui-ux-design' => array(
		'append' => "<p>For audiences in Tirunelveli and across Tamil Nadu, that can include checking how Tamil and English labels fit on a screen, and how pages behave on an ordinary phone and a mobile connection.</p>",
	),
	'crm-business-management-software' => array(
		'append' => "<p>For businesses in Thisaiyanvilai and Tirunelveli, we can sit down with your team and walk through how an enquiry is handled today. Elsewhere, the same conversation works well by video call.</p>",
	),
	'mobile-app-development' => array(
		'append' => "<p>If your users are in towns and villages around Tirunelveli, we would plan and test for low-cost phones and uneven network coverage from the start, not as an afterthought.</p>",
	),
	'cloud-solutions' => array(
		'replace' => array('faqs' => array('It depends on what you run. We often work with AWS, covered on our AWS page, and we will consider other options where they fit better.', 'It depends on what you run. We offer AWS services, covered on our AWS page, and we will tell you if another option would fit better.')),
		'append' => "<p>Cloud work rarely needs a site visit, so we can support businesses in Tirunelveli, Thoothukudi and Nagercoil from our base in Thisaiyanvilai.</p>",
	),
	'aws-cloud-solutions' => array(
		'append' => "<p>AWS has regions in India, and for customers in Tamil Nadu an Indian region is usually worth considering for speed. We can help you weigh that up against cost and the services you need.</p>",
	),
	'api-development-integration' => array(
		'append' => "<p>Integration work can be done entirely remotely, so location is rarely a barrier for businesses in Tirunelveli or further afield. A trading or logistics firm in Thoothukudi, for example, may have several systems holding the same data.</p>",
	),
	'website-maintenance-support' => array(
		'replace' => array('description' => array('after an initial review.</p>', 'after an initial review.</p><p>Having a support contact in Tirunelveli District means working to the same hours as your business. Our <a href="site:blog/website-maintenance-and-security-business-guide">website maintenance and security guide</a> sets out what should be done and how often, whether you use us or not.</p>')),
	),
	'seo-services' => array(
		'append' => "<p>For a business in Thisaiyanvilai or Tirunelveli, this usually starts with making sure the name, address, phone number and services are clear and consistent everywhere customers look.</p>",
	),
	'digital-transformation' => array(
		'append' => "<p>This suits the established family businesses found across Tirunelveli District, where well-practised routines are worth keeping and only the slowest steps need to change.</p>",
	),
	'it-consulting' => array(
		'append' => "<p>From Thisaiyanvilai, we can meet in person within Tirunelveli District and by video call elsewhere.</p>",
	),
),

'crops' => array(
	array('assets/images/feature/software-3.png', $B.'article-online-store.png'),
	array('assets/images/feature/software-5.png', $B.'article-code-editor.png'),
	array('assets/images/feature/software-4.png', $B.'article-glass-ribbon.png'),
	array('assets/images/event/product-4.png', $B.'article-geometric.png'),
	array('assets/images/event/product-5.png', $B.'article-glass-swirl.png'),
	array('assets/images/feature/software-2.png', $B.'article-messages.png'),
	array('assets/images/event/product-3.png', $B.'article-glass-curves.png'),
),

/* Descriptive alt text, and replacements for the watermarked blog1-8.png. */
'images' => array(
	'how-to-plan-a-business-website-that-generates-enquiries' => array(NULL, 'Abstract swirl of blue and pink with dark speckles'),
	'custom-software-or-off-the-shelf-how-to-choose' => array(NULL, 'Person working at a large touchscreen control panel'),
	'what-to-check-before-moving-your-business-to-the-cloud' => array(NULL, 'Abstract flowing lines in blue and purple'),
	'ui-ux-basics-every-business-owner-should-know' => array(NULL, 'Person wearing a virtual reality headset'),
	'wordpress-or-a-custom-built-website-which-suits-you' => array(NULL, 'Close-up of a blue hexagonal mesh surface'),
	'a-practical-first-step-towards-digital-transformation' => array($B.'article-geometric.png', 'Abstract geometric pattern of blue and purple triangles'),
	'website-design-trends-and-best-practices-for-2027' => array($B.'article-glass-swirl.png', 'Abstract swirl of blue glass'),
),

/* The five articles to publish, in the order they should appear, newest first. */
'publish' => array(

'why-small-businesses-in-tirunelveli-need-a-professional-website' => array(
	'alt' => 'Messaging app showing a conversation on a dark screen',
	'image' => $B.'article-messages.png',
	'insert_before_faq' => <<<'HTML'
<h2>Is this also true in smaller towns?</h2>
<p>It is easy to assume that websites only matter in cities. But in a town like Thisaiyanvilai, the reasons are often stronger. People travelling in from surrounding villages want to check whether a hospital department is open, whether a showroom stocks a model, or which road a shop is on before they set out. A wasted journey costs them far more than a wasted click.</p>
<p>There is also less competition in smaller towns. If few local businesses have clear, accurate information online, a simple site with your services and hours can stand out. The same applies to people who have moved away for work and are arranging something for their parents back home. They will search from Chennai or abroad, and they cannot simply walk past your shop.</p>
<h2>What it will not do</h2>
<p>A website is not a magic source of customers, and it is better to be realistic before you spend money:</p>
<ul>
<li><strong>It will not fix a weak offer.</strong> It presents your business. It cannot replace good service or fair prices.</li>
<li><strong>It needs people to find it.</strong> Visitors will come from your Google Business Profile, your existing customers, your printed materials and, over time, search.</li>
<li><strong>It takes a little ongoing care.</strong> Someone has to keep the details current and renew the domain.</li>
</ul>
<p>A sensible way to judge it is to ask how many new enquiries would cover the cost. For many businesses, the number is small. Note where each new enquiry came from for a few months, and you will know whether it is working. If it is, our <a href="site:services/seo-services">SEO service</a> covers the groundwork that helps people find you in search.</p>
HTML,
	'extra_faq' => "<h3>Should my website be in Tamil, English or both?</h3>\n<p>That depends on how your customers speak to you. Many local businesses do well with English navigation and key information in Tamil. If you offer both, keep them equally up to date.</p>\n",
),

'how-to-choose-a-web-development-company-in-tirunelveli' => array(
	'alt' => 'Code editor showing a program file on a dark screen',
	'image' => $B.'article-code-editor.png',
	'insert_before_faq' => <<<'HTML'
<h2>What a good first conversation sounds like</h2>
<p>You can learn a lot before any money changes hands. A provider worth hiring will usually ask more questions than they answer in the first meeting: who your customers are, what they ask you, what happened with your last website and how you will judge success. They may even suggest doing less than you asked for, if it suits your budget or goals better.</p>
<p>Be cautious if the conversation goes straight to technology names or a package price. Also notice how they explain things. If a developer cannot make a hosting decision clear to you now, it is unlikely to get easier when something goes wrong.</p>
<h2>A simple way to score your shortlist</h2>
<p>Once you have two or three options, give each a mark out of five on the points below. This stops the decision from resting on price or a single impressive design.</p>
<ul>
<li><strong>Understanding:</strong> did they listen to what your business needs?</li>
<li><strong>Evidence:</strong> can you see live work, and does it load well on your phone?</li>
<li><strong>Clarity:</strong> is the written quote specific about what is included?</li>
<li><strong>Ownership:</strong> will the domain, site and content clearly belong to you?</li>
<li><strong>Support:</strong> do you know what happens after launch, and at what cost?</li>
</ul>
<p>For businesses in Thisaiyanvilai, Vallioor or Tirunelveli city, it is reasonable to ask for one meeting in person if that helps you decide. GIRZOCK Technologies is based in Thisaiyanvilai, and you are welcome to put all of these questions to us about our <a href="site:services/website-development">website</a> and <a href="site:services/website-maintenance-support">support</a> services.</p>
HTML,
	'extra_faq' => "<h3>How long should I give a provider to respond?</h3>\n<p>Agree this up front. Slow replies during the sales stage are a useful warning, since most companies are at their most attentive before you have paid.</p>\n",
),

'website-development-cost-in-tamil-nadu-business-guide' => array(
	'alt' => 'Abstract translucent curves in pale blue and red',
	'image' => $B.'article-glass-curves.png',
	'insert_before_faq' => <<<'HTML'
<h2>A worked example of how scope changes</h2>
<p>Imagine a coaching centre in Tirunelveli asking for "a simple website". On a first call, a few needs come up: course pages, a way to enquire, and a gallery. That is a small brochure site. Then the owner mentions wanting students to pay fees online, and parents to see attendance.</p>
<p>That one sentence changes the project. Payments and logins bring a payment gateway, user accounts, data privacy decisions and much more testing. Neither version is wrong, but they are very different pieces of work, and they should not be compared on the same quote. The centre could launch the brochure site first, and add the portal once it knows families will use it.</p>
<h2>Questions to ask before accepting a quote</h2>
<ul>
<li>Does the price include GST, and is the total clear?</li>
<li>How many design revisions are included, and what do extra ones cost?</li>
<li>Who enters the content, and is that included?</li>
<li>What happens if we add something during the project?</li>
<li>What will the second year cost, with every renewal included?</li>
<li>Which parts of the site can we change ourselves?</li>
</ul>
<h2>Setting a realistic budget</h2>
<p>Instead of starting with a number, work out what the website should do for the business. If you know roughly what one new customer is worth, you can judge how much it is sensible to spend, and how long it might take to earn that back. Then keep some budget aside for the first year, because the most useful improvements usually become clear only after real customers have used the site.</p>
HTML,
	'extra_faq' => "<h3>Why don't you list prices on this page?</h3>\n<p>Because a figure without an agreed scope would mislead you. Two businesses asking for \"a website\" can need very different amounts of work. A written quote for your requirements is far more useful.</p>\n",
),

'ecommerce-website-development-for-growing-businesses-in-tamil-nadu' => array(
	'alt' => 'Laptop showing an online store with products and a shopping cart',
	'image' => $B.'article-online-store.png',
	'insert_before_faq' => <<<'HTML'
<h2>Pages and policies you will need</h2>
<p>Online buyers cannot walk in and ask you a question, so your site has to answer in advance. Plan these before launch:</p>
<ul>
<li><strong>Contact details:</strong> your business name, address, phone number and a named way to raise a complaint.</li>
<li><strong>Delivery information:</strong> where you deliver, how long it takes and what it costs.</li>
<li><strong>Returns and refunds:</strong> what can be returned, within what time and who pays for it.</li>
<li><strong>Privacy:</strong> what customer data you collect and why.</li>
</ul>
<p>India's Consumer Protection (E-Commerce) Rules, 2020 set out information that online sellers must provide, including grievance contact details, and the Digital Personal Data Protection Act, 2023 covers personal data. Your obligations depend on how you sell, so please confirm them with a qualified adviser. We can build whatever pages they recommend.</p>
<h2>Your first month of selling</h2>
<p>Treat the first few weeks as a controlled trial rather than a grand opening:</p>
<ul>
<li>Begin with existing customers, who will be patient and tell you what went wrong.</li>
<li>Place real orders yourself, including a failed payment and a return.</li>
<li>Time how long each order takes to pack and dispatch.</li>
<li>Compare your actual delivery costs with what you charged.</li>
<li>Note every question customers ask, and add the answers to the site.</li>
</ul>
<p>Only then start spending on advertising. Sending paid traffic to a store whose problems have not been found yet is an expensive way to discover them.</p>
HTML,
	'extra_faq' => "<h3>Can I deliver only within Tirunelveli or Tamil Nadu at first?</h3>\n<p>Yes, and it is often sensible. Starting with a smaller delivery area keeps costs and returns manageable while you learn. You can restrict orders by PIN code and expand later.</p>\n",
),

'website-maintenance-and-security-business-guide' => array(
	'alt' => 'Abstract ribbon of translucent blue glass',
	'image' => $B.'article-glass-ribbon.png',
	'replace' => array(
		'<strong>Test restoring a backup.</strong> A backup you have never restored is only a hope.' => '<strong>Test restoring a backup.</strong> Until you have restored one, you cannot be sure that it works.',
		'Imagine a shop owner who learns from a customer that her website is showing a warning.' => 'Imagine a shop owner who learns from a customer that the shop\'s website is showing a warning.',
	),
	'insert_before_faq' => <<<'HTML'
<h2>A simple rule for backups</h2>
<p>A widely used guideline is the 3-2-1 rule: keep three copies of your data, on two different types of storage, with one copy somewhere else. For a small business website, that could mean the live site, a backup held by your host, and another copy in separate cloud storage that uses different login details.</p>
<p>Make sure the backup includes both your files and your database. A copy of the database alone would not restore your uploaded images, or a store's product photos.</p>
<h2>Who should look after it?</h2>
<p>You have three realistic options, and each can work:</p>
<ul>
<li><strong>A trained member of staff:</strong> the cheapest choice, if someone will reliably do it and knows what to do when an update breaks something.</li>
<li><strong>Your hosting company:</strong> some plans include updates and backups. Check exactly what is covered, as many cover the server but not your website's software.</li>
<li><strong>A maintenance provider:</strong> usually the best fit if the website brings in business and nobody has the time. Our <a href="site:services/website-maintenance-support">maintenance service</a> supports businesses in Tirunelveli District and beyond.</li>
</ul>
<p>Whichever you choose, write down who is responsible, and keep the logins for your domain, hosting and website somewhere safe that the business controls. Many urgent problems become much worse because the only person with the password has left.</p>
HTML,
	'extra_faq' => "<h3>What would this checklist look like for an online store?</h3>\n<p>The same, but more often. Stores change daily, so back up the database at least daily, test the checkout after every update, and check that order emails are still arriving.</p>\n",
),

),
);

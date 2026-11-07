<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Content for migration 012. Six short articles are rewritten in full; each service gets one
 * paragraph about the area it serves; a few SEO fields are updated. The migration only replaces
 * text that still matches what was there before, so nothing an admin has edited is overwritten.
 */
return array(

'posts' => array(

'how-to-plan-a-business-website-that-generates-enquiries' => array(
'excerpt' => 'A website brings enquiries when it is planned around what visitors need to do. Here is how to plan the pages, the message and the contact path before design begins.',
'content' => <<<'HTML'
<p>Most business owners judge a website by how it looks. Customers judge it by whether it answers their question quickly and makes the next step easy. A site can look modern and still bring in almost no calls, because nobody planned what a visitor should do when they arrive. Planning that path before any design work starts is the most useful thing you can do for a new website.</p>

<h2>Start with the action you want</h2>
<p>Decide what a successful visit looks like. For a clinic, it may be a booked appointment. For a manufacturer, a quotation request. For a shop, a phone call or a visit. Write that action down, because every page should lead towards it.</p>
<p>Most businesses have one main action and one or two smaller ones. A school might want admission enquiries first, then brochure downloads. Keeping the list short stops pages from turning into a crowd of buttons that all compete for attention.</p>

<h2>Write down the questions customers ask</h2>
<p>Think about the questions your staff answer on the phone every week. Where are you? What do you charge, or how is a price worked out? How long does it take? Do you work with businesses like mine? Each common question deserves a clear answer on the site.</p>
<p>This is also where most of your search traffic comes from. People type their questions into Google. A page that answers "website development cost for a small business" or "do you deliver to Thoothukudi" plainly has a far better chance of being found than a page of general claims.</p>

<h2>Plan the pages before the design</h2>
<p>A simple business website usually needs:</p>
<ul>
<li><strong>A homepage</strong> that says what you do, who you do it for and where, in the first screen.</li>
<li><strong>One page for each main service</strong>, so each can answer its own questions and appear in search for its own topic.</li>
<li><strong>An about page</strong> with real information: who runs the business, how long you have worked, how you work.</li>
<li><strong>A contact page</strong> with your phone number, address, map and a short form.</li>
</ul>
<p>Add pages only when they answer something customers need. Ten thin pages help less than four complete ones.</p>

<h2>Make contacting you effortless</h2>
<h3>Keep the form short</h3>
<p>Ask only for what you need to reply: name, phone or email, and the service they want. Every extra field loses some visitors. You can ask for detail once you are talking.</p>
<h3>Offer more than one route</h3>
<p>Some customers prefer to call, some to send a WhatsApp message, and some to fill in a form at night. Make each option visible on every page, especially on phones.</p>
<h3>Reply quickly</h3>
<p>The website only starts the conversation. Decide who checks enquiries, how often, and how fast you reply. A good website with slow replies still loses work.</p>

<h2>Get the basics right on a phone</h2>
<p>Most local customers will see your site on a phone first. Before launch, open every page on a phone and check that the text is readable without zooming, the buttons are easy to tap, the phone number can be tapped to call, and the pages load quickly on mobile data.</p>

<h2>Measure what happens after launch</h2>
<p>Connect the site to Google Search Console and an analytics tool, then look each month at which pages people visit, which searches bring them, and where enquiries come from. Small improvements, such as a clearer heading or an extra answer on a service page, often matter more than a redesign.</p>

<h2>A short checklist</h2>
<ul>
<li>One main action, written down.</li>
<li>Answers to your customers' common questions.</li>
<li>A page for each main service.</li>
<li>Contact options on every page, tested on a phone.</li>
<li>Someone responsible for replying to enquiries.</li>
<li>Search Console and analytics set up from day one.</li>
</ul>

<p>If you are planning a new website or rebuilding one that brings few enquiries, our <a href="site:services/website-development">website development service</a> starts with exactly this kind of planning. You can also read <a href="site:blog/how-to-choose-a-web-development-company-in-tirunelveli">how to choose a web development company</a>, or <a href="site:contact">tell us about your business</a> and we will suggest where to begin.</p>
HTML
),

'custom-software-or-off-the-shelf-how-to-choose' => array(
'excerpt' => 'Ready-made software is quick to start with. Custom software fits the way you work. A practical way to compare cost, flexibility and long-term fit before you decide.',
'content' => <<<'HTML'
<p>When a business outgrows spreadsheets and paper registers, the first question is usually whether to buy a ready-made product or have software built. Both can be the right answer. The wrong choice costs money twice: once for the software, and again for the workarounds your team invents to get past what it cannot do.</p>

<h2>What off-the-shelf software does well</h2>
<p>Ready-made products, such as accounting packages, billing apps and standard CRM tools, are built for thousands of businesses with similar needs. That brings real advantages:</p>
<ul>
<li><strong>Quick to start.</strong> You can often begin the same week.</li>
<li><strong>Predictable cost.</strong> A monthly or yearly licence, usually per user.</li>
<li><strong>Maintained for you.</strong> The vendor handles updates, security fixes and hosting.</li>
</ul>
<p>If your process looks like most businesses in your industry, a good ready-made product is often the sensible choice.</p>

<h2>Where ready-made software starts to struggle</h2>
<p>Problems appear when your way of working is different, and that difference matters to your customers. Common signs:</p>
<ul>
<li>Staff keep a separate spreadsheet alongside the software because it cannot hold some information.</li>
<li>The same data is typed into two or three systems that do not talk to each other.</li>
<li>You pay for many features you do not use, but the one you need is missing.</li>
<li>Licence costs grow every time you add a user or a branch.</li>
</ul>

<h2>What custom software changes</h2>
<p>Custom software is built around your process, rather than the other way round. It can follow your exact approval steps, produce the reports you actually read, and connect to the tools you already use. You own what is built, and it grows when your business changes.</p>
<p>The trade-offs are real too. It takes longer to start, needs a larger first investment, and someone must maintain it. A good development partner will tell you plainly when a ready-made product would serve you better.</p>

<h2>Five questions to decide</h2>
<h3>1. Is your process standard or a strength?</h3>
<p>If the way you handle orders, jobs or customers is what sets you apart, software should support it rather than flatten it. If it is ordinary, buy.</p>
<h3>2. What does it cost over three to five years?</h3>
<p>Compare total cost, not the first invoice: licences for every user, add-ons, extra data entry time, and the cost of mistakes, against a one-time build plus support.</p>
<h3>3. How many systems must it connect to?</h3>
<p>If your accounts, website, WhatsApp enquiries and stock must work together, connection matters as much as features. Check what a ready-made product can really integrate with.</p>
<h3>4. Who owns your data?</h3>
<p>Find out how you can export everything if you change provider later.</p>
<h3>5. Can you start small?</h3>
<p>Custom software does not have to be built in one go. Start with the part that wastes the most time, then extend it.</p>

<h2>A middle path</h2>
<p>Many businesses combine both: a standard accounting package, for example, with a small custom application for the part of their work that no product handles well, connected through an API. This often gives the best value.</p>

<h2>Next steps</h2>
<p>Write down the three tasks that take your team the most time each week, and which tools they use for them. That list is the best starting point for any software decision.</p>
<p>Our <a href="site:services/custom-software-development">custom software development</a> work begins with that kind of review, and we will tell you if a ready-made product is the better fit. For customer records and sales tracking, see <a href="site:services/crm-business-management-software">CRM and business software</a>, or <a href="site:contact">get in touch</a> to talk it through.</p>
HTML
),

'what-to-check-before-moving-your-business-to-the-cloud' => array(
'excerpt' => 'Moving to the cloud works best in small, tested steps. The questions to answer first: what to move, what it will cost, how data is protected and who manages it afterwards.',
'content' => <<<'HTML'
<p>"Moving to the cloud" can mean many things: running your website on a cloud server, keeping files in online storage, or replacing an office server with services from AWS or a similar provider. Done well, it brings reliable access from anywhere, easier backups and room to grow. Done in a hurry, it brings surprise bills and confused staff. These are the checks to make first.</p>

<h2>1. List what you actually have</h2>
<p>Start with an honest inventory: the applications you run, where each one is hosted today, which data each holds, and who uses it. Many businesses discover forgotten systems at this stage, such as an old billing tool on one office PC that is not backed up.</p>

<h2>2. Decide what to move first</h2>
<p>Not everything should move at once, and some things may not need to move at all. Good first candidates are:</p>
<ul>
<li>Your website and email, which are low risk and easy to test.</li>
<li>File storage and backups.</li>
<li>Applications that staff need to reach from more than one place.</li>
</ul>
<p>Leave tightly linked or business-critical systems until the team is comfortable with the first moves.</p>

<h2>3. Understand the costs, monthly</h2>
<p>Cloud services are billed by use, so costs follow what you run, store and transfer. Before you move, estimate the monthly cost of each service you plan to use, then set up billing alerts so an unexpected rise is noticed in days, not at the end of the quarter. Remember to switch off test servers when you finish with them.</p>

<h2>4. Plan security and access</h2>
<h3>Who can sign in</h3>
<p>Give each person their own account with only the access they need, and turn on two-step sign-in for every account that can change settings or see customer data.</p>
<h3>Where the data lives</h3>
<p>Check which region your data will be stored in, and whether any customer contracts or regulations require it to stay in India.</p>
<h3>Backups</h3>
<p>The cloud does not back up your data automatically in every case. Decide what is backed up, how often, how long copies are kept, and test a restore before you rely on it.</p>

<h2>5. Move in small, tested steps</h2>
<p>Move one system at a time. Run the old and new versions side by side for a short period where you can, check that everything works, then switch over. Choose a quiet day for each switch, and keep a written way back to the old system until you are sure.</p>

<h2>6. Agree who manages it afterwards</h2>
<p>This is the step most often skipped. Someone must watch costs, apply updates, review security alerts and answer when something stops working. That can be a person in your team or a support partner, but it must be agreed before the move, not after the first problem.</p>

<h2>A simple readiness checklist</h2>
<ul>
<li>Inventory of applications and data, with owners.</li>
<li>A first, low-risk system chosen.</li>
<li>Monthly cost estimate and billing alerts.</li>
<li>Individual accounts and two-step sign-in.</li>
<li>Backups defined and a restore tested.</li>
<li>A named person or partner for ongoing management.</li>
</ul>

<p>We help businesses plan and carry out these moves through our <a href="site:services/cloud-solutions">cloud solutions</a> and <a href="site:services/aws-cloud-solutions">AWS cloud solutions</a> services, including ongoing <a href="site:services/website-maintenance-support">maintenance and support</a>. If you are weighing up a move, <a href="site:contact">tell us what you run today</a> and we will suggest a sensible first step.</p>
HTML
),

'ui-ux-basics-every-business-owner-should-know' => array(
'excerpt' => 'UI is how your website or app looks. UX is how easy it is to use. Plain explanations of both, with simple checks any business owner can run before launch.',
'content' => <<<'HTML'
<p>You do not need to be a designer to judge whether your website or app works for customers. You only need to know what to look for. Two terms come up in every design discussion, UI and UX, and understanding the difference helps you ask better questions and spot problems before your customers do.</p>

<h2>UI and UX in plain words</h2>
<p><strong>UI (user interface)</strong> is what people see and touch: colours, fonts, buttons, images, spacing and layout.</p>
<p><strong>UX (user experience)</strong> is how it feels to get something done: whether people find what they need, understand what to do next and finish the task without frustration.</p>
<p>A beautiful screen with a confusing checkout has good UI and poor UX. A plain screen that gets the job done quickly has good UX. The best products have both, but if you must choose, choose UX: customers forgive plain design far more readily than confusion.</p>

<h2>Five principles that matter most</h2>
<h3>1. Clarity first</h3>
<p>Every screen should answer three questions immediately: where am I, what can I do here, and what should I do next? If a visitor needs to think about it, the screen needs work.</p>
<h3>2. Consistency</h3>
<p>Buttons, colours and words should mean the same thing everywhere. If "Book now" is blue on one page and grey on another, people hesitate.</p>
<h3>3. Fewer steps</h3>
<p>Count the taps or clicks a customer needs to enquire, book or buy. Every step you remove makes it more likely they finish.</p>
<h3>4. Readable on a phone</h3>
<p>Text should be large enough to read without zooming, buttons large enough to tap with a thumb, and nothing important should be hidden off the side of the screen.</p>
<h3>5. Accessible to everyone</h3>
<p>Good contrast between text and background, clear labels on form fields and images described for screen readers help customers with poor eyesight, older customers and anyone using a phone in bright sunlight.</p>

<h2>Simple checks you can run yourself</h2>
<ul>
<li><strong>The five-second test.</strong> Show the homepage to someone for five seconds, then ask what the business does. If they cannot say, the message is not clear enough.</li>
<li><strong>The task test.</strong> Ask a friend to find your phone number, or book a service, while you watch without helping. Note every pause.</li>
<li><strong>The phone test.</strong> Open every page on your own phone, on mobile data, and try to complete each main task.</li>
<li><strong>The form test.</strong> Fill in each form with a mistake, such as a wrong email address, and check the message tells you clearly how to fix it.</li>
</ul>

<h2>Where good UX pays back</h2>
<p>Better UX shows up as fewer abandoned forms, fewer calls asking how to do something, and fewer mistakes in orders and bookings. For internal software, it means staff learn faster and make fewer errors. These are practical business gains, not just appearance.</p>

<h2>How a design project should run</h2>
<p>A sound UI/UX process starts with your customers and their tasks, moves to simple layouts called wireframes, then to clickable prototypes you can try before anything is built. Testing with a few real users at the prototype stage costs far less than changing a finished product.</p>

<p>Our <a href="site:services/ui-ux-design">UI/UX design service</a> follows that process for websites, web applications and mobile apps. If you already have a site that people find hard to use, our <a href="site:services/website-development">website development</a> team can improve it, or you can <a href="site:contact">ask for a review</a> of where customers get stuck.</p>
HTML
),

'wordpress-or-a-custom-built-website-which-suits-you' => array(
'excerpt' => 'WordPress suits many content-led sites. A custom build suits sites with unusual features or heavy integration. How to decide, with the trade-offs explained plainly.',
'content' => <<<'HTML'
<p>One of the first decisions in any website project is whether to build on WordPress or to have the site developed from scratch. Both approaches produce professional websites. The right choice depends on what your site must do, who will update it and how you expect it to grow.</p>

<h2>What WordPress is good at</h2>
<p>WordPress is a content management system, a ready-made foundation that powers a large share of the world's websites. Its strengths are practical:</p>
<ul>
<li><strong>Easy editing.</strong> Staff can update pages, add blog posts and change images without a developer.</li>
<li><strong>A large ecosystem.</strong> Themes and plugins add features such as forms, galleries, bookings and online shops.</li>
<li><strong>Faster to launch.</strong> For a standard business site, WordPress often means a shorter build.</li>
<li><strong>Widely supported.</strong> Many developers know it, so you are not tied to one supplier.</li>
</ul>
<p>It suits company websites, blogs, portfolios, schools, clinics and many smaller online stores using WooCommerce.</p>

<h2>Where WordPress needs care</h2>
<p>Its flexibility has a cost. Sites with many plugins can become slow and harder to keep secure, because each plugin needs updating and some are poorly maintained. WordPress sites need regular updates and backups, and a site left unattended for a year is a common target for attacks.</p>

<h2>What a custom-built website offers</h2>
<p>A custom site is written specifically for your needs, using a framework rather than a general-purpose platform. It makes sense when:</p>
<ul>
<li>Your site must do something unusual, such as calculate quotes, show live stock or manage customer accounts.</li>
<li>It must connect closely to your other systems, such as billing, CRM or inventory.</li>
<li>Speed and security matter enough that you want only the code you need.</li>
<li>You want full control over how it works and where it goes next.</li>
</ul>
<p>The trade-offs are a longer build, a larger initial cost, and editing tools that must be planned rather than coming ready-made.</p>

<h2>How to decide</h2>
<h3>Choose WordPress if</h3>
<ul>
<li>The site is mainly pages, articles and images.</li>
<li>Non-technical staff will update it often.</li>
<li>Your features are covered by well-maintained plugins.</li>
</ul>
<h3>Choose a custom build if</h3>
<ul>
<li>The site is really an application with users, data and workflows.</li>
<li>It must integrate deeply with other business software.</li>
<li>You expect to add features that no plugin provides.</li>
</ul>

<h2>Either way, plan the maintenance</h2>
<p>Whichever you choose, decide before launch who will update the software, take backups, watch for security problems and fix things when they break. A good website that is never maintained becomes a slow, insecure one.</p>

<p>We build both: see our <a href="site:services/wordpress-development">WordPress development</a> and <a href="site:services/website-development">custom website development</a> services, and our <a href="site:services/website-maintenance-support">website maintenance plans</a>. For a deeper look at upkeep, read our <a href="site:blog/website-maintenance-and-security-business-guide">website maintenance and security guide</a>, or <a href="site:contact">describe your site</a> and we will recommend an approach.</p>
HTML
),

'a-practical-first-step-towards-digital-transformation' => array(
'excerpt' => 'Digital transformation does not have to begin with a large programme. Start with one process that wastes time, fix it well, and let the results guide the next step.',
'content' => <<<'HTML'
<p>"Digital transformation" sounds like a project for large companies with big budgets. For most small and medium businesses it is something much simpler: replacing a slow, manual way of working with a digital one that saves time and reduces mistakes, one process at a time.</p>

<h2>Why starting small works better</h2>
<p>Large programmes that try to change everything at once often stall. Staff are asked to learn many new tools together, the cost builds before any benefit appears, and it becomes hard to tell what is working. Starting with one process means a smaller investment, a quicker result and a team that has seen the benefit before the next change.</p>

<h2>Find the right first process</h2>
<p>Look for work that has these signs:</p>
<ul>
<li>It happens every day or every week.</li>
<li>Information is written on paper or in WhatsApp chats, then typed again elsewhere.</li>
<li>Mistakes are common, such as missed follow-ups, wrong quantities or lost requests.</li>
<li>Answering a simple question, such as "where is this order?", needs several phone calls.</li>
</ul>
<p>Typical examples are enquiry tracking, job cards, delivery notes, staff attendance, stock counts and customer follow-ups.</p>

<h2>Map how it works today</h2>
<p>Before choosing any software, write down each step of the process as it really happens: who does what, with which paper or tool, and where it waits. This simple map often shows that some steps can be removed entirely, not just made digital.</p>

<h2>Choose the simplest tool that works</h2>
<h3>Sometimes a ready-made tool is enough</h3>
<p>Shared spreadsheets, online forms or a standard app may solve the problem quickly and cheaply.</p>
<h3>Sometimes a small custom application is better</h3>
<p>When the process is specific to your business, or must connect to other systems, a small web application built around your steps can save more time than a general tool that almost fits.</p>
<h3>Automate the repetitive parts</h3>
<p>Look for steps a system can do for you: sending reminder messages, creating reports, updating stock when an order is confirmed, or alerting a manager when something is overdue.</p>

<h2>Bring the team with you</h2>
<p>New tools fail most often because people keep using the old way. Involve the staff who do the work in choosing the tool, train them properly, and agree a date when the old paper or spreadsheet stops being used.</p>

<h2>Measure the result, then take the next step</h2>
<p>Decide in advance what improvement you expect, such as time saved each week, fewer errors or faster replies to customers. Check it after a month or two. A clear result makes the case for the next process, and gradually the business changes without a disruptive overhaul.</p>

<h2>A first-step checklist</h2>
<ul>
<li>One frequent, error-prone process chosen.</li>
<li>Today's steps written down.</li>
<li>The simplest suitable tool selected.</li>
<li>Staff involved and trained, with a switch-over date.</li>
<li>A measure of success agreed in advance.</li>
</ul>

<p>Our <a href="site:services/digital-transformation">digital transformation</a> and <a href="site:services/custom-software-development">custom software</a> services help businesses take exactly these steps, and <a href="site:services/it-consulting">IT consulting</a> can help you decide where to begin. You can also read <a href="site:blog/custom-software-or-off-the-shelf-how-to-choose">custom or off-the-shelf software</a>, or <a href="site:contact">tell us which process slows you down</a>.</p>
HTML
),

),

'services_local' => array(
'website-development' => 'We build websites for businesses across Tirunelveli, Thoothukudi and Kanyakumari districts, from our base in Thisaiyanvilai. Shops, clinics, schools and manufacturers in towns such as Tirunelveli, Palayamkottai, Valliyur, Sattankulam, Tiruchendur and Nagercoil can work with us in person or online, whichever suits them.',
'custom-software-development' => 'Many of the businesses we talk to in Tirunelveli and Thoothukudi districts still run important work on paper registers and spreadsheets: traders, transport operators, service companies and family businesses. We visit clients near Thisaiyanvilai and Sattankulam in person, and work remotely with businesses further away in Kovilpatti, Nagercoil or beyond.',
'web-application-development' => 'Web applications work in any browser, so a business with a head office in Tirunelveli and staff in Valliyur, Tiruchendur or Nagercoil can use the same system from every location. We plan and build these applications from Thisaiyanvilai, with meetings in person or online.',
'e-commerce-development' => 'Local producers and shops in southern Tamil Nadu can now sell to customers across India. We build online stores for businesses in Tirunelveli, Thoothukudi and Kanyakumari districts, including retailers and makers in towns such as Sattankulam, Tiruchendur, Nagercoil and Marthandam, with delivery and payment options that suit their customers.',
'wordpress-development' => 'WordPress is a practical choice for many businesses around Thisaiyanvilai, Tirunelveli and Sattankulam that want to update their own pages. We set it up so your staff can edit content with confidence, and we can maintain it afterwards from our Thisaiyanvilai base.',
'ui-ux-design' => 'Customers in towns and villages across Tirunelveli, Thoothukudi and Kanyakumari districts mostly use phones, often on mobile data. We design with that in mind, so your website or app is quick to understand and easy to use for local customers as well as visitors from further away.',
'cloud-solutions' => 'For businesses with staff in more than one town, such as Tirunelveli and Thoothukudi, or Nagercoil and Marthandam, cloud services let everyone work from the same up-to-date information. We plan and manage these moves from Thisaiyanvilai, and visit clients nearby when it helps.',
'aws-cloud-solutions' => 'We set up and manage AWS for businesses in Tirunelveli, Thoothukudi and Kanyakumari districts, and work remotely with clients elsewhere in Tamil Nadu and beyond. Where customer data must stay in India, we can use AWS regions in India.',
'it-consulting' => 'Our consulting is practical and local. We meet business owners in and around Thisaiyanvilai, Sattankulam and Tirunelveli in person, and advise clients in Thoothukudi, Nagercoil and other towns online, with clear recommendations rather than sales pitches.',
'crm-business-management-software' => 'Distributors, dealers, service companies and institutions across Tirunelveli and Thoothukudi districts often manage customers through phone calls and WhatsApp. A CRM built around how they actually sell keeps every enquiry and follow-up in one place. We build these from Thisaiyanvilai, for clients near and far.',
'mobile-app-development' => 'Smartphones are how most customers in Tirunelveli, Thoothukudi and Kanyakumari districts go online, so a well-made app or mobile-first web application can reach them directly. We help businesses in towns such as Tirunelveli, Sattankulam and Nagercoil decide which they need before anything is built.',
'api-development-integration' => 'Businesses around Thisaiyanvilai and Tirunelveli often use several separate tools for billing, payments, messaging and stock. We connect them so information moves on its own, and support clients across Thoothukudi and Kanyakumari districts remotely.',
'website-maintenance-support' => 'We maintain websites for businesses across Tirunelveli, Thoothukudi and Kanyakumari districts. Because we are based in Thisaiyanvilai, clients nearby, including in Sattankulam and Valliyur, can reach us in person, while all monitoring, updates and fixes are carried out online.',
'seo-services' => 'Local search is where we focus. We help businesses be found for searches in their own area, whether that is Thisaiyanvilai, Sattankulam, Tirunelveli, Tiruchendur, Thoothukudi or Nagercoil, through accurate Google Business Profile listings, location-relevant pages and content that answers what local customers ask.',
'digital-transformation' => 'Many businesses across Tirunelveli and Thoothukudi districts are ready to move one process at a time from paper to digital tools. We work with owners near Thisaiyanvilai and Sattankulam in person, and with businesses in Kanyakumari district online, starting with the process that wastes the most time.',
'digital-marketing-services' => 'We plan digital marketing for businesses that want more customers in their own towns, from Thisaiyanvilai, Sattankulam and Tirunelveli to Thoothukudi and Nagercoil, as well as businesses selling across Tamil Nadu and India.',
),

'seo' => array(
	// entity type, key, field, old value (must still match), new value
	array('page', 'home', 'meta_title', 'Software Company in Thisaiyanvilai & Tirunelveli | GIRZOCK', 'Website & Software Development in Tirunelveli | GIRZOCK'),
	array('service', 'digital-marketing-services', 'meta_description', NULL, 'Digital marketing for businesses in Tirunelveli, Thoothukudi and Kanyakumari: local SEO, social media, Google Ads and campaigns measured by results.'),
),

);

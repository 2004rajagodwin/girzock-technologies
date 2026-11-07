# Content Quality Audit

**Date:** 7 November 2026
**Scope:** the 62 indexable public pages. The 27 noindex pages are listed in `COMPLETE_PAGE_INVENTORY.md`.

## How pages were rated

Each page was measured, not judged by eye. Four things were counted:

1. **Visible words,** not counting the menu, footer, popup and loading screen. These are compared with a minimum for the page type:

   | Page type | Minimum words |
   |---|---:|
   | Home | 800 |
   | Blog post | 700 |
   | Service | 600 |
   | Areas We Serve | 500 |
   | About, product, case study | 400 |
   | Job opening | 300 |
   | Listing, legal | 250 |
   | Blog category | 200 |
   | Contact | 150 |

   These minimums are our own working targets for pages of this kind, not a Google rule. Google does not rank by word count.
2. **Own text:** the share of the page's text, in 5-word runs, that is not found on any other page. Template text that appears on a quarter of all pages or more, such as the enquiry form and call-to-action blocks, is set aside first and reported as the **template share**.
3. **Local places named:** how many times a town or district is named in the page's own text, beyond the mentions every page shares through the template.
4. **Structure:** the number of H2 headings and the number of internal links out.

| Rating | Rule |
|---|---|
| Strong | At or above the minimum words, and at least 80% own text (listings are exempt from the own-text rule, because they show excerpts of other pages) |
| Good | At least 75% of the minimum, and at least 60% own text |
| Needs work | At least 50% of the minimum |
| Thin | Under 50% of the minimum |

## Results

| Rating | Pages |
|---|---:|
| Strong | 45 |
| Good | 3 |
| Needs work | 14 |
| Thin | 0 |

| Page type | Strong | Good | Needs work | Thin |
|---|---:|---:|---:|---:|
| Home | 1 | 0 | 0 | 0 |
| Core page | 2 | 1 | 0 | 0 |
| Listing | 6 | 0 | 0 | 0 |
| Legal | 3 | 0 | 0 | 0 |
| Service | 16 | 0 | 0 | 0 |
| Product | 0 | 0 | 6 | 0 |
| Case study | 0 | 1 | 2 | 0 |
| Job opening | 0 | 0 | 6 | 0 |
| Blog post | 10 | 1 | 0 | 0 |
| Blog category | 6 | 0 | 0 | 0 |
| Blog listing page | 1 | 0 | 0 | 0 |

## What needs work, and what to add

Add only facts you can stand behind. Do not add invented clients, figures or reviews. Every field named below already exists in the admin, so no code change is needed.

**Job openings (6 pages, ~215 words, Needs work).**
- **Problem:** about 60% of each page is the shared application form and benefits text, so each opening has only 19–27% text of its own.
- **Fix:** in **Admin → Careers**, fill in Responsibilities, Qualifications and Experience required for each role, aiming for about 150 words of role-specific detail. Add a closing date if the role has one; this also adds `validThrough` to the job markup.
- **First confirm the roles are real vacancies.** If one is not, set it to inactive rather than leaving it live.

**Product pages (6 pages, ~220 words, Needs work).**
- **Problem:** more than half of each page is shared template text.
- **Fix:** in **Admin → Products**, add to Features and Description:
  - who the product is for;
  - what is included;
  - how it is set up;
  - how support works;
  - how pricing is decided. A starting price is fine if you have one; do not publish a price you would not honour.

  About 200 extra words each brings them to target.
- **Product rich results:** Google needs a real price, review or rating, so do not add markup for any of these unless the facts exist.

**Case studies (3 pages, 248–317 words).**
- **Problem:** the pages describe the approach but give no measured outcome.
- **Fix:** if these are real projects, add the client-approved results in **Admin → Case studies → Results**: what changed and in what time, without naming the client unless they agree.
- **If they are illustrative examples,** label them as such, as the portfolio sample concepts already are.

**Blog category pages (6, at or just above 200 words).**
- **Problem:** they mainly list post excerpts, which is normal. The category descriptions are only 46–61 characters.
- **Fix:** a 2–3 sentence description for each, in **Admin → Categories**, gives every category page its own introduction.

**Pages rated Strong.**
- These are the home page, all 16 services, 10 of 11 blog posts, the listings, About, Areas We Serve and the legal pages.
- They meet their targets with 80–99% own text, and every service page names local places in its own text.
- No action is needed beyond keeping them accurate.

## Page-by-page plan for the weak pages

Each plan builds on what the page already says. Items marked **(you)** are facts only you can confirm; leave them out rather than guess.

### Product pages

Today each has a one-line summary, a description of 230 to 340 characters and five features. Add these sections in **Admin → Products → Description**, about 200 to 250 words each:

| Page | Who it is for | What to explain | Questions to answer on the page |
|---|---|---|---|
| `/products/business-website-platform` | Shops, clinics, schools, service firms that need a site they can edit | How staff edit pages; what the enquiry form does with each message (saved and emailed); what "search-ready" means in practice (titles, descriptions, sitemap) | How long does setup take **(you)**? Can I add a blog later? Who hosts it? |
| `/products/online-store-platform` | Retailers selling to local and online customers | How the catalogue and categories are set up; checkout on phones; which payment gateways you connect **(you)**; how stock and delivery settings work | Which gateways? Delivery charges by area? Can I manage orders from my phone? |
| `/products/business-management-software` | Businesses running on spreadsheets | Moving spreadsheet data in; customer records, jobs and invoices in one place; staff roles | Can it match my current process? Is my data exported if I leave **(you)**? |
| `/products/customer-portal` | Firms that share documents or service history with clients | Secure logins; documents and request history; email notifications; staff admin screens | How are logins protected? Can customers raise requests? |
| `/products/booking-enquiry-system` | Service businesses that take appointments | Booking and enquiry forms; staff calendar; status of each enquiry; reports | Can customers reschedule? Do reminders go out **(you)**? |
| `/products/cloud-hosting-care-plan` | Owners who want someone to look after their site | What is updated and how often **(you)**; monitoring and alerts; backup schedule and restore **(you)**; what "small technical issues" covers | What response time do you offer **(you)**? Where are backups kept? |

For every product, add how pricing is decided, or a starting price if you are willing to honour it **(you)**, and link to one relevant service page and one blog post.

### Job openings

All six have only a short summary (98 to 168 characters). The **Description, Responsibilities, Qualifications and Experience required** fields are empty, and no closing date is set. Fill these in **Admin → Careers** for each role:

| Page | Description (2 to 3 sentences) | Responsibilities (4 to 6 points) | Qualifications and experience **(you)** |
|---|---|---|---|
| `/careers/web-developer` | The kind of client websites and web applications built in Thisaiyanvilai | Build responsive pages; connect forms and databases; test on phones; fix issues found after launch | Languages and frameworks required; years of experience or fresher welcome |
| `/careers/software-developer` | Custom business software such as CRM and billing systems | Gather requirements with the team; build and test features; write clear handover notes | Languages, database skills, experience level |
| `/careers/wordpress-developer` | Business sites built on WordPress | Theme and plugin setup; page building; speed and security updates | WordPress, PHP and theme skills; portfolio expected or not |
| `/careers/ui-ux-designer` | Screens for websites and apps, from wireframe to final design | Wireframes; visual design; working with developers; checking designs on real devices | Design tools used; portfolio required |
| `/careers/cloud-engineer` | Hosting and cloud work for client systems | Server setup; backups; monitoring; cost and security checks | Cloud platforms and certifications, if any |
| `/careers/internships` | What interns learn and work on | Areas open to interns; mentoring; length of the internship | Who can apply (year of study, courses); paid or unpaid; duration |

Add a closing date to any role that has one. It also adds `validThrough` to the job markup. Turn off any role that is not a real vacancy.

## Points that need your confirmation

These are factual checks, not SEO changes:
- Claims of experience in Digital Marketing, Mobile apps, SEO and CRM software.
- The company logos in the "Work With" section: you need permission to show them.
- Alangulam is not listed under Tirunelveli District, because it has been in Tenkasi District since 2019. Add it to the Tenkasi area if you serve it.
- The legal pages are a sound starting text. Have them reviewed before launch.

## Every indexable page

| # | URL | Type | Words / target | Own text not found elsewhere | Template share | Local places named (beyond the shared template) | H2 | Links out | Rating |
|---:|---|---|---:|---:|---:|---|---:|---:|---|
| 1 | `/` | Home | 1640 / 800 | 84% | 5% | Thisaiyanvilai 8, Tirunelveli 9, Thoothukudi 2, Kanyakumari 2, Nagercoil 1, Tamil Nadu 3, Thiruvananthapuram 1 | 19 | 247 | Strong |
| 2 | `/about` | Core page | 447 / 400 | 94% | 29% | Thisaiyanvilai 2, Tirunelveli 3, Tamil Nadu 2 | 7 | 136 | Strong |
| 3 | `/services` | Listing | 676 / 250 | 56% | 19% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 7 | 151 | Strong |
| 4 | `/products` | Listing | 305 / 250 | 72% | 43% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 152 | Strong |
| 5 | `/portfolio` | Listing | 483 / 250 | 71% | 27% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 4 | 161 | Strong |
| 6 | `/case-studies` | Listing | 339 / 250 | 97% | 38% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 132 | Strong |
| 7 | `/blog` | Listing | 400 / 250 | 4% | 33% | Thisaiyanvilai 1, Tirunelveli 3, Tamil Nadu 3 | 8 | 143 | Strong |
| 8 | `/careers` | Listing | 439 / 250 | 59% | 29% | Thisaiyanvilai 2, Tirunelveli 2, Tamil Nadu 1 | 5 | 128 | Strong |
| 9 | `/contact` | Core page | 208 / 150 | 73% | 54% | Thisaiyanvilai 2, Tirunelveli 2, Thoothukudi 1, Kanyakumari 1, Nagercoil 1, Sattankulam 1, Tiruchendur 1, Tamil Nadu 1 | 3 | 117 | Good |
| 10 | `/areas-we-serve` | Core page | 729 / 500 | 99% | 18% | Thisaiyanvilai 8, Tirunelveli 8, Thoothukudi 5, Tuticorin 1, Kanyakumari 5, Nagercoil 3, Sattankulam 3, Valliyur 1, Tiruchendur 1, Palayamkottai 1, Kovilpatti 1, Marthandam 1, Tamil Nadu 2, Thiruvananthapuram 2 | 6 | 132 | Strong |
| 11 | `/privacy-policy` | Legal | 318 / 250 | 95% | 25% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 7 | 117 | Strong |
| 12 | `/terms` | Legal | 306 / 250 | 99% | 26% | — | 8 | 116 | Strong |
| 13 | `/cookie-policy` | Legal | 287 / 250 | 97% | 29% | — | 4 | 116 | Strong |
| 14 | `/services/website-development` | Service | 947 / 600 | 87% | 14% | Thisaiyanvilai 3, Tirunelveli 5, Thoothukudi 1, Kanyakumari 1, Nagercoil 1, Sattankulam 1, Valliyur 1, Tiruchendur 1, Palayamkottai 1, Tamil Nadu 1 | 8 | 125 | Strong |
| 15 | `/services/custom-software-development` | Service | 873 / 600 | 90% | 15% | Thisaiyanvilai 2, Tirunelveli 3, Thoothukudi 1, Nagercoil 1, Sattankulam 1, Kovilpatti 1, Tamil Nadu 1 | 8 | 123 | Strong |
| 16 | `/services/web-application-development` | Service | 846 / 600 | 91% | 15% | Thisaiyanvilai 3, Tirunelveli 3, Thoothukudi 1, Nagercoil 2, Valliyur 1, Tiruchendur 1, Tamil Nadu 1 | 8 | 122 | Strong |
| 17 | `/services/e-commerce-development` | Service | 838 / 600 | 88% | 15% | Thisaiyanvilai 1, Tirunelveli 2, Thoothukudi 1, Kanyakumari 1, Nagercoil 1, Sattankulam 1, Tiruchendur 1, Marthandam 1, Tamil Nadu 4 | 8 | 123 | Strong |
| 18 | `/services/wordpress-development` | Service | 805 / 600 | 92% | 16% | Thisaiyanvilai 3, Tirunelveli 3, Sattankulam 1, Tamil Nadu 1 | 8 | 122 | Strong |
| 19 | `/services/ui-ux-design` | Service | 812 / 600 | 92% | 16% | Thisaiyanvilai 1, Tirunelveli 3, Thoothukudi 1, Kanyakumari 1, Tamil Nadu 2 | 8 | 122 | Strong |
| 20 | `/services/cloud-solutions` | Service | 807 / 600 | 90% | 16% | Thisaiyanvilai 3, Tirunelveli 3, Thoothukudi 2, Nagercoil 2, Marthandam 1, Tamil Nadu 1 | 8 | 122 | Strong |
| 21 | `/services/aws-cloud-solutions` | Service | 778 / 600 | 92% | 17% | Thisaiyanvilai 1, Tirunelveli 2, Thoothukudi 1, Kanyakumari 1, Tamil Nadu 3 | 8 | 122 | Strong |
| 22 | `/services/it-consulting` | Service | 717 / 600 | 90% | 18% | Thisaiyanvilai 3, Tirunelveli 3, Thoothukudi 1, Nagercoil 1, Sattankulam 1, Tamil Nadu 1 | 8 | 122 | Strong |
| 23 | `/services/digital-transformation` | Service | 784 / 600 | 89% | 16% | Thisaiyanvilai 2, Tirunelveli 3, Thoothukudi 1, Kanyakumari 1, Sattankulam 1, Tamil Nadu 1 | 8 | 123 | Strong |
| 24 | `/services/crm-business-management-software` | Service | 843 / 600 | 91% | 15% | Thisaiyanvilai 3, Tirunelveli 3, Thoothukudi 1, Tamil Nadu 1 | 8 | 122 | Strong |
| 25 | `/services/mobile-app-development` | Service | 829 / 600 | 91% | 15% | Thisaiyanvilai 1, Tirunelveli 4, Thoothukudi 1, Kanyakumari 1, Nagercoil 1, Sattankulam 1, Tamil Nadu 1 | 8 | 122 | Strong |
| 26 | `/services/api-development-integration` | Service | 790 / 600 | 90% | 16% | Thisaiyanvilai 2, Tirunelveli 3, Thoothukudi 2, Kanyakumari 1, Tamil Nadu 1 | 8 | 122 | Strong |
| 27 | `/services/website-maintenance-support` | Service | 813 / 600 | 89% | 16% | Thisaiyanvilai 2, Tirunelveli 3, Thoothukudi 1, Kanyakumari 1, Sattankulam 1, Valliyur 1, Tamil Nadu 1 | 8 | 123 | Strong |
| 28 | `/services/seo-services` | Service | 856 / 600 | 91% | 15% | Thisaiyanvilai 3, Tirunelveli 3, Thoothukudi 1, Nagercoil 1, Sattankulam 1, Tiruchendur 1, Tamil Nadu 1 | 8 | 123 | Strong |
| 29 | `/services/digital-marketing-services` | Service | 1177 / 600 | 93% | 11% | Thisaiyanvilai 5, Tirunelveli 5, Thoothukudi 3, Kanyakumari 2, Nagercoil 4, Sattankulam 1, Tamil Nadu 2 | 8 | 124 | Strong |
| 30 | `/products/business-website-platform` | Product | 249 / 400 | 82% | 52% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 118 | Needs work |
| 31 | `/products/online-store-platform` | Product | 225 / 400 | 87% | 58% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 118 | Needs work |
| 32 | `/products/business-management-software` | Product | 224 / 400 | 81% | 59% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 118 | Needs work |
| 33 | `/products/customer-portal` | Product | 216 / 400 | 83% | 61% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 118 | Needs work |
| 34 | `/products/booking-enquiry-system` | Product | 224 / 400 | 88% | 58% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 118 | Needs work |
| 35 | `/products/cloud-hosting-care-plan` | Product | 223 / 400 | 86% | 59% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 118 | Needs work |
| 36 | `/case-studies/taking-a-local-retailer-online` | Case study | 248 / 400 | 78% | 52% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 119 | Needs work |
| 37 | `/case-studies/replacing-spreadsheets-with-custom-software` | Case study | 317 / 400 | 86% | 42% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 119 | Good |
| 38 | `/case-studies/moving-a-business-application-to-aws` | Case study | 296 / 400 | 84% | 45% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 119 | Needs work |
| 39 | `/careers/web-developer` | Job opening | 218 / 300 | 19% | 60% | Thisaiyanvilai 2, Tirunelveli 2, Tamil Nadu 1 | 3 | 123 | Needs work |
| 40 | `/careers/software-developer` | Job opening | 216 / 300 | 20% | 61% | Thisaiyanvilai 2, Tirunelveli 2, Tamil Nadu 1 | 3 | 123 | Needs work |
| 41 | `/careers/wordpress-developer` | Job opening | 210 / 300 | 22% | 63% | Thisaiyanvilai 2, Tirunelveli 2, Tamil Nadu 1 | 3 | 123 | Needs work |
| 42 | `/careers/ui-ux-designer` | Job opening | 215 / 300 | 24% | 61% | Thisaiyanvilai 2, Tirunelveli 2, Tamil Nadu 1 | 3 | 123 | Needs work |
| 43 | `/careers/cloud-engineer` | Job opening | 212 / 300 | 23% | 62% | Thisaiyanvilai 2, Tirunelveli 2, Tamil Nadu 1 | 3 | 123 | Needs work |
| 44 | `/careers/internships` | Job opening | 222 / 300 | 27% | 59% | Thisaiyanvilai 2, Tirunelveli 2, Tamil Nadu 1 | 3 | 123 | Needs work |
| 45 | `/blog/why-small-businesses-in-tirunelveli-need-a-professional-website` | Blog post | 1261 / 700 | 87% | 10% | Thisaiyanvilai 2, Tirunelveli 6, Palayamkottai 1, Tamil Nadu 3 | 10 | 147 | Strong |
| 46 | `/blog/how-to-choose-a-web-development-company-in-tirunelveli` | Blog post | 1205 / 700 | 86% | 11% | Thisaiyanvilai 3, Tirunelveli 8, Tamil Nadu 3 | 11 | 149 | Strong |
| 47 | `/blog/website-development-cost-in-tamil-nadu-business-guide` | Blog post | 1198 / 700 | 87% | 11% | Thisaiyanvilai 1, Tirunelveli 4, Tamil Nadu 5 | 12 | 148 | Strong |
| 48 | `/blog/ecommerce-website-development-for-growing-businesses-in-tamil-nadu` | Blog post | 1196 / 700 | 87% | 11% | Thisaiyanvilai 1, Tirunelveli 5, Tamil Nadu 7 | 12 | 149 | Strong |
| 49 | `/blog/website-maintenance-and-security-business-guide` | Blog post | 1154 / 700 | 88% | 11% | Thisaiyanvilai 1, Tirunelveli 4, Tamil Nadu 3 | 10 | 148 | Strong |
| 50 | `/blog/how-to-plan-a-business-website-that-generates-enquiries` | Blog post | 949 / 700 | 83% | 14% | Thisaiyanvilai 1, Tirunelveli 3, Thoothukudi 1, Tamil Nadu 3 | 10 | 147 | Strong |
| 51 | `/blog/custom-software-or-off-the-shelf-how-to-choose` | Blog post | 848 / 700 | 81% | 15% | Thisaiyanvilai 1, Tirunelveli 3, Tamil Nadu 3 | 9 | 147 | Strong |
| 52 | `/blog/what-to-check-before-moving-your-business-to-the-cloud` | Blog post | 818 / 700 | 80% | 16% | Thisaiyanvilai 1, Tirunelveli 3, Tamil Nadu 3 | 10 | 148 | Strong |
| 53 | `/blog/ui-ux-basics-every-business-owner-should-know` | Blog post | 836 / 700 | 82% | 15% | Thisaiyanvilai 1, Tirunelveli 3, Tamil Nadu 3 | 8 | 147 | Strong |
| 54 | `/blog/wordpress-or-a-custom-built-website-which-suits-you` | Blog post | 722 / 700 | 80% | 18% | Thisaiyanvilai 1, Tirunelveli 3, Tamil Nadu 3 | 8 | 149 | Good |
| 55 | `/blog/a-practical-first-step-towards-digital-transformation` | Blog post | 776 / 700 | 80% | 16% | Thisaiyanvilai 1, Tirunelveli 3, Tamil Nadu 3 | 10 | 148 | Strong |
| 56 | `/blog/category/web-development` | Blog category | 361 / 200 | 4% | 36% | Thisaiyanvilai 1, Tirunelveli 3, Tamil Nadu 3 | 7 | 140 | Strong |
| 57 | `/blog/category/custom-software` | Blog category | 200 / 200 | 10% | 65% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 128 | Strong |
| 58 | `/blog/category/cloud-and-aws` | Blog category | 210 / 200 | 15% | 63% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 128 | Strong |
| 59 | `/blog/category/ui-ux-design` | Blog category | 207 / 200 | 12% | 64% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 128 | Strong |
| 60 | `/blog/category/wordpress` | Blog category | 234 / 200 | 3% | 56% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 4 | 131 | Strong |
| 61 | `/blog/category/digital-transformation` | Blog category | 202 / 200 | 13% | 66% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 3 | 128 | Strong |
| 62 | `/blog/page/2` | Blog listing page | 367 / 200 | 7% | 35% | Thisaiyanvilai 1, Tirunelveli 1, Tamil Nadu 1 | 7 | 140 | Strong |

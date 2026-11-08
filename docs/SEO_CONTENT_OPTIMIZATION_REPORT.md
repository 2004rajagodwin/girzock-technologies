# SEO Content Optimisation Report

**Date:** 7 November 2026
**Scope:** every indexable public page, plus the admin tools used to keep SEO right when content changes

> No ranking is promised. These changes make the pages clearer to people and to search engines. Rankings also depend on competition, reviews, links from other sites and time.

## 1. What changed in this round

| Area | Change | Where |
|---|---|---|
| Homepage head | Your reference metadata, applied to the homepage only: keywords list, author, `googlebot`, language, contact and telephone, geo tags, `theme-color #0A1A3F`, the Google Search Console verification code, and Open Graph and X (Twitter) title, description and image (`girzock-hero.png`, 1600×1991) with alt text and size. Robots: `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1` | `partials/seo.php`, `libraries/Seo.php`, migration 014 |
| Every indexable page | The same extended robots line, `author`, geo tags, `og:image:alt`, `og:image:width` and `height` where the image is local, and `twitter:image:alt`. Titles, descriptions and canonical URLs stay page-specific; the homepage canonical and keywords appear only on the homepage | same |
| Organization data | Logo is now `girzock-logo.png`, the same address as on the live site. Added `description` and `image`. Telephone in international form (+916379362330). `areaServed`: Thisaiyanvilai, Tirunelveli, Sattankulam, Thoothukudi, Nagercoil, Kanniyakumari, Thiruvananthapuram, Tamil Nadu, India. `sameAs`: Instagram, LinkedIn and Facebook. WhatsApp is deliberately left out of `sameAs`, because it is a chat link, not a profile | `libraries/Seo.php` |
| Case studies | Article markup (headline, description, image, dates, author and publisher). No ratings, results or client names | `controllers/CaseStudies.php` |
| Listing pages | Services, Products, Portfolio, Case Studies, Careers, the Blog and blog categories are now typed `CollectionPage` | 6 controllers |
| Product pages (6) | The description grew from about 30 words to about 200 words each, so each page now has 355 to 416 visible words, 88 to 93% of them its own. Sections: who it is for, what is included, how it is set up, after launch or related services. Each has 2 to 4 internal links to matching services, products or guides. No prices, timelines or clients are stated | migration 015 |
| Job pages (6) | Description and responsibilities filled in (both were empty). Qualifications and experience are left for you, because they are facts only you can set | migration 015 |
| Secondary keywords | New field on every editable page. Filled for 9 fixed pages, 16 services, 6 products, 6 jobs, 3 case studies and 11 published posts. They are for planning and are not published on the page | migrations 014 and 016 |
| Legal pages | Descriptions lengthened to 140 to 152 characters (earlier pass) | `controllers/Home.php` |
| Tag pages | Titles "Posts Tagged …", so they never clash with a category (earlier pass) | `controllers/Blog.php` |

Images used for sharing were copied from your live site without changes: `girzock-hero.png` (3.1 MB) and `girzock-logo.png`. Their URLs keep working after the new site replaces the old one.

## 2. Keyword map (primary keyword and search intent)

Primary keywords are the focus keywords already stored for each page. All indexable records have one. Secondary keywords are in the admin, under each page's SEO section.

| Page | Primary keyword | Search intent |
|---|---|---|
| Homepage | software development company in Thisaiyanvilai | Find a local provider (commercial, local) |
| About | IT company in Thisaiyanvilai | Check the company is real (trust) |
| Services | web development services in Tirunelveli | Compare what is offered (commercial) |
| Contact | contact software company Tirunelveli | Get in touch (transactional) |
| Areas We Serve | IT services in Tirunelveli and nearby districts | Check the area is served (local) |
| Products | business software products | Browse ready solutions (commercial) |
| Portfolio | web development portfolio | See examples (trust) |
| Case Studies | software case studies | See how projects run (trust) |
| Blog | technology blog for small business | Learn (informational) |
| Careers | IT jobs in Tirunelveli | Find a job (navigational) |
| 16 service pages | One each, for example "website design company in Tirunelveli", "custom software development" (stored as "software development company in Tirunelveli") and "AWS cloud solutions" | Hire for a specific service (commercial) |
| 6 products | One each, for example "online store platform" or "booking system for service business" | Evaluate a product (commercial) |
| 11 posts | One each, for example "website development cost in Tamil Nadu" or "custom software vs off the shelf" | Answer a question (informational) |
| 6 jobs | One each, for example "web developer jobs in Tirunelveli" | Apply (navigational) |

The full list is in **Admin → SEO Management** (fixed pages) and in each record's SEO section.

## 3. Page-by-page status

The measured inventory, with titles, descriptions, H1s, canonical URLs, schema and content status for every URL, is in `FULL_WEBSITE_PAGE_INVENTORY.md`. The figures:
- 0 duplicate titles and 0 duplicate descriptions;
- 0 indexable pages without exactly one H1;
- every page self-canonical.

## 4. Service pages

All 16 service pages already have the sections the brief lists:
- introduction, customer problems, benefits, workflow (process), use cases (industries), FAQs and related services;
- an enquiry form, and internal links;
- a unique local paragraph each, added earlier (migration 012).

They run to 717 to 1,177 visible words. More than 80% of each page's own text appears on no other page, so the paragraphs are not shared between services.

Service list in the brief compared with the site:

| Brief | Site |
|---|---|
| Website Design & Development, Custom Software, Web Application, E-commerce, WordPress, UI/UX, IT Consulting, Digital Transformation | Each has its own page |
| Cloud Computing, Cloud Application Development, Cloud Infrastructure | Covered by **Cloud Solutions**. One page is used instead of three near-identical ones; the secondary keywords include cloud application development and cloud infrastructure |
| AWS Cloud Solutions | Own page |

Service pages were not rewritten in this round, because measurement showed them complete and original. Rewriting good pages would add risk without benefit.

## 5. Blog SEO strategy

**What exists:** 11 published posts (720 to 1,260 words), each with its own title, description, H1, H2 and H3 sections, internal links to services, BlogPosting markup, a canonical URL, a sitemap entry with lastmod, and image alt text. There are also 20 drafts, which are noindex and not in the sitemap.

**How publishing updates SEO** (tested on the isolated copy; see the test report):
- A **draft** is not public: 404 for visitors, not in the sitemap.
- A **preview** is available to a signed-in admin with `?preview=1`, and is always `noindex, nofollow`.
- A **scheduled** post goes live at its time, with no cron job needed.
- A **published** post appears in the blog list, its category, the sitemap (with lastmod) and related posts. BlogPosting markup is generated from the post.

**SEO preview before publishing:** every editor now shows a live Google-style result preview (title, address, description and character counts), plus a list of checks.

**Next topics** (from the competitor gaps and the customer questions in the brief):

| Topic | Primary keyword idea | Links to |
|---|---|---|
| Getting a business online in Thisaiyanvilai and Sattankulam | website for shop Thisaiyanvilai | Website development, Business Website Platform |
| WordPress website maintenance: what a monthly plan should cover | WordPress maintenance | WordPress development, Website maintenance |
| Cloud computing for small businesses: what to move first | cloud for small business | Cloud solutions |
| AWS for a growing business: hosting, backups and costs explained | AWS hosting for small business | AWS cloud solutions |
| Website speed and technical SEO: a checklist for owners | website speed checklist | SEO services, Website maintenance |
| Online ordering for local shops: marketplace or own store? | own online store vs marketplace | E-commerce development, Online Store Platform |

Write each only when it can include real experience or practical steps. A short post written to fill a keyword does more harm than good.

## 6. Admin SEO tools

Each editor (services, products, portfolio, case studies, careers, blog) now has:

| Feature | Detail |
|---|---|
| Fields | SEO title, meta description, focus keyword, **secondary keywords (new)**, canonical URL, Open Graph title and description, social image, robots (index or noindex) and slug. The slug change automatically creates a 301 redirect |
| Live search preview | The title, address and description as Google would show them, with character counts. It updates as you type |
| Warnings | Missing SEO title; title over about 60 characters; missing description, or one outside 120 to 160 characters; title or description already used by another page; a duplicate record title, which would give two pages the same H1; a missing H1; an image without alt text; an invalid canonical URL; links in the text to this site's detail pages that do not exist |
| No score | Warnings say what to check. There is no SEO score, because a score would suggest a ranking promise |

**Website Settings → SEO defaults → Homepage only:** homepage keywords, the X (Twitter) title and description, and the sharing image alt text.

**SEO Management → Homepage:** the homepage title, description, Open Graph values and image.

## 7. Not done, and why

| Item | Reason |
|---|---|
| Separate town pages | They would be near-identical doorway pages, which the brief rules out. Local coverage comes from real content instead (see `LOCAL_SEO_STRATEGY.md`) |
| Prices, ratings and reviews in markup | None exist; inventing them is ruled out |
| Qualifications and experience for jobs | Owner facts |
| A 1200×630 sharing image | Your hero image is portrait (1600×1991), so Facebook and LinkedIn will crop it. Its quality was not reduced. A landscape version, if you make one, can replace it in SEO Management → Homepage |

# Complete SEO Score Report

**Date:** 7 November 2026
**Site measured:** the local build at `http://localhost/girzock-website/`. All checks used GET requests and read-only database queries.

> **These scores are an internal checklist score, not a Google ranking score.** Google publishes no SEO score. A high score means the site follows the measurable practices below, which helps search engines read it. It does not guarantee any position in search results. Rankings also depend on competition, reviews, links from other sites and time, none of which a site build can control.

## Scorecard

| # | Category | Score /100 | Weight | Measured on |
|---:|---|---:|---:|---|
| 1 | Crawlability and indexability | 99.9 | 15% | site-wide checks, 89 crawled URLs |
| 2 | Titles and meta descriptions | 100.0 | 12% | 62 indexable pages |
| 3 | Heading structure | 100.0 | 6% | 62 indexable pages |
| 4 | Content depth and uniqueness | 93.7 | 15% | 62 indexable pages |
| 5 | Internal linking | 90.0 | 10% | 62 indexable pages |
| 6 | Structured data | 96.0 | 10% | 62 indexable pages |
| 7 | Images and alt text | 100.0 | 5% | 923 images on 62 indexable pages |
| 8 | Social sharing and mobile tags | 100.0 | 5% | 62 indexable pages |
| 9 | Page speed (Lighthouse mobile) | 56.6 | 12% | 11 Lighthouse runs |
| 10 | Local SEO | 66.9 | 10% | site-wide checks |
| | **Overall (equal weight)** | **90.3** | | |
| | **Combined (weighted)** | **89.1** | 100% | |

**How the totals are worked out:**
- **Overall** is the plain average of the 10 category scores.
- **Combined** weights each category by its importance, using the weights in the table, which add to 100%.
- **Why the weights:** content, indexability and speed weigh most, because without them search engines cannot find, trust or comfortably show the pages. Images and social tags weigh least.
- If a category could not be measured, the combined score is calculated over the remaining weights, and the table says so.

**Lighthouse's own scores,** averaged over the 11 pages tested, as a separate cross-check:

| Lighthouse category | Score |
|---|---:|
| Performance | 57 |
| SEO | 100 |
| Accessibility | 99 |
| Best practices | 99 |

## Method and result for each category

Each page-level category is scored on all 62 indexable pages, and the category is the average. Site-wide categories use the checks listed.

### Crawlability and indexability — 99.9

**Method:** each check scores 0 to 1 (a share where it applies to many pages); the category is the average × 100.

| Check | Result |
|---|---:|
| Every crawled internal URL returns 200 | Pass |
| Every sitemap URL was reached and returns 200 | Pass |
| Every sitemap URL is indexable | Pass |
| Every sitemap URL has a self-referencing canonical | Pass |
| Every indexable URL is in the sitemap | 98.4% |
| Every crawled page has a canonical tag | Pass |
| robots.txt returns 200 and names the sitemap | Pass |
| Every record in the sitemap (service, product, case study, job, post) carries a lastmod date | Pass |
| Unknown URLs return a real 404 status | Pass |
| Old .html addresses redirect permanently (301) | Pass |
| Private files are not served (.env, .git, SQL dump, config) | Pass |
| Thin listing pages (tags, empty category, sample portfolio items) are noindex | Pass |

### Titles and meta descriptions — 100.0

**Method:** Title 30-60 characters = 30 points (20-29 or 61-65 = 15), unique = 20. Description 120-160 characters = 30 (70-119 or 161-170 = 15), present and unique = 20.

### Heading structure — 100.0

**Method:** Exactly one H1 = 50, two or more H2 = 30 (one = 15), H1 not used on another page = 20.

### Content depth and uniqueness — 93.7

**Method:** 70 points scaled by visible words against the minimum for the page type, 30 points scaled by the share of the page's own text not found on any other page (80% or more = full). Template text found on a quarter of all pages (forms, call-to-action blocks) is set aside before comparing.

### Internal linking — 90.0

**Method:** Number of other crawled pages linking to the page: 5 or more = 100, 3-4 = 80, 2 = 50, 1 = 25, none = 0. Broken internal links are covered by category 1.

### Structured data — 96.0

**Method:** Valid JSON-LD = 25, Organization = 15, BreadcrumbList on inner pages = 20, the type that fits the page = 40 (Service, BlogPosting, JobPosting, ContactPage, WebSite on home, WebPage on others). Listings with plain WebPage get 30 (CollectionPage would fit better). Product pages get 20 of 40: Product markup has no offers, review or rating, which Google needs for product results. Case studies get 0 of 40: no Article markup.

### Images and alt text — 100.0

**Method:** Share of images with an alt attribute = 80, share of pages with a sharing image = 20. Empty alt on decorative images counts as correct.

### Social sharing and mobile tags — 100.0

**Method:** Seven tags, equal points: og:title, og:description, og:image, og:type, twitter:card, viewport, html lang.

### Page speed (Lighthouse mobile) — 56.6

**Method:** Average Lighthouse performance score, mobile settings (simulated slow 4G, 4x CPU slowdown), on the local XAMPP server, which does not compress text. Production numbers will differ.

| Page | Performance | SEO | Accessibility | Best practices | FCP | LCP | CLS | TBT | Page weight |
|---|---:|---:|---:|---:|---:|---:|---:|---:|---:|
| `/about` | 59 | 100 | 96 | 96 | 6.31 s | 17.19 s | 0.003 | 79 ms | 3.2 MB |
| `/areas-we-serve` | 57 | 100 | 100 | 100 | 7.81 s | 16.21 s | 0 | 27 ms | 2.92 MB |
| `/blog` | 57 | 100 | 100 | 100 | 7.81 s | 17.41 s | 0 | 27 ms | 3.24 MB |
| `/careers/web-developer` | 57 | 100 | 96 | 100 | 7.81 s | 16.21 s | 0 | 22 ms | 2.92 MB |
| `/contact` | 57 | 100 | 100 | 100 | 7.81 s | 16.89 s | 0.003 | 78 ms | 3.82 MB |
| `/` | 50 | 100 | 97 | 93 | 8.56 s | 17.64 s | 0 | 301 ms | 3.58 MB |
| `/blog/how-to-plan-a-business-website-that-generates-enquiries` | 57 | 100 | 100 | 100 | 7.96 s | 16.81 s | 0 | 0 ms | 2.99 MB |
| `/privacy-policy` | 56 | 100 | 100 | 100 | 9.01 s | 15.61 s | 0 | 0 ms | 2.5 MB |
| `/products/customer-portal` | 56 | 100 | 100 | 96 | 8.86 s | 16.36 s | 0 | 23 ms | 2.93 MB |
| `/services/website-development` | 58 | 100 | 100 | 100 | 7.36 s | 16.66 s | 0 | 74 ms | 2.99 MB |
| `/services` | 59 | 100 | 95 | 100 | 6.31 s | 17.71 s | 0 | 84 ms | 3.3 MB |

### Local SEO — 66.9

**Method:** each check scores 0 to 1 (a share where it applies to many pages); the category is the average × 100.

| Check | Result |
|---|---:|
| Business markup with name, phone and email on every page | Pass |
| Street address and postcode in the markup | Fail |
| Map coordinates (geo) in the markup | Fail |
| Areas served listed in the markup | Pass |
| Google Business Profile or other directory listing linked (sameAs) | Fail |
| Town and phone visible on every indexable page | Pass |
| Areas We Serve page is indexable with 500+ words | Pass |
| Contact page shows a map | Pass |
| Service pages name a local place in their own text (beyond the shared template) | Pass |
| Key pages name the location in the title | Pass |
| Blog posts on local topics (place in the title) | 36.4% |

## Lowest-scoring pages

| URL | Metadata points | Content points |
|---|---:|---:|
| `/blog/category/wordpress` | 100 | 71.1 |
| `/blog` | 100 | 71.5 |
| `/blog/category/web-development` | 100 | 71.7 |
| `/case-studies/taking-a-local-retailer-online` | 100 | 72.6 |
| `/blog/page/2` | 100 | 72.7 |
| `/blog/category/custom-software` | 100 | 73.8 |
| `/blog/category/ui-ux-design` | 100 | 74.6 |
| `/blog/category/digital-transformation` | 100 | 75 |
| `/blog/category/cloud-and-aws` | 100 | 75.4 |
| `/case-studies/moving-a-business-application-to-aws` | 100 | 81.8 |
| `/case-studies/replacing-spreadsheets-with-custom-software` | 100 | 85.5 |
| `/careers/cloud-engineer` | 100 | 86.8 |
| `/careers/internships` | 100 | 88.4 |
| `/careers/wordpress-developer` | 100 | 88.6 |
| `/careers/ui-ux-designer` | 100 | 90 |

The job openings and product pages are the weakest because they are short and share most of their text with similar pages. The content audit gives the fix for each.

## Lighthouse runs, page by page

**Settings:** mobile (simulated slow 4G, 4× CPU slowdown), on the local XAMPP server, which has no text compression.

**Repeat runs:** the homepage and About were each measured three times, and the table uses the middle result.
- Homepage: 31, 50 and 54 (median 50). The first run had a 1.7 s blocking time that did not recur.
- About: 60, 56 and 59 (median 59).

All runs are kept with the test files. Other pages were measured once.

**Why LCP is 15 to 18 s everywhere:** the local server sends CSS and JavaScript uncompressed, and the theme's main stylesheet alone is 608 KB. Lighthouse expects the live server, with compression on, to be much faster. Re-measure there before judging speed.

## Issues found, by area

| Area | Finding | Effect | Fix |
|---|---|---|---|
| Technical | `/blog/page/2` is indexable but not in the sitemap | None. Paginated pages need not be listed | None needed |
| Technical | HTTPS, HSTS and the www redirect are not active locally (rules commented out in `.htaccess`) | Needed on the live site | Deployment guide, step 6 |
| Technical | `PUBLIC_URL` is local, so canonical URLs point to `localhost` | Correct once `PUBLIC_URL=https://girzock.com` is set | Deployment guide, step 3 |
| On-page | 13 titles over 60 characters and 16 descriptions under 70, all on noindex pages (sample portfolio items, tag pages) | None for search; these pages are not indexed | Optional |
| On-page | `/services` has one heading level skip: a counter uses H4 after H2 | Minor, for accessibility tools | Change the counter to a styled paragraph |
| Content | Job openings and product pages are short and mostly template text | The weakest pages for search | `CONTENT_QUALITY_AUDIT.md` has a plan for each page |
| Structured data | Product markup has no offers, review or rating; case studies have no Article markup; job postings have no `validThrough` | No product or job rich results until real data exists | Add only real facts; Article markup is a small code change |
| Structured data | All JSON-LD on the 89 crawled pages parsed without errors. Google's Rich Results Test needs a public URL, so it was not run | — | Run it after launch |
| Internal linking | Product pages are linked from one page (`/products`), and case studies from two | Weaker discovery | Link each product from its matching service page |
| Images | 923 images on indexable pages, all with an `alt` attribute. 555 empty alt values are decorative repeats. 22 distinct images have no width or height attribute (mostly SVG icons), and 5 below-the-fold images do not lazy-load | Small layout and speed cost | Add sizes to the SVG icons; lazy-load the 5 |
| Mobile | No sideways scroll on any page at 320 to 1920 px. Viewport and language set on every page. The audit's "past the right edge" readings are the closed slide-out menu, parked off-screen inside a clipped container | None | None needed |
| Local | No street address, PIN code, map coordinates or Google Business Profile link stored | The biggest local gap | See below |

## What would raise the score, in order of effect

| # | Action | Category | Who |
|---|---|---|---|
| 1 | Add the full street address and PIN code, and map coordinates, in **Website Settings**. The markup then gains `streetAddress`, `postalCode` and `geo`. A code change is needed for the extra fields | Local SEO | You supply the address; a small code change |
| 2 | Create or claim the Google Business Profile, then add its link as a social profile | Local SEO | You |
| 3 | Write more local-topic blog posts (36% of posts have a place in the title) | Local SEO, content | You or a writer |
| 4 | Fill in the job role details, and add product details and case study results | Content | You |
| 5 | Turn on compression and caching on the live server (the local XAMPP has no `mod_deflate`) and check speed again | Speed | Hosting |
| 6 | Add Article markup to case studies, and CollectionPage to listings | Structured data | Small code change |
| 7 | After launch: verify the site in Google Search Console, submit `sitemap.xml` and check the Rich Results Test | Indexability | You |

## Not measured here

These need the public site:
- HTTPS and HSTS;
- real server speed;
- the Search Console index report;
- links from other sites;
- Google Business Profile status;
- the Rich Results Test.

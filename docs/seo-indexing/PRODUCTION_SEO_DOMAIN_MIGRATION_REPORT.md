# Production SEO domain migration and domain standardisation report

GIRZOCK Technologies, https://girzock.com/. CodeIgniter 3, PHP 8.2, MySQL. Prepared 8 November 2026.

**Status: code changes finished and tested. Nothing is deployed and no production database change has been run.** Both are waiting for your approval. The local database was only read; its fingerprint was identical before and after the work. All tests ran on separate copies.

## Summary

| Area | Result |
|---|---|
| Indexable pages | 53, all in the sitemap. Each has one self canonical on `https://girzock.com`, `index, follow`, and complete page-specific Open Graph and Twitter tags. |
| Noindex pages | Search results, 404, blog tags, thin blog categories, 13 sample portfolio projects, 3 sample case studies, admin, previews, drafts |
| Wrong-domain URLs in page output (localhost, 127.0.0.1, http://, www) | 0 in every indexable page, checked on rendered HTML |
| Wrong-domain URLs in the database | 0 (every table checked) |
| Wrong-domain URLs hard-coded in the code | 0 |
| OG and Twitter images | All absolute `https://girzock.com` URLs that return 200. Declared width and height match the real files. |
| Structured data | All first-party URLs, `@id` and `mainEntityOfPage` values on `https://girzock.com`. No invented ratings, reviews or addresses. |
| Database migration | Prepared and tested on copies. On today's data it changes 0 rows. Rollback tested. **Not run.** |

## 1. Complete page inventory

Public URLs found by following every link from every indexable page, plus every database record. Admin pages and form endpoints are listed in section 3.

| Section | Indexable | Noindex (public, reachable) |
|---|---:|---:|
| Homepage | 1 | 0 |
| Main pages | 3 | 0 |
| Legal | 3 | 0 |
| Services | 17 | 0 |
| Products | 7 | 0 |
| Portfolio | 1 | 13 |
| Case studies | 1 | 3 |
| Blog | 12 | 0 |
| Blog categories | 2 | 5 |
| Blog tags | 0 | 13 |
| Careers | 6 | 0 |
| **Total** | **53** | **34** |

**Not public** (404 to visitors): drafts and unpublished items. **Private** (sign-in required): the admin area. Both are listed in section 3.

## 2. Indexable pages (53)

Each page below was fetched from a copy of the current content, running with the production settings (`APP_ENV=production`, `BASE_URL=https://girzock.com/`, `PUBLIC_URL=https://girzock.com`). Each one passed:
- HTTP 200;
- exactly one canonical, equal to the URL;
- exactly one robots tag, `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1`;
- `og:url` equal to the canonical;
- no duplicate OG or Twitter tags;
- an image that returns 200;
- a unique title and a unique description.

| # | URL | Title | Desc. | og:type | Structured data |
|---:|---|---:|---:|---|---|
| 1 | https://girzock.com/ | 79 | 226 | website | Organization+ProfessionalService, WebSite, WebPage |
| 2 | https://girzock.com/about | 57 | 142 | website | Organization+ProfessionalService, WebPage, BreadcrumbList |
| 3 | https://girzock.com/services | 55 | 144 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |
| 4 | https://girzock.com/products | 47 | 142 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |
| 5 | https://girzock.com/portfolio | 52 | 150 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |
| 6 | https://girzock.com/case-studies | 48 | 149 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |
| 7 | https://girzock.com/blog | 48 | 149 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |
| 8 | https://girzock.com/careers | 56 | 153 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |
| 9 | https://girzock.com/contact | 58 | 153 | website | Organization+ProfessionalService, ContactPage, BreadcrumbList |
| 10 | https://girzock.com/areas-we-serve | 55 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList |
| 11 | https://girzock.com/privacy-policy | 37 | 145 | website | Organization+ProfessionalService, WebPage, BreadcrumbList |
| 12 | https://girzock.com/terms | 43 | 152 | website | Organization+ProfessionalService, WebPage, BreadcrumbList |
| 13 | https://girzock.com/cookie-policy | 36 | 140 | website | Organization+ProfessionalService, WebPage, BreadcrumbList |
| 14 | https://girzock.com/services/website-development | 53 | 152 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 15 | https://girzock.com/services/custom-software-development | 52 | 150 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 16 | https://girzock.com/services/web-application-development | 58 | 141 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 17 | https://girzock.com/services/e-commerce-development | 54 | 139 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 18 | https://girzock.com/services/wordpress-development | 48 | 145 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 19 | https://girzock.com/services/ui-ux-design | 51 | 140 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 20 | https://girzock.com/services/cloud-solutions | 50 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 21 | https://girzock.com/services/aws-cloud-solutions | 50 | 136 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 22 | https://girzock.com/services/it-consulting | 58 | 143 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 23 | https://girzock.com/services/digital-transformation | 54 | 136 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 24 | https://girzock.com/services/crm-business-management-software | 44 | 147 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 25 | https://girzock.com/services/mobile-app-development | 50 | 147 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 26 | https://girzock.com/services/api-development-integration | 48 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 27 | https://girzock.com/services/website-maintenance-support | 49 | 147 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 28 | https://girzock.com/services/seo-services | 50 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 29 | https://girzock.com/services/digital-marketing-services | 51 | 148 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Service |
| 30 | https://girzock.com/products/business-website-platform | 55 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Product |
| 31 | https://girzock.com/products/online-store-platform | 52 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Product |
| 32 | https://girzock.com/products/business-management-software | 47 | 145 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Product |
| 33 | https://girzock.com/products/customer-portal | 57 | 145 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Product |
| 34 | https://girzock.com/products/booking-enquiry-system | 45 | 144 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Product |
| 35 | https://girzock.com/products/cloud-hosting-care-plan | 51 | 143 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, Product |
| 36 | https://girzock.com/careers/web-developer | 51 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, JobPosting |
| 37 | https://girzock.com/careers/software-developer | 56 | 145 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, JobPosting |
| 38 | https://girzock.com/careers/wordpress-developer | 51 | 147 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, JobPosting |
| 39 | https://girzock.com/careers/ui-ux-designer | 52 | 149 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, JobPosting |
| 40 | https://girzock.com/careers/internships | 54 | 153 | website | Organization+ProfessionalService, WebPage, BreadcrumbList, JobPosting |
| 41 | https://girzock.com/blog/why-small-businesses-in-tirunelveli-need-a-professional-website | 57 | 154 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 42 | https://girzock.com/blog/how-to-choose-a-web-development-company-in-tirunelveli | 54 | 152 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 43 | https://girzock.com/blog/website-development-cost-in-tamil-nadu-business-guide | 57 | 149 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 44 | https://girzock.com/blog/ecommerce-website-development-for-growing-businesses-in-tamil-nadu | 53 | 146 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 45 | https://girzock.com/blog/website-maintenance-and-security-business-guide | 50 | 145 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 46 | https://girzock.com/blog/how-to-plan-a-business-website-that-generates-enquiries | 60 | 151 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 47 | https://girzock.com/blog/custom-software-or-off-the-shelf-how-to-choose | 57 | 140 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 48 | https://girzock.com/blog/what-to-check-before-moving-your-business-to-the-cloud | 50 | 147 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 49 | https://girzock.com/blog/ui-ux-basics-every-business-owner-should-know | 55 | 144 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 50 | https://girzock.com/blog/wordpress-or-a-custom-built-website-which-suits-you | 55 | 146 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 51 | https://girzock.com/blog/a-practical-first-step-towards-digital-transformation | 58 | 141 | article | Organization+ProfessionalService, WebPage, BreadcrumbList, BlogPosting |
| 52 | https://girzock.com/blog/category/web-development | 47 | 132 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |
| 53 | https://girzock.com/blog/category/wordpress | 41 | 128 | website | Organization+ProfessionalService, CollectionPage, BreadcrumbList |

Title and description lengths are in characters. **Not in the sitemap by design:** paginated blog lists such as `/blog/page/2`. They are indexable, with their own self canonical and `rel="prev"` and `rel="next"` links.

## 3. Noindex and private pages, with reasons

Noindex pages print **no canonical link**, so robots and canonical never disagree. They are never in the sitemap.

| URL | HTTP | Robots | Reason |
|---|---:|---|---|
| https://girzock.com/search?q=website | 200 | noindex, follow | Internal search results |
| https://girzock.com/blog?q=website | 200 | noindex, follow | Blog search results |
| https://girzock.com/this-page-does-not-exist | 404 | noindex, follow | 404 page |
| https://girzock.com/blog/tag/advertising | 200 | noindex, follow | Blog tag archive (thin, overlaps categories) |
| https://girzock.com/portfolio/business-website-sample-concept | 200 | noindex, follow | Sample portfolio project (set to noindex in admin) |
| https://girzock.com/portfolio/online-store-for-a-local-retailer | 200 | noindex, follow | Sample portfolio project (set to noindex in admin) |
| https://girzock.com/admin/login | 200 | noindex, nofollow (+ X-Robots-Tag header) | Admin sign-in |
| https://girzock.com/admin/forgot-password | 200 | noindex, nofollow (+ X-Robots-Tag header) | Admin sign-in |
| https://girzock.com/admin | 307 | noindex, nofollow (+ X-Robots-Tag header) | Admin area, sign-in required (redirects to login) |
| https://girzock.com/admin/job-applications | 307 | noindex, nofollow (+ X-Robots-Tag header) | Admin area, sign-in required (redirects to login) |
| https://girzock.com/admin/job-applications/view/1 | 307 | noindex, nofollow (+ X-Robots-Tag header) | Admin area, sign-in required (redirects to login) |
| https://girzock.com/blog/digital-solutions-for-businesses-in-thoothukudi | 404 | not served (404); admin preview is noindex, nofollow | Draft content |
| https://girzock.com/blog/domain-hosting-and-ssl-explained-for-business-owners | 404 | not served (404); admin preview is noindex, nofollow | Draft content |
| https://girzock.com/blog/how-crm-software-helps-small-businesses-manage-customers | 404 | not served (404); admin preview is noindex, nofollow | Draft content |
| https://girzock.com/contact/submit | 307 | Disallow in robots.txt; POST-only form endpoint | Form submission / thank-you response (shown in place, no separate page) |
| https://girzock.com/careers/apply | 307 | Disallow in robots.txt; POST-only form endpoint | Form submission / thank-you response (shown in place, no separate page) |
| https://girzock.com/case-studies/taking-a-local-retailer-online | 200 | noindex, follow | Sample case study (labelled "Sample concept, not a client project"); noindex by default in code |
| https://girzock.com/case-studies/replacing-spreadsheets-with-custom-software | 200 | noindex, follow | Sample case study (labelled "Sample concept, not a client project"); noindex by default in code |
| https://girzock.com/case-studies/moving-a-business-application-to-aws | 200 | noindex, follow | Sample case study (labelled "Sample concept, not a client project"); noindex by default in code |
| https://girzock.com/blog/category/custom-software | 200 | noindex, follow | Thin blog category (1 published article); noindex by default in code until it has 2 |
| https://girzock.com/blog/category/cloud-and-aws | 200 | noindex, follow | Thin blog category (1 published article); noindex by default in code until it has 2 |
| https://girzock.com/blog/category/ui-ux-design | 200 | noindex, follow | Thin blog category (1 published article); noindex by default in code until it has 2 |
| https://girzock.com/blog/category/digital-transformation | 200 | noindex, follow | Thin blog category (1 published article); noindex by default in code until it has 2 |
| https://girzock.com/blog/category/digital-marketing | 200 | noindex, follow | Thin blog category (0 published articles); noindex by default in code until it has 2 |

**13 sample portfolio projects:** `noindex, follow`. This was already set in the admin and is unchanged.

`/portfolio/online-store-for-a-local-retailer`, `/portfolio/custom-business-management-system`, `/portfolio/cloud-application-migration`, `/portfolio/corporate-website-development`, `/portfolio/business-website-sample-concept`, `/portfolio/web-application-sample-concept`, `/portfolio/online-store-sample-concept`, `/portfolio/customer-portal-sample-concept`, `/portfolio/product-catalogue-sample-concept`, `/portfolio/wordpress-website-sample-concept`, `/portfolio/landing-page-sample-concept`, `/portfolio/storefront-redesign-sample-concept`, `/portfolio/admin-dashboard-sample-concept`.

**12 blog tag archives:** `noindex, follow`. They are thin and overlap the categories.

`/blog/tag/web`, `/blog/tag/business`, `/blog/tag/tirunelveli`, `/blog/tag/tamil-nadu`, `/blog/tag/e-commerce`, `/blog/tag/wordpress`, `/blog/tag/security`, `/blog/tag/software`, `/blog/tag/cloud`, `/blog/tag/aws`, `/blog/tag/design`, `/blog/tag/technology`.

**New default rules in code.** You can override any single page by choosing "index, follow" in its admin SEO settings, and both the page and the sitemap follow that choice (tested):
- **Sample case studies:** a case study whose card or status label contains "Sample" is `noindex, follow`.
- **Thin blog categories:** a blog category with fewer than 2 published articles is `noindex, follow`. It returns to the sitemap automatically once it has 2.

**Security does not rely on robots:**
- **Admin pages** need a signed-in session. They also send `X-Robots-Tag: noindex, nofollow` and the matching meta tag.
- **Resumes and `.env`** live in `girzock-private`, outside `public_html`.
- **Source files:** `.htaccess` returns 403 for `application/`, `system/`, `database/`, `docs/`, dotfiles, `.sql` and `.md`.
- **Drafts** return 404 to visitors. An admin preview is `noindex, nofollow` in both the meta tag and the header.

## 4. Old and new canonical URLs

For the 53 indexable pages, the canonical URL has the same address as before. What changed is how the canonical is chosen and cleaned for every other kind of request:

| Request or situation | Before | Now |
|---|---|---|
| `/` | `https://girzock.com/` | `https://girzock.com/` (unchanged) |
| `/about/` (trailing slash) | `https://girzock.com/about` | `https://girzock.com/about` |
| `/about?utm_campaign=x&fbclid=abc` | `https://girzock.com/about` | `https://girzock.com/about` |
| `/blog?q=website` (search) | `https://girzock.com/blog?q=website` | no canonical, `noindex, follow` |
| `/search?q=...`, 404 page, blog tags | self canonical plus noindex (mixed signals) | no canonical, `noindex, follow` |
| 13 sample portfolio projects | self canonical plus noindex | no canonical, `noindex, follow` |
| 3 sample case studies | `https://girzock.com/case-studies/<slug>`, indexed | no canonical, `noindex, follow` |
| 4 blog categories with 1 article (the empty one was already noindex) | indexed, self canonical | no canonical, `noindex, follow` |
| Saved override with localhost, http, www, `?` or `#` | printed as saved | cleaned to `https://girzock.com/<path>`, or ignored if invalid |
| Saved override pointing a non-homepage at the homepage | printed as saved | ignored; the page uses its own URL |
| `PUBLIC_URL` set to `http://www.girzock.com/` by mistake | `http://www.girzock.com/...` | `https://girzock.com/...` |
| Saved social image with a local or www address | printed as saved | rewritten to `https://girzock.com/<path>` |

Stored overrides in the database today: 1 (`page/home` = `https://girzock.com/`, valid, kept).

## 5. Open Graph audit

Checked on every indexable page from the rendered HTML:
- `og:type`, `og:site_name` (GIRZOCK Technologies), `og:url`, `og:title`, `og:description`, `og:image` and `og:image:alt` are present, each exactly once;
- `og:url` equals the canonical;
- `og:type` is `article` for blog posts and `website` elsewhere;
- `og:image` is an absolute `https://girzock.com` URL that returns 200, and the declared `og:image:width` and `og:image:height` match the real file.

Images in use:

| Image | HTTP | Size (px) | Used on |
|---|---:|---|---:|
| https://girzock.com/girzock-hero.png | 200 | 1600 x 1991 | 1 pages |
| https://girzock.com/assets/logos/girzock-horizontal-color.png | 200 | 3000 x 1098 | 19 pages |
| https://girzock.com/assets/images/generated/pro/services/website-development.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/custom-software-development.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/photo/services/web-application-development.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/e-commerce-development.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/wordpress-development.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/ui-ux-design.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/cloud-solutions.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/aws-cloud-solutions.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/it-consulting.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/digital-transformation.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/crm-business-management-software.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/mobile-app-development.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/api-development-integration.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/website-maintenance-support.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/seo-services.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/generated/pro/services/digital-marketing-services.webp | 200 | 912 x 1122 | 1 pages |
| https://girzock.com/assets/images/event/product-1.png | 200 | 305 x 314 | 1 pages |
| https://girzock.com/assets/images/event/product-2.png | 200 | 305 x 314 | 1 pages |
| https://girzock.com/assets/images/event/product-3.png | 200 | 305 x 314 | 1 pages |
| https://girzock.com/assets/images/event/product-4.png | 200 | 305 x 314 | 1 pages |
| https://girzock.com/assets/images/event/product-5.png | 200 | 305 x 314 | 1 pages |
| https://girzock.com/assets/images/event/product-6.png | 200 | 305 x 314 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/why-small-business-website.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/choose-company.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/photo/blog/website-cost.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/ecommerce-planning.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/maintenance-security.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/plan-business-website.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/custom-or-off-the-shelf.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/cloud-migration-checklist.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/ux-basics.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/wordpress-or-custom.webp | 200 | 1200 x 900 | 1 pages |
| https://girzock.com/assets/images/generated/pro/blog/digital-first-step.webp | 200 | 1200 x 900 | 1 pages |

**All images that were chosen before are kept.** That includes the homepage image (`girzock-hero.png`), each service, article and product image, and the brand logo as the default.

## 6. Twitter Card audit

Checked on every indexable page:
- `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image` and `twitter:image:alt` are present, each exactly once;
- the image is the same as `og:image`, an absolute `https://girzock.com` URL that returns 200;
- the card type is `summary_large_image` when the page has its own image, and `summary` for the default logo;
- the homepage uses the Twitter title and description saved in Website Settings.

## 7. Structured data audit

| Type | Where | Checks |
|---|---|---|
| Organization + ProfessionalService | every page | `url` https://girzock.com/. `logo` and `image` on https://girzock.com. `sameAs` lists only the 3 profiles saved in Website Settings (LinkedIn, Facebook, Instagram). `email` girzock@gmail.com. Phone and address come from Website Settings. |
| WebSite | homepage | `url` https://girzock.com/. SearchAction target https://girzock.com/search?q= |
| WebPage, CollectionPage or ContactPage | every page | `url` equals the canonical |
| BreadcrumbList | every page except home | every `item` on https://girzock.com |
| Service | service pages | `url` equals the canonical; provider is the Organization |
| Product | product pages | `url` equals the canonical; image on https://girzock.com |
| BlogPosting | articles | `mainEntityOfPage` equals the canonical; publisher logo on https://girzock.com |
| JobPosting | career pages | `hiringOrganization.sameAs` https://girzock.com/ |

There are no `aggregateRating`, `review`, award, certification or customer-count claims anywhere. LocalBusiness is not used: the verified address is locality-level only, so Organization + ProfessionalService with `areaServed` stays.

## 8. Sitemap validation

| Check | Result |
|---|---|
| `/sitemap.xml` | 200, `application/xml`, valid, 53 URLs, no duplicates |
| URL form | all `https://girzock.com/...`: no www, no query, no fragment, no trailing slash except the homepage |
| Every URL returns 200 with a matching self canonical | Pass |
| Every linked indexable page is listed | Pass |
| Left out | noindex pages, sample case studies, thin categories, pages whose canonical points elsewhere, drafts, admin and search pages |
| `lastmod` | set for services, products, careers and articles, from their last update |
| Automatic | built from the database on every request, so publishing, editing, unpublishing or changing indexing shows at once |

## 9. robots.txt validation

```
User-agent: *
Disallow: /admin/
Disallow: /search
Disallow: /contact/submit
Disallow: /careers/apply

Sitemap: https://girzock.com/sitemap.xml
```

- The sitemap line is correct.
- Only `/admin/`, search and the two form endpoints are blocked. CSS, JavaScript, images and every public section can be crawled.
- No change was needed.

## 10. Internal URL audit

| Where | Search | Result |
|---|---|---|
| PHP: controllers, models, helpers, libraries, views, email templates, config | localhost/girzock-website, 127.0.0.1, http://girzock.com, http://www.girzock.com, https://www.girzock.com | none, except `memcached.php` (an unused CodeIgniter default) and the helper that recognises local addresses |
| JavaScript and CSS (source and minified) | same | none |
| `.htaccess`, `index.php` | same | none. The www-to-non-www and HTTPS redirects are written but commented out until SSL is active. |
| Rendered HTML of all 53 indexable pages (production settings) | same | none |
| All 87 internal links on those pages | broken or wrong-domain links | none |
| Email templates | website links | built with `site_url()`, so they follow `BASE_URL` (https://girzock.com/ on live). No phone number or email address was changed. |

**Every first-party link is built from the environment:**
- `site_url()` and `base_url()` use `BASE_URL` from `.env`;
- SEO URLs use `PUBLIC_URL`, cleaned to https and non-www;
- admin previews show the production address.

A local copy therefore keeps working on `http://localhost/girzock-website/`. Third-party and social profile URLs are untouched.

## 11. Database tables and affected record IDs

Every table was searched in a full export of the current database. Matches for `localhost` (outside the export header), `127.0.0.1`, `http://girzock`, `http://www.girzock` and `https://www.girzock` were all **0**.

| Table | Column | First-party URLs found | Needs change |
|---|---|---|---|
| seo_metadata | canonical_url | id for page/home: https://girzock.com/ | No (valid) |
| seo_metadata | og_image | relative paths only (for example girzock-hero.png) | No |
| website_settings | website_url | https://girzock.com | No |
| website_settings | default_og_image | assets/logos/girzock-horizontal-color.png | No |
| services, products, portfolio_projects, case_studies, blog_posts, career_openings | content and image fields | no absolute first-party URLs | No |

**Affected record IDs today: none.** The migration is a safety net for the production database, in case it was edited after this copy.

## 12. SQL migration file

The file is `docs/seo-indexing/production_seo_domain_migration.sql`.

- **PREVIEW (read-only):** lists every value it would change, with table, row, old and new value.
- **APPLY:** first records each change in `seo_domain_migration_log`, then updates only:
  - `seo_metadata.canonical_url`;
  - `seo_metadata.og_image`;
  - `website_settings.website_url`, `default_og_image` and `home_og_image`.
- **Rules:**
  - local, http and www addresses become `https://girzock.com/<same path>`, with the slug preserved;
  - the query, fragment and trailing slash are removed;
  - a non-homepage pointing at the homepage becomes empty, so the page uses its own URL;
  - local and www image addresses become site-relative paths;
  - values that are already correct are not touched.
- **Safe to rerun:** running it twice changes nothing the second time.
- **Compatibility:** MySQL 5.7+ and MariaDB 10.2+.

Tested on copies of the database:
- **Today's copy:** 0 rows changed, and the fingerprint is identical.
- **Seeded copy:** 8 wrong values of every kind were fixed exactly as described. Titles, descriptions, keywords, OG text, robots, row counts and all other settings were unchanged.

## 13. SQL rollback file

The file is `docs/seo-indexing/production_seo_domain_rollback.sql`.
- **What it does:** restores the exact old values from `seo_domain_migration_log`.
- **Later edits are protected:** a value edited again after the migration is not overwritten; it is listed for review. Tested.
- **Test result:** on the seeded copy, the rollback restored the exact pre-migration state (identical fingerprint).
- **Full fallback:** the phpMyAdmin export taken before running the migration.

## 14. Files modified

| File | Change |
|---|---|
| `application/config/girzock.php` | `gz_production_url` = https://girzock.com (used for admin previews, and only when `PUBLIC_URL` is not set) |
| `application/helpers/girzock_helper.php` | Canonical and domain functions: `seo_public_url` (cleans `PUBLIC_URL`), `seo_production_origin` and `seo_production_url`, `seo_normalize_url`, `seo_canonical_for`, `seo_is_home_url`, `seo_canonical_error` (rejects localhost, IPs, other domains, `?`, `#`, and the homepage for other pages), `seo_resolve_canonical`, `seo_first_party_path` |
| `application/libraries/Seo.php` | Clean canonical; `indexable` flag; first-party image URLs rewritten to the public origin |
| `application/views/frontend/partials/seo.php` | Canonical and `googlebot` tags only on indexable pages |
| `application/controllers/Sitemap.php` | Clean `loc`. Skips noindex pages, sample case studies, thin categories and pages whose canonical points elsewhere. No duplicates. |
| `application/controllers/CaseStudies.php`, `application/models/Case_study_model.php` | Sample case studies default to `noindex, follow`; `mainEntityOfPage` uses the clean canonical |
| `application/controllers/Blog.php` | Categories with fewer than 2 articles default to `noindex, follow`; `share_url` and `mainEntityOfPage` use the clean canonical |
| `application/controllers/Services.php`, `Products.php` | Schema `url` uses the clean canonical |
| `application/controllers/Home.php` | Legal pages read their own SEO entry |
| `application/controllers/admin/Seo.php`, `application/views/admin/seo/index.php` | Legal pages in Admin > SEO. New "Live URL (canonical)" column with a noindex badge. Stricter canonical validation. |
| `application/core/Admin_Crud_Controller.php` | Content forms use the stricter canonical validation; the search preview shows https://girzock.com |
| `application/views/admin/seo/page.php`, `application/views/admin/crud/form.php` | Production canonical shown as the placeholder and in the help text |
| `assets/admin/css/admin.css` | `.gz-break` so long URLs wrap in admin tables |
| `docs/seo-indexing/*` | This report, the migration and the rollback. `docs/` is not part of the upload package. |

No design, homepage layout, content, title, description, keyword, image or upload was changed. No application record was modified.

## 15. Test results

All tests ran against copies: `girzock_seo` (a copy of the current content, with production settings), `girzock_mig` (migration tests) and `girzock_test` (fresh install). The real local database was only read. Its only change during the work was a sign-in by the site owner at 13:13 (`last_login_at` and one activity-log row); no content or SEO row changed.

| Suite | What it covers | Passed | Failed |
|---|---|---:|---:|
| Production-domain SEO audit | All 53 indexable pages fetched with `BASE_URL`/`PUBLIC_URL` = https://girzock.com (detailed below) | 2065 | 0 |
| Database defense | Wrong values stored in the database still print clean https://girzock.com canonical, og:url and og:image | 11 | 0 |
| Migration and rollback | See the migration test list below | 22 | 0 |
| Admin SEO visual | Admin > SEO at 1440 px and 390 px: no sideways scroll, Live URL column, Edit buttons on one line, live canonical placeholder | 9 | 0 |
| Final content | Articles, services, page content | 812 | 0 |
| Public pages | | 107 | 0 |
| Admin | | 291 | 0 |
| SEO and delete | | 176 | 0 |
| Browser | | 53 | 0 |
| Uploads | | 77 | 0 |
| Forms and email | | 106 | 0 |
| Mega menu | Desktop and mobile | 234 | 0 |
| Dropdowns | | 202 | 0 |
| Favicon | | 22 | 0 |
| Popup admin | | 149 | 0 |
| Popup browser | Chromium, Firefox, WebKit; desktop and mobile | 438 | 0 |
| Email retry | | 6 | 0 |
| Social admin | | 90 | 0 |
| Social visual | | 307 | 0 |
| Admin login | | 170 | 0 |
| SEO image picker | | 67 | 0 |
| Careers and forms | Includes the delete dialog | 135 | 0 |

**The production-domain audit checks:**
- every indexable page returns 200, with exactly one self canonical and one robots tag;
- Open Graph and Twitter tags are complete and never duplicated;
- images return 200, and the declared size matches the real file;
- every JSON-LD URL, `@id` and `mainEntityOfPage` is on https://girzock.com;
- the rendered pages contain no localhost, 127.0.0.1, http:// or www URL;
- titles and descriptions are not duplicated;
- 87 internal links checked, none broken;
- the sitemap and robots.txt are correct;
- URL variations are handled: tracking parameters, trailing slash, `index.php`, pagination;
- noindex and sample pages, admin and drafts are handled correctly;
- the canonical rules pass unit tests;
- the admin forms reject localhost, IP, query, other-domain and homepage overrides.

**The migration tests check:**
- on today's copy, the migration changes 0 rows;
- on a seeded copy, it fixes 8 wrong values and leaves all other data unchanged;
- running it twice changes nothing more;
- the rollback restores the exact previous state and never overwrites later edits.

**Real local site** (http://localhost/girzock-website/, read-only requests): the homepage, about, services, a service, the blog, a sample case study, categories, the sitemap, robots.txt and the admin login all return 200 with the expected robots and canonical tags. Local development works.

**Expected log line:** "Resume file for deleted application #5 was missing" comes from a planted test that checks a hostile resume path is refused.


## 16. Remaining issues and recommendations

| # | Item | Severity | Action |
|---:|---|---|---|
| 1 | The HTTPS and www-to-non-www redirects in `.htaccess` are commented out | Must do at launch | Uncomment them as soon as the SSL certificate works (step 7 below) |
| 2 | The homepage SEO title is 79 characters; Google shows about 60 | Low | Optionally shorten it in Admin > SEO > Homepage |
| 3 | The homepage social image `girzock-hero.png` is portrait, 1600 x 1991, 3.1 MB. Facebook and LinkedIn crop it to 1.91:1. | Low | Optionally choose a 1200 x 630 landscape image in Admin > SEO > Homepage |
| 4 | All 3 case studies and all 13 portfolio items are samples, now all noindex | Content | Publish real client work when available and set it to index |
| 5 | 5 blog categories have fewer than 2 articles (now noindex) | Content | They return to search automatically at 2 articles |
| 6 | The 6 product pages use small images (305 x 314 each) and the 16 service pages use portrait images (912 x 1122). They are valid and return 200, but social sites show them small or cropped. | Low | Optionally choose 1200 x 630 social images per page in each edit form (Social sharing image) |
| 7 | A local copy without `PUBLIC_URL` uses local addresses in its own canonicals | By design | To preview production SEO output locally, add `PUBLIC_URL=https://girzock.com` to the local `.env` |

## 17. Production deployment instructions (after your approval)

1. **Back up first.** Export the production database in phpMyAdmin (Quick, SQL) and download the current site files.
2. **Upload the code** (the files in section 14, or the full package), then extract it into `public_html`. `girzock-private` stays outside `public_html`, and `.env` is never uploaded inside the web root or added to Git.
3. **Set up `girzock-private/.env` on the server:**
   ```
   APP_ENV=production
   BASE_URL=https://girzock.com/
   PUBLIC_URL=https://girzock.com
   COOKIE_SECURE=1
   ```
   Keep the database credentials and the existing keys.
4. **Preview the database changes.** Run the PREVIEW part of `production_seo_domain_migration.sql` in production phpMyAdmin.
   - Expected: no rows.
   - If rows appear, read them first.
5. **Only if the preview listed rows,** run the APPLY part, then read the log it prints. To undo, run `production_seo_domain_rollback.sql`.
6. **Check pages.** Open `https://girzock.com/`, `/about`, a service, an article and a sample case study. View the page source for:
   - the canonical, `og:url`, `og:image`, `twitter:image` and JSON-LD URLs, which must all be `https://girzock.com/...`;
   - the sample case study, which must be `noindex, follow` with no canonical.
7. **Turn on the redirects.** Once SSL works, uncomment the four HTTPS and www lines at the top of `.htaccess`, then confirm that:
   - `http://girzock.com/about` returns 301 to `https://girzock.com/about`;
   - `https://www.girzock.com/` returns 301 to `https://girzock.com/`.
8. **Check the sitemap.** Open `https://girzock.com/sitemap.xml` (expected: 53 URLs) and `https://girzock.com/robots.txt`.
9. **Search Console.** Submit the sitemap. Use URL Inspection on the homepage and two service pages, and run the Rich Results Test on the homepage and one article.
10. **Social previews.** Use the Facebook Sharing Debugger and LinkedIn Post Inspector on the homepage to refresh their cached previews.

# GIRZOCK Technologies: SEO Audit Report

Date: 7 November 2026. Fresh read-only crawl of the local build.

> **Superseded.** This is an earlier snapshot. The current results are in `COMPLETE_SEO_SCORE_REPORT.md`, `COMPLETE_PAGE_INVENTORY.md` and `CONTENT_QUALITY_AUDIT.md` (7 November 2026). Since this report, LinkedIn and Facebook icons are hidden until real addresses are added, and the six short blog posts were rewritten with H2 sections.

## Results
| Check | Result | Status |
|---|---|---|
| URLs crawled | 89, all HTTP 200 | PASS |
| Indexable pages | 62; 27 deliberately noindex (portfolio sample details, tag pages, search) | PASS |
| Sitemap | 61 URLs, no noindex or broken entries, built on each request | PASS |
| Indexable but not in the sitemap | `/blog/page/2`, by design | PASS |
| Duplicate titles or descriptions | 0 among indexable pages | PASS |
| One H1 per page | All pages | PASS |
| Canonical URL | On every page. The tag pagination mismatch is fixed | PASS |
| Open Graph and Twitter | On every page | PASS |
| Structured data | Valid JSON on every page: Organization, WebSite, WebPage or ContactPage, BreadcrumbList, Service (16), Product (6), BlogPosting (11), JobPosting (6) | PASS |
| robots.txt | Blocks admin, search and form endpoints, and names the sitemap | PASS |
| Legal pages | Added and in the sitemap | PASS, needs legal review |
| Empty blog category | Now noindex | PASS |
| Heading level skips | 14 audit readings: six older posts have no H2 before the sidebar, and a counter on `/services` uses H4 | PARTIAL |
| Product structured data | No offers or reviews, so Google product rich results may not apply. Do not invent them | PARTIAL |
| JobPosting | No `validThrough`. Confirm the vacancies are genuine | PARTIAL |
| Social profiles | LinkedIn and Facebook URLs empty | PARTIAL |
| Search Console, Analytics | Not configured | NOT IMPLEMENTED |
| Rich Results Test, live indexing | Need the public site | NOT TESTED |

## How SEO works when you publish a blog post
Sections 10 and 11 of the project report explain this step by step, with an example post. In short:
- **Filled automatically:** slug, canonical URL, BlogPosting data, Open Graph image, sitemap entry, breadcrumbs, related links.
- **Overrides:** SEO title, meta description, sharing image and indexing are optional fields on the post.
- **Manual:** submitting the sitemap and requesting indexing in Search Console.
- **Changing a slug** creates a 301 redirect automatically.

## The popup and SEO
The popup is not in the page's main content. Its images are not in the HTML, and it opens after the page has loaded. Its form is the same enquiry form, so it adds no indexable content.

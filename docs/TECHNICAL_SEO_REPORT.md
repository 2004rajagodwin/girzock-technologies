# Technical SEO Report

**Date:** 7 November 2026
**Measured on:** the local build, through a crawl of 89 URLs, 11 Lighthouse pages and read-only database checks. Production-only items are marked.

## 1. Results

| Area | Result | Status |
|---|---|---|
| XML sitemap | `/sitemap.xml`: 61 URLs, all HTTP 200, all indexable, all self-canonical. Every database record carries a lastmod date. No drafts, tag pages, empty categories or noindex pages | PASS |
| robots.txt | Blocks `/admin/`, `/search`, `/contact/submit`, `/careers/apply`, and names the sitemap | PASS |
| Canonical URLs | Every one of the 89 crawled pages has one, pointing to itself. Built from `PUBLIC_URL`, so they become `https://girzock.com/...` in production | PASS (locally `localhost` until `PUBLIC_URL` is set) |
| Redirects | 11 old addresses (10 `.html` pages and `/terms-and-conditions`) return 301 to their pages. A slug change adds a 301 automatically; a deleted record returns 410 | PASS |
| Broken internal links | 0 in the crawl. Editors now warn about links to detail pages that do not exist | PASS |
| Duplicate URLs and content | 0 duplicate titles and 0 duplicate descriptions among indexable pages. Index pages and `?page=` variants all canonicalise | PASS |
| Pagination | Each blog, category and tag page has its own title, canonical and prev/next. `/blog/page/2` is indexable but left out of the sitemap, which is normal | PASS |
| Empty categories | Digital Marketing has no posts, so it is noindex and not in the sitemap | PASS |
| Robots meta | Indexable pages: `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1`. Tags, sample portfolio items, search, previews and admin: noindex | PASS |
| Structured data | Organization + ProfessionalService on every page; WebSite on home; WebPage, CollectionPage or ContactPage; BreadcrumbList; Service (16); BlogPosting (11); Article (3 case studies); JobPosting (6); Product (6). All JSON-LD on 89 pages parsed without errors | PASS. Google's Rich Results Test needs the public URL |
| Image alt text | 923 images on indexable pages, all with an alt attribute. 555 are deliberately empty because they are decorative | PASS |
| Image dimensions | 22 distinct images (mostly SVG icons) have no width or height attribute | PARTIAL |
| Lazy loading | 5 below-the-fold images do not lazy-load. The homepage video loads only when it comes into view | PARTIAL |
| Image formats | 53 WebP images served, all with the right type. Uploads are converted to WebP. AVIF is not produced; WebP already covers current browsers, and AVIF would mean converting approved images again | PASS (AVIF not added) |
| CSS and JS loading | Scripts are `defer`. Icon fonts load without blocking. Theme CSS is minified (`style.min.css` 608 KB, mostly unused rules, from the original template) | PARTIAL |
| Browser caching | CSS, JS and images: `Cache-Control: public, max-age=2592000` (30 days), with version numbers on CSS and JS | PASS |
| Compression | The local XAMPP has no `mod_deflate`. `.htaccess` is ready for gzip, including `text/javascript`. **Check `Content-Encoding` on the live server** | Production |
| HTTPS redirects | Rules ready in `.htaccess`, commented out until the certificate works | Production |
| Security headers | `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, `X-Frame-Options` (SAMEORIGIN; DENY on admin). `X-Powered-By` removed. HSTS after HTTPS. A CSP was not added, because the site uses inline scripts; test it in report-only mode first | PARTIAL |
| Mobile usability | Viewport and language set on every page. No sideways scroll from 320 to 1920 px. The footer social icons now fit on one row at 320 px | PASS |
| Core Web Vitals | Layout shift 0.000 to 0.003 on all 11 pages. LCP 15.6 to 17.7 s locally, because there is no compression and slow mobile is simulated. Field data appears only after launch | PARTIAL |

## 2. Lighthouse, mobile, local server: before and after this pass

"Before" is the run at 18:00 on 7 November; "after" is the final run. The homepage and About show the median of three runs: homepage 31, 50, 54; About 60, 56, 59. This pass did not change anything aimed at speed, so differences of a few points are normal run-to-run variation.

| Page | Performance before → after | SEO | Accessibility | Best practices | LCP after | CLS after | Weight |
|---|---|---:|---:|---:|---:|---:|---:|
| `/` | 42 → 50 | 100 | 97 | 93 | 17.6 s | 0.000 | 3.58 MB |
| `/about` | 59 → 59 | 100 | 96 | 96 | 17.2 s | 0.003 | 3.20 MB |
| `/services` | 59 → 59 | 100 | 95 | 100 | 17.7 s | 0.000 | 3.30 MB |
| `/services/website-development` | 60 → 58 | 100 | 100 | 100 | 16.7 s | 0.000 | 2.99 MB |
| `/areas-we-serve` | 60 → 57 | 100 | 100 | 100 | 16.2 s | 0.000 | 2.92 MB |
| `/blog` | 60 → 57 | 100 | 100 | 100 | 17.4 s | 0.000 | 3.24 MB |
| a blog post | 60 → 57 | 100 | 100 | 100 | 16.8 s | 0.000 | 2.99 MB |
| `/contact` | 57 → 57 | 100 | 100 | 100 | 16.9 s | 0.003 | 3.82 MB |
| a product | 57 → 56 | 100 | 100 | 96 | 16.4 s | 0.000 | 2.93 MB |
| a job | 57 → 57 | 100 | 96 | 100 | 16.2 s | 0.000 | 2.92 MB |
| `/privacy-policy` | 57 → 56 | 100 | 100 | 100 | 15.6 s | 0.000 | 2.50 MB |

**Why LCP is high everywhere:** the local server sends text uncompressed. Turning on gzip or Brotli on the live server is the largest single speed gain available. After that, removing unused rules from the 608 KB template stylesheet would help most, but it touches the approved design, so it needs careful visual testing.

## 3. Production checks (after deployment)

1. `curl -I https://girzock.com/assets/css/style.min.css` shows `Content-Encoding: gzip` or `br`.
2. `http://` and `www.` redirect to `https://girzock.com/` with a 301.
3. Sitemap and canonical URLs show `https://girzock.com/`.
4. Add HSTS (`Strict-Transport-Security`) once HTTPS is confirmed.
5. Verify the property in Search Console. The verification code is already in the site's head, from Website Settings. Then submit the sitemap.
6. Run the Rich Results Test on a service, a blog post, a job and the homepage.
7. Rerun Lighthouse on the live site.

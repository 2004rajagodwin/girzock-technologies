# SEO, content and enquiry upgrade report

Completed 6 November 2026.

> **Superseded.** This is an earlier snapshot. The current results are in `COMPLETE_SEO_SCORE_REPORT.md`, `COMPLETE_PAGE_INVENTORY.md` and `CONTENT_QUALITY_AUDIT.md` (7 November 2026). Since this report, LinkedIn and Facebook icons are hidden until real addresses are added, and the six short blog posts were rewritten with H2 sections.

## Summary

| Item | Result |
|---|---|
| Enquiry delete | Done: trash icon on every row, confirmation, deleted without a reload |
| Pages with unique SEO | 52 indexable pages, all with unique titles, descriptions and H1s |
| Services | 15, each with a full page (417 to 615 words) |
| Blog articles drafted | 16 drafts, 610 to 704 words each, none published |
| Sitemap | 52 URLs, all live and indexable |
| Plagiarism check | **Pending: no checker was available** |

## Incident during this work

A test script was wrongly pointed at the real site for about a minute at 11:28 to 11:30 on 6 November. It created:

- 5 test enquiries (#2 to #6), 1 job application and its dummy resume
- 11 real emails through the configured Gmail account: 6 to girzock@gmail.com and 5 to @example.com addresses
- 4 failed login records and some rate-limit entries

Those records and the file were removed, matched by ID, address and time. Enquiry #1, the admin account and the SMTP settings were not changed. **The emails cannot be recalled:** expect 6 test notifications in the inbox, possibly with bounce messages. Enquiry numbers now continue from #7, because the database does not reuse numbers. All later tests ran against a separate database, and the test tools refuse to target the real site.

## Decisions to review

| Decision | Reason |
|---|---|
| "WordPress vs Custom" not drafted; "Domain, Hosting and SSL" and "Website or Mobile App" added | A published article already targets the WordPress question |
| No FAQ structured data | Google has retired FAQ rich results, so FAQs are visible content only |
| No separate city pages; one "Areas We Serve" page instead | Near-identical city pages risk being treated as doorway pages |
| Sample portfolio pages set to noindex | They show artwork rather than client work and are thin |
| Delete is permanent | As you asked. Archive and Restore remain on the enquiry page as the safe alternative |
| IT Consulting kept as a 15th service | It was existing business content |

## Local SEO terms targeted

Primary: software development company in Thisaiyanvilai; IT company in Thisaiyanvilai; website design company in Tirunelveli; software development company in Tirunelveli; web development services in Tirunelveli; SEO services in Tirunelveli; IT jobs in Tirunelveli.

Secondary, used only where relevant: digital solutions in Thoothukudi; digital transformation in Nagercoil; IT solutions provider in Kanyakumari; online presence in Thiruvananthapuram; e-commerce website development in Tamil Nadu; website development cost in Tamil Nadu.

The schema has one address (Thisaiyanvilai). Other places appear only as areas served.

## Originality

| Check | Result |
|---|---|
| Plagiarism or originality score | **Not checked. Verification is pending, so no score is claimed** |
| Internal duplicate check (38 documents, 703 pairs, shared 6-word phrases) | Highest overlap 2.1%, between two draft articles |
| Repeated opening sentences across drafts | None |

The internal check only compares our own pages with each other and cannot see the web. Please run the drafts and service pages through a tool such as Copyscape or Grammarly before publishing.

## Sources used in research

Facts stated in the content came from these sources. Local economic data was limited, so local detail is deliberately modest.

- [Google: improve your local ranking](https://support.google.com/business/answer/7091?hl=en), [guidelines for representing your business](https://support.google.com/business/answer/3038177?hl=en), [service areas](https://support.google.com/business/answer/9157481?hl=en)
- [web.dev: Web Vitals](https://web.dev/articles/vitals), [LCP](https://web.dev/articles/lcp), [INP](https://web.dev/articles/inp), [CLS](https://web.dev/articles/cls)
- [Google: changes to FAQ rich results](https://developers.google.com/search/blog/2023/08/howto-faq-changes)
- [Thisayanvilai](https://en.wikipedia.org/wiki/Thisayanvilai), [Economy of Thiruvananthapuram](https://en.wikipedia.org/wiki/Economy_of_Thiruvananthapuram), [Business Standard on Thoothukudi](https://www.business-standard.com/industry/news/thoothukudi-1-trillion-investment-revival-story-125072501388_1.html)
- [Patchstack figures reported by web60](https://web60.ie/blog/wordpress-plugin-vulnerabilities-record-2025)
- [CRM adoption: Lemon Learning](https://lemonlearning.com/blog/CRM-adoption-challenges)

## Test results

| Suite | Where it ran | Result |
|---|---|---|
| Public site, forms, security | Test database | 107 of 107 |
| Admin panel | Test database | 291 of 291 |
| SEO and enquiry delete, fresh run | Test database | 168 of 170: see below |
| Same suite, after fixing those two | Test database | 169 of 170: see below |
| Browser behaviour | Test database | 53 of 54: see below |
| Enquiry delete in a browser, responsive pages | Test database | 25 of 25 |
| Crawl, sitemap, schema | Real site, GET only | 128 of 128 |
| Fresh install from SQL plus migrations | Test database | Passed |

Failures explained:

- **About title length and "site:" check:** the first came from the admin suite resetting that title in the test copy, the second from my check matching the word "website:". Neither was a site fault, and both passed on the rerun.
- **"Role without permission" on the rerun:** the test user already existed from the first run, where this check passed.
- **Browser "9 services in mega menu":** the expectation predates the new services. The new visual test confirms 15.

After those runs, small changes were made to link text, the side-panel links and slider CSS loading. They were checked by a further browser check on the real site, a Lighthouse rerun and a page smoke test, not by rerunning the full suites.

## Design comparison with the original

Compared at 1920, 1440, 1024, 768 and 375 px. Every difference found is a requested change: new H1 wording, added services, the homepage local section, the contact form's new service options and new footer links. The blog listing differs as before. One hidden heading was removed from the Services page.

## Performance

Lighthouse on localhost, with compression off. Treat these as before-and-after comparisons, not as live-site scores.

| Page | Measure | Before | After |
|---|---|---|---|
| Home, desktop | Performance | 52 | 68 |
| Home, desktop | LCP | 5.1 s | 2.6 s |
| Home, desktop | CLS | 0.32 | 0.247 |
| Home, desktop | Page weight | 12,976 KiB | 8,622 KiB |
| Home, mobile | Performance | 51 | 40 |
| Home, mobile | LCP | 22.5 s | 12.6 s |
| Home, mobile | Page weight | 11,362 KiB | 8,414 KiB |
| Home | SEO | 83 | 92 |
| Services, mobile | Performance | 59 | 55 |
| Services, mobile | LCP | 17.0 s | 13.2 s |
| Services, mobile | Page weight | 4,167 KiB | 2,917 KiB |

Weight and LCP improved, but **the mobile Performance score fell on the two pages measured**, because Total Blocking Time rose in the final run (home 260 ms to 760 ms). That figure varied a lot between runs on this PC. Mobile performance is not solved, and a real measurement on the live server is needed.

## Remaining issues

1. **Mobile speed:** LCP is still far above Google's 2.5 s target in this local test. Turning on compression should help: Lighthouse estimates 1,220 KiB of savings. The main stylesheet is 623 KB.
2. **Homepage layout shift:** CLS 0.247 on desktop exceeds the 0.1 target. The main cause is the hero text block moving as it loads. Fixing it may require changing how the hero animation works, so it was left for you to decide.
3. **SEO score 92:** the remaining flag is the "coming soon" LinkedIn and Facebook icons, which have no link. It clears once you add the real URLs in Website Settings.
4. **Structured data:** checked with my own parser. Google's Rich Results Test needs a public URL.
5. **Services with no profile checks:** Mobile App, SEO and CRM are listed because you asked. Please confirm the team can deliver them as described.

## Before going live

1. Replace the Gmail App Password, and enter it again on the live server.
2. Review and publish the drafts, after running them through a plagiarism checker.
3. Set `APP_ENV=production`, the https `BASE_URL` and `COOKIE_SECURE=1`.
4. Run `php index.php setup migrate` on the live database.
5. Turn on `mod_deflate` and the HTTPS redirects.
6. Set up Search Console, the sitemap, GA4 and Google Business Profile: see the README.
7. Add LinkedIn and Facebook URLs, if you have them.

## Files changed

**New:** `application/migrations/002_seo_fields_and_service_sections.php`, `003_seo_content.php`, `migrations/data/` (services, pages, blog_drafts), `views/frontend/home/areas.php`, `database/tools/build_webp.php`, `database/tools/minify_assets.js`, `docs/SEO_UPGRADE_REPORT.md`, `assets/*/*.min.*`, and `.webp` copies in `assets/images`.

**Changed:**
- Controllers: Home, Services, Products, Portfolio, CaseStudies, Blog, Careers, Contact, Sitemap, admin/Enquiries, admin/Services, admin/Seo
- Core and libraries: MY_Controller, MY_Model, Admin_Crud_Controller, Seo, Html_sanitizer
- Models: Settings, Service, Product, Portfolio, Blog, Enquiry
- Views: home, about, services, products, portfolio, case studies, careers, contact, layouts, nav, overlays, headers, footer, SEO partial, admin enquiries, admin form, admin SEO
- Other: `girzock_helper.php`, `routes.php`, `migration.php`, `.htaccess`, `README.md`, `admin.js`, `admin.css`, `girzock.js`, `girzock-dynamic.css`

**Backups:** `../backups/before-seo-upgrade-2026-11-06/`, holding the database and code from before this work.

**Not changed:** `.env`, `SECRET_BOX_KEY`, the SMTP settings and the existing images.

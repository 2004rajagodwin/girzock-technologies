# GIRZOCK Technologies: Visual Upgrade, WebP Pipeline and Mega Menu

Date: 6 November 2026. Site tested: `http://localhost/girzock-website/` (local XAMPP). The site is not public yet, so nothing that needs a public URL has been run.

## 1. Summary

- The services mega menu now works on all public pages, using one shared menu.
- 29 original illustrations and 26 unique gradient icons are live.
- Every new upload is now stored as WebP, or refused with a clear message.
- All automated tests pass (section 10).

**Still open:** the plagiarism check has not been run, and mobile loading is slow (section 12).

The brief referred to uploaded screenshots, but none arrived with the message. The work was based on the live sections you named.

## 2. Homepage

The brief said the homepage must not change, yet it also asked for changes to three things that appear there. I changed only those three:

| Changed on the homepage | What changed |
|---|---|
| Services mega menu | New preview image for each of the 15 services |
| Technology for Local Businesses | 26 unique icons and a small hover lift, at the same 30 px size |
| Insights | New images on the 3 article cards |

**Comparison with a baseline taken before any change:** 14 captures (7 widths, light and dark).

- Same section positions and sizes, page height, fonts, colours and text. No sideways scrolling and no failed requests.
- The only image paths that differ are the three items above.
- The checker flagged 2 differences, both in the hero text. Both were the counter caught mid-animation (`7+` against `8+`).
- This compared measurements and image paths, not pixel-by-pixel images. I also reviewed the changed sections by eye at 1440.

Hero, sliders, service sections and other homepage images were not touched and not converted. Invisible changes: a body class and responsive image attributes on the Insights cards.

## 3. Mega menu

**Root cause:** there was no broken path or missing script. `nav.php` only rendered the mega menu when `$is_home` was true, so subpages got a plain dropdown. All its CSS was also limited to the homepage.

**Fix:** one shared menu for every page, in `partials/nav.php`, and the styling now applies site-wide. The mobile menu also uses one list of services everywhere.

**Tested on 16 pages:** Home, About, Services, 2 service pages, Products, Case Studies, a case study, Portfolio, Blog, Blog page 2, an article, Careers, Contact, Areas We Serve and the 404 page.

| Check | Result |
|---|---|
| Opens on hover, stays inside the window, sits above page content | Passed on all 16 pages |
| Same panel background and size on every page | Passed |
| Each of the 15 services shows its own image, title, description and link | Passed on 4 page types |
| Keyboard: focus opens, Tab updates the preview, Escape closes and returns focus | Passed |
| Touch: first tap opens without leaving the page | Passed |
| Active state on service pages; dark mode | Passed |
| Failed image: keeps the last good picture, title still updates, no script error | Passed |
| Mobile menu lists 15 services at 320, 375, 425, 768 and 1024 | Passed |
| No more than 1 preview image loads with the page; others load on hover | Passed |

Desktop hover was tested at 1366, 1440 and 1920. Widths between 1025 and 1365 were not hover-tested, and the phone and tablet menu was tested at 1024 and below.

## 4. Images

All artwork is original. It is drawn from code by `database/tools/build_illustrations.js` and rendered to WebP through Chrome. **Correction:** this report originally said no image-generation tool was available. That was wrong: a Figma tool was available but had not been checked. See `docs/PREMIUM_UPGRADE_REPORT.md`.

- **Style:** polished vector illustrations with soft depth, not photorealistic 3D.
- **Clean:** no stock images, watermarks, brand logos or sentences of text. The only symbols are `</>`, `{ }`, `VS` and `₹`.

| Group | Scenes | Files | Size |
|---|---|---|---|
| Services: mega menu | 15 | 15 | 812 × 380 |
| Services: service pages | same 15 scenes, reframed | 30 | 912 × 1122, 456 × 561 |
| Published articles | 11 | 33 | 1200 × 900, 800, 420 wide |
| Case studies | 3 | 9 | 1200 × 900, 800, 420 wide |
| **Total** | **29 scenes** | **87 WebP, 1.8 MB** | Largest file 38 KB |

Generated images use WebP quality 84.

### Mapping

Service files are `assets/images/generated/menu/<service>.webp` and `services/<service>.webp`.

| Service | Scene |
|---|---|
| Website Development | Responsive browser and phone, code panel |
| Custom Software | Dashboard connected to system modules |
| Web Application | Browser dashboard, secure sign-in |
| E-commerce | Product grid, cart, payment card |
| WordPress | Content editor with page blocks; no WordPress logo |
| UI/UX Design | Wireframe to finished screen, colour palette |
| CRM | Customer list, sales funnel, analytics |
| Mobile Apps | Two phones with app interfaces |
| Cloud | Cloud linked to three server racks |
| AWS | Layered cloud infrastructure; no AWS logo |
| API | Dashboard, table and phone linked through an API hub |
| Maintenance | Monitoring screen, shield, gear |
| SEO | Search bar, rising charts, magnifier |
| Digital Transformation | Table becoming an automated workflow |
| IT Consulting | Two people, plan on a screen, roadmap |

| Published article | Image (`generated/blog/`) |
|---|---|
| How to plan a business website that generates enquiries | `plan-business-website` |
| Custom software or off-the-shelf | `custom-or-off-the-shelf` |
| What to check before moving to the cloud | `cloud-migration-checklist` |
| UI/UX basics | `ux-basics` |
| WordPress or a custom-built website | `wordpress-or-custom` |
| A practical first step towards digital transformation | `digital-first-step` |
| Why Small Businesses in Tirunelveli Need a Website | `why-small-business-website` |
| How to Choose a Web Development Company | `choose-company` |
| Website Development Cost in Tamil Nadu | `website-cost` |
| E-commerce for Growing Businesses | `ecommerce-planning` |
| Website Maintenance and Security | `maintenance-security` |

| Case study | Image (`generated/case-studies/`) |
|---|---|
| Taking a Local Retailer Online | `local-retailer-online` |
| Replacing Spreadsheets with Custom Software | `spreadsheets-to-software` |
| Moving a Business Application to AWS | `application-to-aws` |

**Case studies stay labelled as concepts.** The alt text says so, and the detail page adds "Concept illustration, not a client photograph or project screenshot." No clients, metrics or results were added.

**Layout notes:**
- Service images display at the same 456 × 561 px as before and scale down on phones.
- Article image `width` and `height` now match the real ratio, which avoids layout shift.
- A dark-mode template rule was washing out images in the service and case study layout; it is now limited to the logo.
- The Services listing cards keep their older images, so that page looks unchanged.

### Icons

26 custom SVG files in `assets/images/industry/`, one per category. The tests confirm that the artwork is different for each, and that each has a gradient and a title. They use a blue, cyan and violet gradient, and the lift on hover turns off for people who prefer reduced motion. The adjacent label is the accessible name, so the image `alt` is empty to avoid reading it twice.

## 5. WebP pipeline

Implemented in `application/libraries/Media_manager.php`. Every admin upload route uses it: blog, services, case studies, media library, settings and profile.

1. Checks the real file content, the extension and the image dimensions (up to 8000 px).
2. Refuses animated images, and images too large for available memory.
3. Re-encodes as WebP at quality 82, up to 2000 px wide, keeping the aspect ratio and transparency.
4. Makes copies at 1200, 800 and 420 px wide when the image is larger than that.
5. Confirms the output is really WebP, then saves a random filename and the WebP path.
6. If anything fails, removes partial files and shows an error. The original is **no longer** stored as a fallback.

Deleting a file from the media library also removes its copies.

**Engine:** this server has GD with WebP support, and that is the path tested. Imagick is preferred when present, but it isn't installed here, so **the Imagick code has not been run**. If neither is available, the upload is refused with a message naming the requirement.

### Upload test results (isolated copy): 77 passed, 0 failed

| Upload | Result |
|---|---|
| PNG 2400 wide with transparency | WebP at 2000 wide, 3 copies, transparency kept |
| JPG, static GIF, WebP, tiny PNG | Real WebP, correct size, right copies, served as `image/webp` |
| Image with PHP code appended | Code removed by re-encoding |
| Corrupt PNG, animated GIF, 9000 px image, fake PNG, SVG | Refused with a clear message, no files or records left, panel still works |
| Corrupt file on an article edit form | Save stopped with a message; existing image kept and still shown |
| New article image | Saved as WebP and shown on the article with responsive sizes |

The animated-GIF test caught a real bug in my first version, which was fixed. Uploads were not tested on the real site, to avoid leaving test files there.

### Existing images

Nothing was deleted, and nothing on the homepage was converted. Earlier files are still on disk, including replaced service and article images.

**Conversion candidates (not done):** the Services listing cards, 6 product images, the portfolio images and the 11 draft articles. Give each draft its own image before publishing it.

## 6. SEO research

**Limit of this research:** three web searches, mostly returning directories and listing pages. I did not read competitors' own websites in depth, so treat this as a starting point. Nothing was copied.

**Firms that appeared in results for Tirunelveli (from directories, unverified):** Guru Software Solution, Olympods, LogixWeb, UNIQ Technologies, SKR Websites, Surfersway, Maz Software Solutions, Jaz Infotech, Bravery Infotech, Consign IT, 4S Technologies, Neemtec, Zervia Tech Solutions.

**What this suggests:**
- **Positioning:** listings mostly name a broad service list (web design, hosting, SEO, apps), with little explanation.
- **Thisaiyanvilai:** no firm in the town itself appeared. That is a possible opening, not proof that none exists.
- **Content gap:** results for cost questions were India-wide guides, with no local rates for Nagercoil or Thoothukudi. Your cost and provider-selection articles address this kind of question.
- **Next step with most value:** a verified Google Business Profile and consistent local listings.

### Keyword map

Existing titles already target these terms naturally, so **no SEO titles were changed**.

| Page | Primary term |
|---|---|
| Home | software development company in Thisaiyanvilai |
| About | IT company in Thisaiyanvilai |
| Services | web development services in Tirunelveli |
| Website Development | website design company in Tirunelveli |
| Custom Software | software development company in Tirunelveli |
| E-commerce | e-commerce website development Tamil Nadu |
| WordPress | WordPress website development |
| CRM | CRM software for small business |
| Cloud | cloud computing solutions |
| IT Consulting | IT consulting services |
| Areas We Serve | IT services in Tirunelveli and nearby districts |

Search volumes were not measured, as no keyword tool was available. No new city pages were created, and the existing Areas page covers the secondary locations.

## 7. Duplicate and copyright audit

| Check | Result |
|---|---|
| Duplicate titles, descriptions, H1s | None across 58 indexable pages |
| Internal duplicate check, 51 documents | Highest 6.3% (3 phrases, Contact and Home); between articles and services 2% or less |
| Repeated opening sentences | 0 |
| Listed demo text and placeholders in the audited pages | None found |
| Star ratings or review claims | None; a star motif in one new image was removed before publishing |

**External plagiarism check: pending. Not run and not passed.** No 95% figure can be claimed. Whether any text matches competitor sites can only be answered by an external checker.

### Licensing

- **New artwork:** original to this project.
- **Still needs your confirmation:** template and stock images remaining on the Services listing, Products, Portfolio and homepage. One Services listing image shows a person beside an X logo (`service6-5.png`).
- **Watermark:** `blog1-8.png` shows a FREEPIK watermark. No live page uses it, but the file remains in the project and in the older migration data.
- **Technology logos:** homepage logos for AWS, PHP and others are trademarks of their owners. Check that their use fits each brand's guidelines.

## 8. Technical SEO

Read-only crawl of the real site: 84 pages crawled, 58 indexable, 57 URLs in the sitemap, no broken links, drafts excluded, 134 checks passed.

Every audited page passed for one H1, canonical URL, Open Graph, image `alt` attributes and valid structured data. All 15 service pages have Service schema and breadcrumbs.

**To check at launch:** service and article sharing images are now WebP, which some social platforms may not display. Test with their sharing debuggers. Rich Results Test and Search Console also need a public URL.

## 9. Responsive and dark mode

| Width | Homepage comparison | Service, case study and article images | Phone/tablet menu | Desktop hover |
|---|---|---|---|---|
| 320, 375, 425, 768 | Passed | Passed | Passed | n/a |
| 1024 | Passed | Passed | Passed | n/a |
| 1440 | Passed | Passed | n/a | Passed |
| 1920 | Passed | Passed | n/a | Passed |

No page in these checks has sideways scrolling or failed images. Dark mode was tested for the homepage comparison, the panel and service images.

## 10. Test results (final code)

Tests that write data ran only on an isolated copy. The real site received read-only requests and migration 005.

| Suite | Where | Result |
|---|---|---|
| Fresh install through migration 005 | Isolated | Passed; second run changes nothing |
| Public | Isolated | 107 passed, 0 failed |
| Admin | Isolated | 291 passed, 0 failed |
| SEO and delete | Isolated | 176 passed, 0 failed |
| Browser | Isolated | 54 passed, 0 failed |
| Uploads (new) | Isolated | 77 passed, 0 failed |
| Mega menu (new) | Isolated and real | 224 passed, 0 failed on each |
| Content and images | Isolated and real | 713 passed, 0 failed on each |
| Read-only crawl | Real | 134 passed, 0 failed |
| Admin panel click test | Real | 10 passed, 0 failed |
| Heading styles | Isolated | 1,356 compared, 0 differences |

**Real data after migration:** admin password hash, SMTP settings and `.env` are unchanged (checksums compared), with 0 enquiries, 0 applications and 3 uploads, as before. Modified dates did not change. No PHP errors were logged on the real site after 11:29, before this work began. The test environment has been removed.

**Backups:** `backups/before-visual-upgrade-2026-11-06/` holds the database and code, and both were verified before any change.

## 11. Performance

Lighthouse, mobile, local server. Three repeat runs on Home and the article:

| Page | Performance | LCP | Before this work |
|---|---|---|---|
| Home | 34, 47, 48 | 12.6 s | 53, LCP 12.6 s |
| Article | 49, 52, 59 | 12.0 s | 60, LCP 13.4 s |

One run each: Service 59 (LCP 11.7 s, previously 60), Case study 53 (LCP 12.0 s).

Home page weight is identical (8.22 MB), and the score swings with blocking time between runs (120–1,210 ms). That looks like measurement noise, but I can't rule out a small slowdown from these figures. CLS stayed low, at 0.043 or below on all four pages. LCP is far above Google's 2.5 s target; compression is off locally, so re-measure on production.

## 12. Remaining issues

| Priority | Issue | Action |
|---|---|---|
| High | Plagiarism check not run | Run an external checker on all public content |
| High | Slow mobile loading (LCP about 12 s) | Enable compression and re-measure on production |
| High | Template and stock image licences unconfirmed | Confirm, or replace them |
| High | Mobile, SEO and CRM services unconfirmed (earlier audit) | Confirm or unpublish |
| Medium | Drafts still use older images | Give each one its own image before publishing |
| Medium | Sample portfolio and case study content; six short older posts (114–135 words) | Replace with real work; expand |
| Medium | Imagick path untested | Test one upload if production uses Imagick |
| Medium | WebP sharing images | Check after launch |
| Medium | Gmail App Password was shared in chat | Rotate it |
| Low | Animated GIFs and animated WebP are now refused | Upload a still image instead |

## 13. Files modified

- **New:** `application/migrations/005_visual_upgrade.php`, `migrations/data/visual_upgrade.php`, `database/tools/build_illustrations.js`, `assets/images/generated/` (87 files), `assets/images/industry/` (26 files)
- **Upload and helpers:** `application/libraries/Media_manager.php`, the helper holding `media_url()` (adds `media_srcset()`), `application/config/migration.php`
- **Controllers:** `Services.php`, `admin/Services.php`, `admin/CaseStudies.php`, `admin/Media.php`
- **Views:** `layouts/main.php`, `partials/nav.php`, `partials/overlays.php`, `home/index.php`, `home/_latest_posts.php`, `services/detail.php`, `blog/_cards.php`, `blog/detail.php`, `case-studies/detail.php`, `case-studies/_lead.php`
- **Assets:** `girzock.css`, `girzock-dynamic.css`, `girzock.js`, and rebuilt `.min` files

Database: added `services.detail_image`, `services.detail_image_alt` and `case_studies.image_alt`; updated image references. Uploaded images and drafts were left alone.

## 14. Sources

- [IT companies in Tirunelveli (TrafficTail)](https://traffictail.com/it-companies-in-tirunelveli/)
- [Top IT companies in Tirunelveli (Housing.com)](https://housing.com/news/it-companies-in-tirunelveli/)
- [Web development companies in Tirunelveli (TechBehemoths)](https://techbehemoths.com/companies/web-development/tirunelveli)
- [Custom software companies in Tirunelveli (TechBehemoths)](https://techbehemoths.com/companies/custom-software-development/tirunelveli)
- [Guru Software Solution (IndiaMART)](https://m.indiamart.com/guru-software-solution/aboutus.html)
- [Olympods Software Solutions (IndiaMART)](https://m.indiamart.com/os-solutions/web-development-services.html)
- [LogixWeb Solutions (IndiaMART)](https://m.indiamart.com/logixweb-solutions/products-and-services.html)
- [Maz Software Solutions (The Manifest)](https://themanifest.com/company/maz-software-solutions)
- [Zervia Tech Solutions (The Manifest)](https://themanifest.com/company/zervia-tech-solutions)
- [Website cost in India (Hostinger)](https://www.hostinger.com/in/tutorials/?p=15570)
- [E-commerce website cost (Hostinger)](https://www.hostinger.com/in/tutorials/ecommerce-website-cost/)

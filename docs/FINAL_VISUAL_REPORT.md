# GIRZOCK Technologies: Final Visual Consistency Report

Date: 6 November 2026. Site tested: `http://localhost/girzock-website/` (local XAMPP). The site is not public yet.

## Summary

- Published articles, case studies, portfolio items and Where We Work now use realistic, topic-specific images.
- Where We Work is redesigned, and the service page FAQs are fixed.
- Automated suites pass, with one explained exception (section 8).

**Screenshots:** none arrived with this brief, so the work is based on the live pages.

**Still open:** see section 10, including the plagiarism check and slow mobile loading.

## 1. Files changed

- **New:** `application/migrations/007_realistic_content_images.php`, `migrations/data/realistic_images.php`, 74 WebP files under `assets/images/generated/photo/`, this report
- **Views:** `home/index.php` (Where We Work only), `services/detail.php` (FAQ class), `portfolio/_gallery.php`, `portfolio/detail.php`, `case-studies/detail.php`
- **Styles:** `assets/css/girzock.css`, `girzock-dynamic.css`, rebuilt `.min` files
- **Config:** `application/config/migration.php`
- **Database:** image paths and alt text only. Article text and dates were confirmed unchanged by checksum

## 2. Images generated and replaced

**30 new images** were generated with Figma (`gpt-image-2.5-flare`), using your Figma AI credits. Figma did not report the credits used. With the earlier 16, there are 46 realistic images on the site.

The 16 service images were already realistic, so they were kept and no credits were spent replacing them. All 16 are confirmed in the mega menu and on service pages.

### Published articles (`generated/photo/blog/`)

| Article | Image |
|---|---|
| How to plan a business website | Owner and planner reviewing layouts and an enquiry form |
| Custom software or off-the-shelf | Manager with a boxed product beside a tailored dashboard |
| Moving to the cloud | IT manager with a checklist and a cloud upload on a tablet, beside server racks |
| UI/UX basics | Owner testing a phone app while a designer takes notes |
| WordPress or custom-built | Developer comparing a visual editor with hand-written code |
| First step in digital transformation | Colleagues moving a paper register onto a laptop |
| Why small businesses need a website | Shop owner holding up a phone showing a business website |
| Choosing a web development company | Owner taking notes as a developer explains designs |
| Website development cost | Planning desk with plan options, calculator and rupee notes |
| E-commerce for growing businesses | Team packing a parcel and checking orders |
| Maintenance and security | Engineer checking backups and security updates |

The same image is used for social sharing, through the existing featured-image setting.

### Case studies (`generated/photo/case-studies/`), all labelled as concepts

| Case study | Image |
|---|---|
| Taking a Local Retailer Online | Online store on a laptop and tablet |
| Replacing Spreadsheets with Custom Software | Paper spreadsheet beside a dashboard |
| Moving a Business Application to AWS | Server migrating to the cloud on a monitor; no AWS logo |

### Portfolio (`generated/photo/portfolio/`), all labelled as concepts

| Item | Image |
|---|---|
| Business website | Small business site on a desktop monitor |
| Web application | Task board app on a laptop |
| Online store | Checkout on a phone, with a payment card |
| Customer portal | Customer using an account portal on a tablet |
| Product catalogue | Hardware catalogue on a tablet, with tools |
| WordPress website | Person adding an image in a content editor |
| Landing page | Landing page on a phone, laptop behind |
| Storefront redesign | Designer comparing old and new layouts |
| Admin dashboard | Tables and charts on an ultrawide monitor |
| Online Store for a Local Retailer | Shopkeeper checking orders on a counter tablet |
| Custom Business Management System | Administrator with customers, jobs and invoices |
| Cloud Application Migration | Engineers watching a migration plan on a wall display |
| Corporate Website Development | Corporate site on a meeting room display |

Portfolio detail pages and case study pages state "Concept image, not a client photograph or project screenshot." No clients, logos, metrics or results were added. The four named portfolio items keep their "Concept" labels.

### Where We Work (`generated/photo/where-we-work/`)

| Card | Image |
|---|---|
| Thisaiyanvilai & Tirunelveli | Developer talking with a local business owner in person |
| Thoothukudi, Nagercoil & Kanyakumari | Coordinator on a video call beside a project timeline |
| Thiruvananthapuram & Beyond | Developer delivering a finished site from a laptop |

**Please note:**
- The people are AI-generated, not GIRZOCK staff or clients.
- Images were reviewed at contact-sheet size and on sample pages for stray text or logos, not each one at full size. Screens may show tiny unreadable marks.
- Check that Figma's and the model's terms fit your commercial use.

## 3. Where We Work design

- A light sky-blue gradient panel with cyan and violet overlays, and a soft dot pattern. No map or location pins, to avoid inaccurate location claims.
- Three rounded cards with thin gradient borders, soft shadows, a gentle hover lift and a photo at the top.
- Each card has a tag, heading, the original text and links, and three short points.
- It says "We have no offices here" for the regional card and "No office here, only online support" for Thiruvananthapuram. Only Thisaiyanvilai and Tirunelveli are shown as your home area.
- A dark version is included. Reviewed at 1440 in light and dark, and at 375.

The section is 506–1448 px taller than before, depending on width, because the cards now have images and bullet points. No other homepage section changed height.

## 4. FAQ fixes (all 16 service pages)

| Issue | Before | After |
|---|---|---|
| Space above the label, desktop | 0 px, against the panel edge | 72 px |
| Decorative image above the heading on phones and tablets | 326–783 px | Removed below 992 px |
| Heading size and wrap, desktop | 55 px, 3–4 lines | 44 px max, 2 lines |
| Label to heading | 11–21 px, varied | 18 px at every width |
| Heading to questions | 45 px | 32 px |
| Space to the next section | Tight | 72 px desktop, 48 px on phones and tablets |

The label is "FAQ" and the heading is "Questions About [service]". The decorative graphic no longer overlaps at any tested width. Accordion behaviour is unchanged. The change uses its own class, so the homepage FAQ isn't affected.

**Other detail pages:** case study, portfolio and product detail pages have no FAQ section to fix. Article FAQs are ordinary headings within the text, so they were left alone. The Careers accordion was not changed.

**Dark mode:** the FAQ was checked by colour readings and is readable at desktop and phone widths.

## 5. Blog, case study and portfolio status

| Area | Status |
|---|---|
| Blog listing and cards | All 11 different and realistic; card layout unchanged |
| Published article pages | 11 of 11 updated, alt text added, text and dates unchanged |
| Case studies | 3 of 3 updated and labelled |
| Portfolio | 13 of 13 updated, labelled; gallery layout and hover kept |
| Drafts | **Not changed:** all 20 keep their older images, as the brief covered published pages |

## 6. WebP results

- 74 new WebP files, 3.3 MB in total, largest 112 KB, at quality 84 using GD. Each file's format and width were checked after saving.
- Responsive copies: articles and case studies at 1200, 800 and 420 wide; portfolio at 1212 and 606; Where We Work at 960 and 480.
- The upload pipeline is unchanged and passes 77 of 77 tests.
- No files were deleted. Older images remain on disk.
- PNG originals: `backups/generated-content-photos-originals-2026-11-06/`.

## 7. Homepage comparison

Compared with a baseline taken just before this work: 16 captures, 8 widths in light and dark.

| Check | Result |
|---|---|
| Section heights | Only Where We Work changed; sections below it move down accordingly |
| Images | Only Insights and Where We Work changed |
| Text | Only Where We Work, plus the hero counter caught mid-animation (`7+` against `8+`) |
| Fonts and colours sampled | No changes |
| Sideways scrolling, script errors, failed requests | None |

This compared measurements and image paths, not pixel-by-pixel images. The hero, sliders, header and footer were not edited.

## 8. Test results

Tests that write data ran only on an isolated copy. The real site received read-only requests and migration 007.

| Suite | Where | Result |
|---|---|---|
| Fresh install through migration 007 | Isolated | Passed; second run changes nothing |
| Public | Isolated | 107 passed, 0 failed |
| Admin | Isolated | 291 passed, 0 failed |
| SEO and delete | Isolated | 181 passed, 0 failed |
| Browser | Isolated | 54 passed, 0 failed |
| Uploads | Isolated | 77 passed, 0 failed |
| Content and images | Isolated and real | 804 passed, 0 failed on each |
| Mega menu | Isolated | 234 passed, 0 failed |
| Mega menu | Real | **233 passed, 1 failed** |
| Read-only crawl | Real | 139 passed, 0 failed |
| Admin panel click test | Real | 10 passed, 0 failed |
| Heading styles | Isolated | 1,362 compared, 0 differences |

**The one failure:** the touch test tapped Services while the page's loading screen was still showing, on a first load, so the tap didn't reach the menu. I repeated the check on 4 pages: the same tap failed once, immediately on a first load, and worked all 12 times after the loading screen cleared. This comes from the existing loading screen, not this work. Visitors can't tap anything until it clears.

**Responsive check:** 12 pages (blog, blog page 2, an article, case studies, a case study, portfolio, a portfolio item, products, about, contact, careers, areas) at 320, 375, 425, 768, 1024, 1280, 1440 and 1920. No broken images, stretched images, sideways scrolling, failed requests or script errors, and one H1 each.

**Real data:** admin password hash, SMTP settings and `.env` are unchanged (checksums compared), with 0 enquiries, 0 applications and 3 uploads, as before. No PHP errors were logged on the real site during this work. Nothing was committed to Git.

**Backups:** `backups/before-final-visual-2026-11-06/` holds the code archive (102 MB, listed in full without errors) and two database dumps (28 tables each). They have not been test-restored.

**Not tested:** sharing images on real social platforms, Rich Results Test and Search Console (these need a public URL), and hover on every portfolio item individually.

## 9. Performance

Lighthouse, mobile, local server, two runs each:

| Page | Performance | LCP | CLS | Weight |
|---|---|---|---|---|
| Home | 30, 46 | 12.5 s, 12.4 s | 0.046 | 8.2 MB |
| Blog | 59, 61 | 14.5 s, 14.4 s | 0.03 | 2.75 MB |
| Article | 60, 60 | 13.6 s, 13.4 s | 0 | 2.5 MB |
| Portfolio | 60, 60 | 14.7 s, 15.0 s | 0 | 3.24 MB |
| Case study | 60, 60 | 13.2 s, 13.1 s | 0 | 2.48 MB |

**Slow loading is still a real problem.** LCP is far above Google's 2.5 s target and has not improved. Home scored 53 three rounds ago and swings widely between runs, so I can't rule out a slowdown. Compression is off locally, so re-measure on production.

## 10. Remaining issues

| Priority | Issue | Action |
|---|---|---|
| High | External plagiarism check not run; no score exists | Run an external checker |
| High | Slow mobile loading (LCP 12–15 s) | Enable compression, re-measure on production |
| High | Work With Us shows fictional company logos, licence unconfirmed | Replace with real logos, or confirm the licence |
| High | Digital Marketing, Mobile, SEO and CRM experience unconfirmed | Confirm, or unpublish |
| Medium | AI-generated people could be mistaken for staff or clients | Don't present them as your team or customers |
| Medium | Older template images remain, and were not part of this work: Services listing cards (one shows a person beside an X logo), products, about page. `blog1-8.png` has a watermark and stays in the project | Confirm licences, or ask me to replace them |
| Medium | 20 drafts still use older images | Give each one an image before publishing |
| Medium | Sample portfolio and case study content; six thin older posts | Replace with real work; expand |
| Medium | Gmail App Password was shared in chat | Rotate it |
| Low | Sharing images are WebP, which some platforms may not show | Check after launch |

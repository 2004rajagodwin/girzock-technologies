# GIRZOCK Technologies: Final Production Content, SEO, Services and Blog Audit

Date: 6 November 2026. Site tested: `http://localhost/girzock-website/` (local XAMPP). The site is not yet public, so nothing that needs a public URL has been run.

> **Superseded.** This is an earlier snapshot. The current results are in `COMPLETE_SEO_SCORE_REPORT.md`, `COMPLETE_PAGE_INVENTORY.md` and `CONTENT_QUALITY_AUDIT.md` (7 November 2026). Since this report, LinkedIn and Facebook icons are hidden until real addresses are added, and the six short blog posts were rewritten with H2 sections.

## 1. Summary

The content, counter, articles and technical SEO changes are live on the local site, and every automated test passes.

**The site is not cleared on plagiarism.** No external checker was available, so no originality score exists. See section 8.

Three decisions are waiting on the business owner:

1. Confirm or remove Mobile App, SEO and CRM services (section 3).
2. Confirm the image and template licences (section 10).
3. Run the external plagiarism check (section 8).

## 2. Homepage counter

| Check | Result |
|---|---|
| Wording | "10+ Core Services for Your Business" in both hero slides |
| Final value | Settles at `10+` at 1920, 1440, 1366, 1024, 768, 480, 375 and 320 px |
| Card size | Unchanged design; no text or page overflow at any of those widths |
| Screenshots reviewed | 1440 and 375 px |
| Other outdated references | About page counters updated; "services under one roof", "service disciplines" and the Case Studies count now show the live number of active services (15) |
| Supported by the listing | Yes: 15 active services |

The counter counts up over about 6 seconds, so it briefly shows `9+` on the way to `10+`. This is the original animation.

## 3. Services (15 verified)

All 15 pages load and have a unique title and description, one H1, a canonical URL, Open Graph tags, breadcrumbs, Service schema and internal links.

Website Development, Custom Software, Web Applications, E-commerce, WordPress, UI/UX Design, CRM and Business Software, Mobile Apps, Cloud Solutions, AWS Cloud, API Integration, Website Maintenance, SEO Services, Digital Transformation, IT Consulting.

**Changes made:** a specific local paragraph was added to the 12 pages that lacked one. Generic repeated headings became service-specific ("Problems We Solve with...", "How We Deliver..."). The unsupported line "We often work with AWS" was rewritten, and a missing full stop was fixed.

### Services needing business approval

The original site does not establish these, so the pages describe what the service involves and make no experience claims. Confirm each one, or unpublish it in the admin panel.

| Service | What is unconfirmed |
|---|---|
| Mobile App Development | No evidence on the original site |
| SEO Services | No evidence on the original site |
| CRM and Business Management Software | Only partly supported, by the Business Management Software product |

Removing all three would still leave 12 services, so "10+" stays true either way.

## 4. Blog

**Published: 5. Remaining drafts: 11.** The older six posts remain published, so 11 posts are live in total.

| Article | Words | Search intent | Why this one |
|---|---|---|---|
| Why Small Businesses in Tirunelveli Need a Professional Website | 980 | Awareness, local | The primary location, and readers who have not yet decided |
| How to Choose the Right Web Development Company in Tirunelveli | 923 | Comparing providers | Readers close to hiring |
| Website Development Cost in Tamil Nadu: A Business Guide | 916 | Cost | A very common question, answered without invented prices |
| E-commerce Website Development for Growing Businesses in Tamil Nadu | 914 | Planning a store | A confirmed service with a distinct audience |
| Website Maintenance and Security: A Complete Business Guide | 878 | Existing website owners | A different reader: someone who already has a site |

**Why the others stayed as drafts:** the CRM and mobile app articles depend on services awaiting approval. The Thoothukudi, Nagercoil, Kanyakumari and Thiruvananthapuram articles target the same kinds of search from other towns, so publishing them alongside the Tirunelveli ones adds little yet. The online presence article overlaps with the first article above.

**Changes before publishing:**
- About 250–350 new words per article, including a worked example or checklist and one extra FAQ.
- Descriptive alt text and a distinct image for each.
- Real publication dates, with a modified date from the database.
- BlogPosting schema, canonical URL, internal service links and a call to action.

**Factual checks on the articles:**
- The Consumer Protection (E-Commerce) Rules 2020 were checked, and readers are told to confirm their own obligations with an adviser.
- The 3-2-1 backup guideline was checked and is not attributed to any organisation.
- A spot check found one near-match online ("A backup you have never restored is only a hope"), which was reworded.
- The articles contain no prices, statistics, clients or results.

**Not independently verified:** the sentence "AWS has regions in India" is from my own knowledge; a search did not confirm the region names, so none are named.

## 5. Public page audit

Pages audited: Home, About, Services, 15 service pages, Products, Portfolio, Case Studies, Blog, the 11 published posts, Contact, Careers and Areas We Serve. A spell-check (en-GB) flagged only valid words: Contentful, yourbusiness, tagline, Storefront and taluk.

| Page | Removed or rewritten |
|---|---|
| Home | "Global Outlook" and the 26 language and flag links became "Who We Help" with 26 kinds of organisation, in the same layout |
| Home | "Notable Accomplishments and Key Milestones" became "What GIRZOCK Technologies Offers at a Glance" |
| Home | "Measurable results" promise removed |
| Home | Six fictional partner logos replaced with technology logos; "Partner With" became "Work With" |
| Home | FAQ now lists all services; brand casing fixed. Your H1 was kept as you wrote it |
| About | Counters corrected; brand casing fixed |
| Areas We Serve | Wording that implied existing clients became "may" and "can" |
| Careers | Inaccurate reference to "the form below" corrected |
| Contact and footer | Phone number added; address now says "Tirunelveli District" |
| Blog | Watermarked image replaced on the live post and on two articles; `blog/page/2` given its own title, description and heading |

Licensed template code was left alone: 37 "Aiero" attribution comments remain in `style.css` and `main.js`. They are not in any page's HTML.

## 6. Technical SEO

| Item | Result |
|---|---|
| Pages crawled | 84: 58 indexable, 26 noindex |
| Sitemap | 57 URLs; includes the 5 new articles, excludes all 11 drafts |
| Robots and exclusions | Drafts return 404; preview works for admins only |
| Titles, descriptions, H1s | Unique across indexable pages and within length limits |
| Headings | Card headings moved from H4 to H3 so levels no longer skip. Two exceptions below |
| Structured data | Organization, Service, BlogPosting and BreadcrumbList parse correctly with my own parser. No ratings or reviews |
| FAQ schema | Deliberately not added, because Google retired FAQ rich results |
| Images | All audited pages have an alt attribute, and every image checked returns 200 |
| Blog alt text | New `featured_image_alt` field, editable in the admin panel |

**Heading exceptions:** the "Stages" counter on the Services page stays an H4 because its styling depends on it. Homepage footer titles stay as `div` elements, as on the original site.

**Not validated externally:** Google's Rich Results Test and Search Console need a public URL. Run them after launch.

### Lighthouse (mobile, local server)

| Page | Performance | Accessibility | Best practices | SEO | LCP | CLS |
|---|---|---|---|---|---|---|
| Home | 53 | 94 | 93 | 92 | 12.6 s | 0.047 |
| Article | 60 | 96 | 100 | 92 | 13.4 s | 0 |
| Service | 60 | 96 | 100 | 92 | 11.7 s | 0 |

LCP is far above Google's 2.5 s target. Compression is off locally, so these figures should be measured again on the production host. Desktop Lighthouse was not run this round.

## 7. Testing

Tests that write data ran only on an isolated copy (separate database, private folder, fake keys and a local mail sink). The real site received read-only requests, and migration 004.

| Suite | Where | Result |
|---|---|---|
| Fresh install through migration 004 | Isolated | Passed; second run makes no changes |
| Public suite | Isolated | 107 passed, 0 failed |
| Admin suite (drafts, SEO fields, slug redirects, categories, search and more) | Isolated | 291 passed, 0 failed |
| SEO and delete suite | Isolated | 176 passed, 0 failed |
| Browser suite | Isolated | 54 passed, 0 failed |
| Final content checks | Isolated and real | 586 passed, 0 failed on each |
| Read-only crawl | Real | 134 passed, 0 failed |
| Admin panel click test | Real | 10 passed, 0 failed |
| Heading styles, H4 against H3 | Isolated | 1,356 compared in light and dark at 3 widths; 0 differences |
| Internal duplicate check | Real data | See section 8 |

**Test expectations changed in this round.** These were outdated by the intended changes, and each was reviewed: draft count 16 to 11, a remaining draft used for the draft checks, new service headings, 15 services in the mega menu, the budget check narrowed to the form field, and the monthly post count now read from the database. The `/about` title restored by the admin test was also corrected.

**Real data after migration:** admin password hash and SMTP settings are unchanged (checksums compared before and after), `.env` is unchanged, and there are 0 enquiries, 0 applications and 3 uploads, as before. The test environment has been removed.

**Not tested in this round:** a real email through Gmail, and a live enquiry on the real site, so no test data or mail would be created there. The real admin panel was exercised only by the click test.

### Layout against the original site (1440, 768, 375 px)

No page has new horizontal overflow or failed requests.

| Difference | 1440 | 768 | 375 | Cause |
|---|---|---|---|---|
| Footer | +31 | +34 | +122 | Phone line and three-line address |
| Who We Help section | within 2 | +40 | -60 | New labels |
| Home FAQ | +30 | | +60 | Answer now lists all services |
| About "Who We Are" | +30 | +30 | +60 | Most likely the brand casing in the large display text, the only text change in that section |
| Contact form section | | +88 | +88 | Phone sentence and existing text |

These earlier additions also still show in the comparison: the extra homepage section, the 15-service grid on the Services page, the blog category bar and longer mobile page banners. Blog pages are shorter than the original because 6 posts now show per page.

## 8. Originality

**External plagiarism check: pending. Not run, and not passed.** No 95% score can be claimed.

**Internal duplicate check (internal only; it cannot see the web):** 51 documents and 1,275 pairs were compared on shared 6-word phrases, after excluding 43 phrases found on 5 or more documents as shared page wording.

- Highest overlap: 6.3% (3 phrases), Contact and Home.
- Between any two articles or service pages: 2.0% or less.
- Repeated opening sentences: 0.
- Without the exclusion, the highest figure is 36%, between Contact and other pages, caused by shared page wording.

### Content needing external verification

Check these with Copyscape, Grammarly or a similar service, ideally after launch.

1. The 5 new articles in section 4.
2. The 6 older posts.
3. The 15 service pages.
4. Home, About, Services, Products, Portfolio, Case Studies, Contact, Careers and Areas We Serve.
5. The 11 drafts, each before it is published.

## 9. Files modified

- **Migration:** `application/migrations/004_final_content_review.php`, `application/migrations/data/final_updates.php`, `application/config/migration.php`
- **Controllers:** `Blog.php`, `CaseStudies.php`, `Home.php`, `admin/Blog.php`
- **Main view edits:** `home/index.php`, `home/about.php`, `home/areas.php`, `careers/index.php`, `contact/index.php`, `partials/footer_widgets.php`, `services/detail.php`, `services/index.php`, `blog/_cards.php`, `blog/detail.php`, `home/_latest_posts.php`
- **Heading change only:** other views under `application/views/frontend/`, in `blog`, `careers`, `case-studies`, `partials`, `portfolio`, `products` and `services`
- **New images:** 7 `assets/images/blog/article-*.png` files, cropped from existing site images, with WebP copies
- **Database:** 5 posts published, service text corrected, alt text added, address updated. Corrections apply only where the original wording was still present

## 10. Remaining production issues

| Priority | Issue | Action |
|---|---|---|
| High | Plagiarism check not done | Run the external check in section 8 |
| High | Mobile, SEO and CRM unconfirmed | Confirm or unpublish |
| High | Image licences unconfirmed | Confirm the template and stock licences. `blog1-8.png` shows a FREEPIK watermark; no post uses it now, but it stays in the project and is named in the migration 003 data |
| High | Slow mobile loading (LCP 11.7–13.4 s) | Enable compression and re-measure on production |
| Medium | Six older posts are thin (114–135 words) | Expand them; they were kept as they are |
| Medium | Sample portfolio and case study content | Replace with real work when available |
| Medium | "14 Technologies" counter and logos; "we travel for meetings" and "details kept for future roles" | Confirm these are accurate |
| Medium | Gmail App Password was shared in chat | Rotate it |
| Medium | Rich Results Test and Search Console not run | Run after launch |
| Low | Lighthouse SEO 92: social icons without links | Add real LinkedIn and Facebook URLs, or remove the icons |

## 11. Incidents in this round

- **Code backup failed.** The `tar` command misread the `E:` path and failed, and the first view edits ran anyway. No code backup exists from immediately before those edits. Available copies: `backups/before-seo-upgrade-2026-11-06/` and `backups/before-final-content-2026-11-06/project-code-after-view-edits.tar.gz`. The database backups are complete, including `girzock_technologies-immediately-before-migration.sql`.
- **Modified dates.** The alt-text update changed the modified date on the six older posts. The dates were restored from the backup and the migration was corrected.
- **Footer.** The new phone link made the footer 362 px taller at 768 px. Found by the comparison and fixed; the difference is now 34 px.
- **Live publishing order.** Migration 004 ran on the real database before the last small edits. The address line break was then applied by a guarded update, and the migration file was changed to match.

## 12. Sources

- [Consumer Protection (E-Commerce) Rules summary](https://www.indialaw.in/guides/civil/consumer-protection-e-commerce-rules/)
- [LiveLaw on the Rules](https://livelaw.in/news-updates/consumer-protection-e-commerce-rules-2020-160398)
- [3-2-1 backup explanation](https://www.nakivo.com/blog/3-2-1-backup-rule/)
- [Near-match found in the spot check](https://hashnode.com/posts/keeping-a-website-healthy-what-maintenance-covers-who-should-do-it/6adaa89f51d594b3bca68422)

# GIRZOCK Technologies: Premium Images, Digital Marketing, Insights and Local SEO

Date: 6 November 2026. Site tested: `http://localhost/girzock-website/` (local XAMPP). The site is not public yet, so nothing that needs a public URL has been run.

## Summary

- 16 realistic AI-generated service images are live in the mega menu and on the service pages.
- Digital Marketing is live as the 16th service.
- The Insights section is redesigned, and Work With Us shows its original images again.
- 9 new blog drafts are saved and unpublished.
- All automated tests pass (section 13).

**Not cleared:** the external plagiarism check has not been run, and mobile loading is slow.

**Correction to the last report:** `docs/VISUAL_UPGRADE_REPORT.md` said no image-generation tool was available. That was wrong. A Figma tool was available, but I had not checked for it. The report has been corrected.

**Screenshots:** only the developer reference image arrived with the brief. The Insights and Work With Us screenshots did not, so that work is based on the live sections and your backups.

## 1. Files modified

- **New:** `application/migrations/006_digital_marketing_and_photos.php`, `migrations/data/digital_marketing.php`, `assets/images/generated/photo/` (48 files), 9 sets of draft images in `assets/images/generated/blog/`, this report
- **Changed:** `application/config/migration.php`, `home/index.php`, `home/_latest_posts.php`, `home/areas.php`, `assets/css/girzock.css`, rebuilt `.min` files, `database/tools/build_illustrations.js`, `docs/VISUAL_UPGRADE_REPORT.md` (correction only)
- **Rebuilt with no intended change:** the earlier generated illustrations and industry icons, when the drawing script re-ran. The Builders icon was changed earlier and is unchanged here.
- **Database:** 1 service, 9 drafts, 1 category and their SEO rows added; service image references updated. Nothing deleted.

## 2. New images and page mapping

Generated with Figma's image generator (model `gpt-image-2.5-flare`), spending your Figma AI credits as you approved. You limited this to the service images, so 16 were generated. Figma did not report how many credits were used.

Each image appears in the mega menu and on its service page. Files are in `assets/images/generated/photo/menu/` and `photo/services/`, named after the service.

| Service | Image |
|---|---|
| Website Development | Developer with a responsive site on monitor, tablet and phone |
| Custom Software | Developer at a dashboard and a code screen |
| Web Application | Browser-based application on a laptop |
| E-commerce | Shop owner with an online store, parcels and card reader |
| WordPress | Designer editing a page in a content management system |
| UI/UX Design | Designer with app prototypes and wireframe sketches |
| CRM | Team reviewing customers and a sales pipeline |
| Mobile Apps | Developer testing a phone app against a laptop design |
| Cloud | Engineer in a bright data centre aisle |
| AWS | Architect drawing infrastructure on glass; no AWS logo |
| API | Developer with linked systems around a hub |
| Maintenance | Support specialist with uptime and security screens |
| SEO | Analyst with search results and analytics |
| Digital Transformation | Owner moving from paper files to a workflow |
| IT Consulting | Consultant explaining a roadmap to an owner |
| Digital Marketing | Marketer with campaign charts and social posts |

**Please note:**
- The people are AI-generated, not GIRZOCK staff. Don't present them as your team.
- The images have no readable text or logos by design. Small marks can still occur in AI output, so check them at full size. On-screen text was not checked letter by letter.
- Check that Figma's and the model's terms fit your commercial use.
- **Originals:** `backups/generated-service-photos-originals-2026-11-06/`. The Figma file "GIRZOCK service images" remains in your drafts.

**Not realistic images:** the Insights and article images, the case study images and the 9 new draft images remain vector illustrations, because you limited credits to the service images. They are labelled as illustrations in this report, not presented as realistic.

## 3. Image format and WebP results

| Item | Result |
|---|---|
| Service images | 48 WebP files, 2.3 MB in total: menu 812 × 380, page 912 × 1122 and 456 × 561 |
| Quality | 84, encoded with GD; each file's format was checked after saving |
| Largest file | 90 KB (page image); largest menu image 54 KB |
| Older images | Kept on disk; none deleted |
| Upload pipeline | Unchanged; 77 of 77 upload tests pass |

The 16 originals were PNG files from Figma, kept only in the backup folder. WebP is what the site uses.

## 4. Digital Marketing service

**Live** at `services/digital-marketing-services`, in these places: mega menu, Services listing, footer data, enquiry form, sitemap, admin, internal links (SEO service, Areas We Serve, home FAQ). It has its own SEO title and description, Service schema and breadcrumbs. Related services link both ways with SEO.

The page covers all 10 offerings, each with what it does and who it suits. It names Thisaiyanvilai, Tirunelveli, Thoothukudi, Nagercoil and Kanyakumari, and says there are no offices in the other towns. It makes no guarantees, certification claims, campaign results or "best" claims.

**Needs your confirmation:** I have no evidence of past digital marketing work. The page describes the service and claims no experience, as with Mobile, SEO and CRM.

**Homepage card:** the homepage core-services slider was not changed. Digital Marketing appears in the homepage menu, FAQ and enquiry form.

## 5. Mega menu

The menu now shows 16 services, 8 in each column, with Digital Marketing last. All 16 show their own image, title, description and link. The dark navy panel, layout and size are unchanged.

Tested on 17 pages (234 checks, on the isolated copy and the real site): hover, keyboard, touch, dark mode, failed image, active state and mobile menu. Desktop hover was tested at 1280, 1440 and 1920, and the mobile menu at 320 to 1024.

## 6. Service page images

All 16 service pages use their own realistic image, with descriptive alt text and responsive sizes. Checked at 375 and 1280: 32 of 32 correct on image, ratio, one H1 and no sideways scrolling. The final content suite also checks all 16.

The written content of the other 15 pages was not rewritten in this round. The earlier audit made it unique, and the duplicate check still shows low overlap (section 11).

## 7. Insights changes

- More space above: 40 px on desktop plus 100 px inside the panel, reducing on smaller screens.
- A light sky-blue panel with soft cyan and violet glows, and a dark version.
- A divider between the heading and the cards.
- Stronger card shadows and a larger hover lift, turned off for reduced motion.
- A publication date above each title. The date overflowed the curved category label, so it sits in the card text.

The heading is unchanged. The section is 145–178 px taller, as expected from the extra space. All three cards load at every tested width. They fade in as they scroll into view, about 1.5 seconds after a jump to the section.

## 8. Work With Us

**Restored, with one deliberate difference you approved.** The six original images (`brand1`–`brand6.png`) are back in their original order and slider, recovered from `backups/girzock-website-static-2026-11-05/`. Technology logos are gone from this section and remain in the separate technology slider elsewhere on the homepage. The heading stays "Work With GIRZOCK...", as you chose.

**Important:** your original site's own code comment says these are the template's sample companies, not partners: Minimize Interior, Nordyne, Metriks, QUO, Vintage Studio and Agrimax. They look like real client logos. Replace them with real ones when you can. **Their licence is not confirmed**, as they came with the template.

## 9. Blog drafts created: 9, none published

| Draft | Words | Search intent |
|---|---|---|
| Digital Marketing Strategies for Small Businesses in Tirunelveli | 636 | Planning |
| Why Local SEO Matters for Businesses in Thisaiyanvilai | 636 | Local, why it matters |
| How Social Media Marketing Helps Local Businesses Grow | 619 | Channel |
| SEO vs Paid Advertising: Which Is Right for Your Business? | 597 | Comparison |
| How to Improve Google Search Visibility for a Local Business | 594 | Step-by-step fixes |
| Digital Marketing Checklist for Small Businesses in Tamil Nadu | 557 | Checklist |
| Website and Digital Marketing: Why Both Matter | 625 | Website and marketing together |
| How to Choose a Digital Marketing Service Provider in Tirunelveli | 609 | Choosing a provider |
| Common Digital Marketing Mistakes Small Businesses Should Avoid | 580 | Mistakes |

**Left out:** "How Businesses in Thoothukudi Can Improve Their Online Presence", because it overlaps two existing drafts on Thoothukudi and online presence.

Each has its own SEO title and description, FAQs, service links, a call to action and a topic-specific illustration. There are no statistics or case studies, and examples are marked as illustrations where one is used. **Before publishing:** two drafts link to other drafts (visibility to local SEO, mistakes to checklist), so publish the target first or remove the link. Check the factual statements about Google's policies too; only the local ranking factors were checked against Google's help page in this round.

## 10. SEO keyword research

**Limit:** two more searches, mostly agency pages and promotional blogs, on top of last round's three. No keyword tool was available, so **search volumes were not measured**. Competitors' sites were not read in depth, and nothing was copied.

**Seen in results for Tirunelveli digital marketing (unverified):** Advetri, OwlClaw, BizAdda360, BG Digitz, Digital SEO, Versa Forge.

**What this suggests:**
- Many pages rely on "best" or "top" wording and promotional posts. Some show self-reported results.
- Plain guidance on choosing a provider and on what marketing can't promise looks like an opening.
- No Thisaiyanvilai-based digital marketing firm appeared. That is a possible opening, not proof that none exists.

| Target search | Where it is used |
|---|---|
| Digital marketing services in Tirunelveli | Digital Marketing title and focus keyword |
| Digital marketing company in Thisaiyanvilai | Digital Marketing page, in natural wording |
| SEO services in Tirunelveli | SEO page |
| Local SEO in Tamil Nadu and Thisaiyanvilai | SEO page, Local SEO draft |
| Social media marketing | Digital Marketing page and draft; Tirunelveli named on the page |
| Marketing for small businesses | Two drafts |
| Thoothukudi, Nagercoil, Kanyakumari | Named on the service page and Areas page; no duplicate city pages |

**Local strategy:** verify a Google Business Profile, keep business details consistent, gather genuine reviews and publish the drafts gradually. Google says local results depend mainly on relevance, distance and prominence, and nobody can promise rankings.

## 11. Duplicate-content audit

| Check | Result |
|---|---|
| Duplicate titles, descriptions, H1s | None across 60 indexable pages |
| Internal duplicate check, 61 documents and 1,830 pairs | Highest 6.3% (3 phrases, Contact and Home); between articles, drafts and services 2% or less |
| Repeated opening sentences | 0 |
| Spell-check of pages, new service and drafts | Only valid words flagged, such as Pongal and Deepavali |
| Listed demo text, keyword-stuffing check | No demo text found. Stuffing was reviewed by reading the new content only |

This is an internal check. It can't detect copied competitor text.

**Thin content still open:** six older posts have only 114–135 words. No older content was rewritten in this round.

## 12. External plagiarism verification

**Pending. Not run and not passed.** No external checker was available, so no 95% figure can be claimed. Check all public content and the 9 new drafts before publishing.

## 13. Responsive and test results

Tests that write data ran only on an isolated copy. The real site received read-only requests and migration 006.

| Suite | Where | Result |
|---|---|---|
| Fresh install through migration 006 | Isolated | Passed; second run changes nothing |
| Public | Isolated | 107 passed, 0 failed |
| Admin | Isolated | 291 passed, 0 failed |
| SEO and delete | Isolated | 181 passed, 0 failed |
| Browser | Isolated | 54 passed, 0 failed |
| Uploads | Isolated | 77 passed, 0 failed |
| Mega menu | Isolated and real | 234 passed, 0 failed on each |
| Content and images | Isolated and real | 770 passed, 0 failed on each |
| Read-only crawl | Real | 139 passed, 0 failed; 86 pages, 58 sitemap URLs |
| Admin panel click test | Real | 10 passed, 0 failed |
| Heading styles | Isolated | 1,362 compared, 0 differences |

**Homepage against a fresh baseline** (7 widths, light and dark; 1280 was not in that baseline):
- Images changed only in the mega menu and Work With Us.
- Section heights changed only in Insights and the home FAQ (+30 px at 320 and 768, from the extra words). Sections below move down accordingly.
- Text changed only in the FAQ, Insights, the enquiry form's service list and the hero counter mid-animation.
- No sideways scrolling, failed requests or script errors.

**Other width checks:** Insights and Work With Us were checked at 320, 375, 425, 768, 1024, 1280, 1440 and 1920, with no sideways scrolling. Screenshots were reviewed at 1440 (light and dark) and 375, plus the service page and menu.

**Tests caught three bugs of mine, all fixed before going live:** a missing Digital Marketing menu image, stray markup from a Work With Us edit, and the date overflow.

## 14. Performance

Lighthouse, mobile, local server, two runs each:

| Page | Performance | LCP | Page weight |
|---|---|---|---|
| Home | 39, 36 | 12.5 s, 12.4 s | 8.19 MB |
| Digital Marketing | 60, 41 | 12.0 s, 12.5 s | 2.53 MB |
| Article | 60, 60 | 13.4 s, 13.1 s | 2.48 MB |

CLS stayed below 0.05 on all three, and accessibility stayed at 94–96. **Slow loading is still a real problem:** LCP is far above Google's 2.5 s target. Home scored 53 before the last two rounds of work. Its weight hasn't risen and blocking time swings between runs, but I can't rule out a slowdown. Compression is off locally, so re-measure on production.

Only one menu preview loads with each page, and the others load on hover.

## 15. Backups and integrity

`backups/before-premium-upgrade-2026-11-06/`, taken before any change:

| File | Size | Check |
|---|---|---|
| `project-code.tar.gz` | 99.3 MB | Archive listed in full without errors |
| `girzock_technologies.sql` | 245,551 bytes | Dump complete, 28 tables |
| `girzock_technologies-immediately-before-migration.sql` | 245,551 bytes | 28 tables |

These backups were not test-restored. Real data after migration: admin password hash, SMTP settings and `.env` are unchanged (checksums compared), with 0 enquiries, 0 applications and 3 uploads, as before. Published article dates and content are unchanged. No PHP errors were logged on the real site during this work. Your Git repository was not touched by me, and nothing was committed.

## 16. Remaining issues

| Priority | Issue | Action |
|---|---|---|
| High | Plagiarism check not run | Run an external checker |
| High | Slow mobile loading (LCP about 12–13 s) | Enable compression, re-measure on production |
| High | Work With Us shows fictional company logos, licence unconfirmed | Replace with real logos, or confirm the licence |
| High | Digital Marketing, Mobile, SEO and CRM experience unconfirmed | Confirm, or unpublish |
| High | Other template and stock image licences unconfirmed; `blog1-8.png` has a watermark and remains in the project | Confirm, or replace |
| Medium | AI-generated people could be mistaken for staff | Don't use them as team photos |
| Medium | Insights, article, case study and draft images are still vector | Generate realistic images if you approve more credits |
| Medium | Six older posts are thin; sample portfolio and case studies remain | Expand them; replace with real work |
| Medium | Review the 9 drafts and 11 older drafts | Publish only after your review |
| Medium | Gmail App Password was shared in chat | Rotate it |
| Low | Rich Results Test, Search Console and WebP sharing images unverified | Check after launch |

## 17. Sources

- [Google: How to improve your local ranking](https://support.google.com/business/answer/7091?hl=en)
- [OwlClaw: Tirunelveli digital marketing](https://www.owlclaw.com/locations/tirunelveli-digital-marketing-agency/)
- [BizAdda360: SEO in Tirunelveli](https://bizadda360.com/services/ai-seo-company-in-tirunelveli)
- [Digital SEO profile](https://qoruz.com/agencies/profile/digital-seo)
- [Advetri: social media strategies for Tirunelveli](https://advetriglobalventures.blogspot.com/2026/03/best-social-media-marketing-strategies.html)
- [Azasoft: digital marketing in Tirunelveli](https://azasoft-solutions.blogspot.com/2026/03/professional-digital-marketing.html)

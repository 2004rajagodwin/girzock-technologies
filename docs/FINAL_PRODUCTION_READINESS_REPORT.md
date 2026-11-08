# Final Production Readiness Report

**Date:** 7 November 2026
**Build:** the local copy at `E:\Girzock Technologies\girzock website\girzock-website` (database migration 16)
**Target:** `https://girzock.com`

> **Status: ready to deploy, not yet live.**
> - The final regression passed: 9,372 checks passed. The 11 failures are a known Firefox measuring quirk, with no functional failure.
> - The site becomes production-ready only after the deployment steps are done on the live server and the smoke test passes.
> - **Nothing has been deployed. Deployment waits for your explicit approval.**

## 1. Acceptance criteria

| # | Criterion | Status | Evidence |
|---:|---|---|---|
| 1 | All public pages inventoried | Done | 87 unique pages (61 indexable), 89 URLs including pagination, 8 templates with their records, 40 admin screens listed separately. `FULL_WEBSITE_PAGE_INVENTORY.md` |
| 2 | Unique, relevant metadata on every indexable page | Done | 0 duplicate titles or descriptions; titles 30 to 60 characters; descriptions 120 to 160; one H1 each; self canonical; Open Graph and X tags; homepage-only values only on the homepage |
| 3 | Competitor research from real results | Done | 6 searches and 3 competitor sites opened, with sources linked. Limit: a US-based search tool. `COMPETITOR_RESEARCH_REPORT.md` |
| 4 | Original, useful content | Done | Products and job roles rewritten; services and posts measured as complete and original; nothing copied from competitors. `SEO_CONTENT_OPTIMIZATION_REPORT.md` |
| 5 | Local SEO on the real base and genuine areas | Done in the site. Google Business Profile, street address and PIN still needed from you | One base, Thisaiyanvilai; areas served in the structured data; no town doorway pages. `LOCAL_SEO_STRATEGY.md` |
| 6 | Blog publishing updates metadata and sitemap | Done | Drafts are 404 and out of the sitemap; previews are noindex; published posts enter the sitemap with lastmod. Tested on the isolated copy |
| 7 | Professional GIRZOCK admin login | Done | `ADMIN_LOGIN_REDESIGN_REPORT.md`, screenshots in `docs/screenshots/` |
| 8 | Password eye toggle | Done | Mouse, tap, Enter and Space, in three browsers; a focus bug was found and fixed |
| 9 | Password managers without unsafe storage | Done | Standard `autocomplete` values. No password in cookies, browser storage or the page (tested). Save prompts depend on browser settings: check once by hand |
| 10 | Forgot link hidden, recovery kept | Done | Not on the card; `/admin/forgot-password` works |
| 11 | All four social links work | Done | 990 real-site checks. **Facebook needs a one-time check in your browser** |
| 12 | Exact tagline on every page | Done | Only "Technology. Growth. Elevate." exists in the code and database. Checked on 23 page types |
| 13 | Same approved footer everywhere | Done | One component on every page |
| 14 | Public design unchanged | Done | Homepage comparison: no image or layout change, apart from the 320 px icon-row fix |
| 15 | Full regression and reports | Done | `FINAL_TESTING_REPORT.md` and the documents below |
| 16 | Deployment prepared, not executed | Done | Package and steps ready; waiting for your approval |

## 2. Production preparation checks

| Check | Local result | On the live server |
|---|---|---|
| Fresh database backup | Taken after migration 016. See section 5 | Back up the live site first (step 1) |
| Full source backup | Taken. See section 5 | — |
| Migrations | Version 16 locally and in the config; a fresh install reaches 16, and a second run changes nothing | Comes with the import |
| Production environment | `.env` has every key; values not printed. Locally `APP_ENV=development`, `COOKIE_SECURE=0` | Use `env.production.example`: `APP_ENV=production`, `https://girzock.com` base and public URL, `COOKIE_SECURE=1`, a dedicated database user, and **the same** `ENCRYPTION_KEY` and `SECRET_BOX_KEY` |
| HTTPS and secure cookies | Redirect rules ready but commented out. Admin cookie HttpOnly and SameSite=Lax; Secure once `COOKIE_SECURE=1` | Uncomment the rules after the certificate works; check the `http` and `www` redirects |
| SMTP | Sign-in verified earlier (AUTH 235, no message sent). Your two popup enquiries were delivered through the real account | Rotate the Gmail App Password; Send test email; one real enquiry |
| Database connection | The local site and every test run worked | Check the dedicated user in the import step |
| Private directories | `.env`, config, SQL, `.git`, `docs`, `system` and logs return 403; `girzock-private` is outside the web root | Repeat the checks |
| Uploads | `assets/uploads` is writable; scripts, HTML and SVG are blocked there (403) | Make `assets/uploads` and the private logs, sessions and resumes writable, and nothing else |
| Security headers | nosniff, Referrer-Policy, Permissions-Policy, X-Frame-Options; admin `DENY` and `no-store`; `X-Powered-By` removed | Add HSTS after HTTPS |
| Sitemap and robots | 61 URLs, all valid; robots names the sitemap | Check that the URLs read `https://girzock.com/` |
| Canonical URLs | Self-referencing on all 89 pages; built from `PUBLIC_URL` | Set `PUBLIC_URL=https://girzock.com` |
| Admin authentication | 170 checks: CSRF, new session at sign in, sign out ends the session, expiry, lockout after 5 failures, recovery | Sign in once after deployment |
| Search Console | Verification tag in the homepage head (from Website Settings) | Verify, then submit the sitemap |
| Sharing images | `girzock-hero.png` and `girzock-logo.png` copied from the current live site to the same addresses | — |

## 3. Remaining items

**Before launch:**
1. Apply the production settings and HTTPS on the server.
2. Rotate the Gmail App Password, then test email on the live server.
3. Confirm the six job openings, and add qualifications, experience and closing dates.
4. Have the legal pages reviewed.
5. Turn on compression, then re-measure speed. Mobile Lighthouse is 50 to 59 locally, because there is no compression.
6. **Open the Facebook link once** and confirm it is your page.

**Your decisions, at any time:**
- **Google Business Profile, street address and PIN:** the largest local SEO gain.
- **Directory profiles:** IndiaMART, GoodFirms, TechBehemoths, The Manifest, Clutch.
- **Content facts:** product pricing approach; case study results, if the projects are real; claims to confirm (Digital Marketing, Mobile, SEO and CRM experience; permission for the "Work With" logos).
- **Sharing image:** a 1200×630 version of the hero image, because the current portrait one is cropped by Facebook and LinkedIn.
- **The custom software section:** look at it once in the browser. It is 25 to 52 px shorter than in an earlier capture, with no code change found.
- **Git:** nothing is committed unless you ask.

**Minor, not blockers:**
- one heading level skip on `/services`;
- 22 SVG icons without size attributes;
- 5 images not lazy-loaded;
- no CSP yet.

## 4. Database changes on the local database (none on the live server)

| Migration | Change | Backup right before it |
|---|---|---|
| 011 | Popup settings | Yes |
| 012 | Content and local SEO (posts, service paragraphs) | Yes |
| 013 | Popup reappearance settings | No: 012 dump plus migrations rebuilds it |
| **014** | `secondary_keywords` column; homepage keyword and X settings; Search Console code (only if empty); homepage sharing values (only if empty) | Yes |
| **015** | Product descriptions (only the short originals); job descriptions and responsibilities (only if empty) | Yes |
| **016** | Secondary keywords for 52 pages (only if empty) | Yes |
| Direct settings update | LinkedIn and Facebook addresses in `social_links` | Yes: the backup at the start of this pass |

## 5. Backups, package and rollback

**Backups,** under `E:\Girzock Technologies\girzock website\backups\`:

| Folder | Contents |
|---|---|
| `before-seo-login-2026-11-07\` | Code and database at the start of this pass, plus the database immediately before migrations 014, 015 and 016 |
| `final-seo-login-2026-11-07\` | Database and code at the end of the SEO and login pass |
| `before-cleanup-2026-11-08\` | Code and database before the cleanup (the database dump is kept until you decide) |
| `after-cleanup-2026-11-08\` | Code only, after the cleanup, matching the package |
| Earlier folders | Listed in `PRODUCTION_DEPLOYMENT_GUIDE.md` |

**Package:** `E:\Girzock Technologies\girzock website\deployment\girzock-deploy-2026-11-08\` (8 November). It holds code only, with no database export; export the database at deployment time. The older package folders are out of date and are kept only until you approve their removal.

**Changes made on the local site since the report** (by you, not by the build):
- the homepage SEO title (83 characters) and description (226 characters);
- an explicit homepage canonical, `https://girzock.com/`.

Google usually shows about 60 characters of a title and 120 to 160 of a description, so the ends may be cut off. One job application (GZ-JOB-2026-00002) was also received through the local site.

**Rollback:**
1. Restore the live site's files and database, downloaded in step 1 of the guide.
2. Keep the old `.env` until the new site is confirmed.

Migrations do not revert content, so a database rollback always means restoring a backup.

## 6. Deployment steps

Follow `PRODUCTION_DEPLOYMENT_GUIDE.md`, steps 1 to 13. Each step happens only after your approval.

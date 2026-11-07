# Final Production Readiness Report

**Date:** 7 November 2026
**Build:** the local copy at `E:\Girzock Technologies\girzock website\girzock-website`
**Target:** `https://girzock.com`

> **Status: ready to deploy, not yet live.**
> - The local build passed its final regression: 8,988 checks passed. The 11 failures are a known Firefox measurement quirk, with no functional failure.
> - It becomes production-ready only after the deployment steps are done on the live server and the smoke test passes.
> - **Nothing has been deployed. Deployment waits for your explicit approval.**

## 1. What was finished in this pass

| Area | Result | Report |
|---|---|---|
| Form speed | The reply arrives in a median of 43 ms (60 ms in the first run), down from 6,123 ms, with a mail server that takes 3 s per email. Under Apache the reply arrived in 4 ms. Both emails are still sent, after the reply. Cut-off sends are retried | `FORM_SUBMISSION_PERFORMANCE_REPORT.md` |
| Success message | "Thank you! Your enquiry has been submitted successfully." No reference number. Closes after 3.5 s, with a close button. Same on all forms. Shown only after the save | same |
| Popup reappearance | Admin chooses: after N days (default 7), never after close, once per session, or every page load. Hidden 30 days after sending the form. "Reset visitor dismissals" button. Off always wins | `POPUP_DISMISSAL_SETTINGS_REPORT.md` |
| Popup form | Message optional, fixed 96 px box, no resize. **The scrollbar was found and fixed;** no scroll at 1024×768 to 1920×1080 | same |
| Social links | LinkedIn, Facebook, Instagram and WhatsApp URL fields under **Website Settings → Social links**, with strict address checks. An icon appears only with a valid saved address. **LinkedIn and Facebook are ready, but hidden until you add your official addresses** | `FOOTER_SOCIAL_LINK_AUDIT.md` |
| Footer | The homepage footer and "Technology. Growth. Elevate." on every public page; checked on 23 page types | same |
| SEO | Scorecard: **88.1/100 combined (weighted), 89.5 overall.** An internal checklist, not a Google score | `COMPLETE_SEO_SCORE_REPORT.md` |
| Pages | **87 unique public pages:** 61 indexable and 26 noindex on purpose, plus 2 pagination URLs. 61 in the sitemap. 40 admin screens | `COMPLETE_PAGE_INVENTORY.md` |
| Content | 45 pages Strong, 3 Good, 14 Needs work, 0 Thin. The weak ones are the job openings, the products and two case studies, each with a page-by-page plan | `CONTENT_QUALITY_AUDIT.md` |
| Tests | Isolated copy: 3,080 passed, 0 failed. Real site, read-only: 5,908 passed, 11 failed (Firefox measurement only) | `FINAL_REGRESSION_TEST_REPORT.md` |

## 2. Production preparation checks

| Check | Local result | On the live server |
|---|---|---|
| Fresh database backup | Taken at the end of this pass. See section 6 | Back up the live site before uploading (step 1) |
| Migration status | Version 13 on the local database and in `config/migration.php`. A fresh install reaches 13; a second run changes nothing | The import carries version 13 |
| Environment variables | The private `.env` has every key the code reads: `APP_ENV`, `BASE_URL`, `PUBLIC_URL`, `DB_*`, `ENCRYPTION_KEY`, `SECRET_BOX_KEY`, `COOKIE_SECURE` and `SMTP_*`. Values were not printed. Locally `APP_ENV=development` and `COOKIE_SECURE=0`, as expected | Use `env.production.example`: `APP_ENV=production`, `BASE_URL=https://girzock.com/`, `PUBLIC_URL=https://girzock.com`, `COOKIE_SECURE=1`, a dedicated `DB_USER`, and the **same** `SECRET_BOX_KEY` |
| HTTPS and secure cookies | **Not active locally.** The four redirect rules in `.htaccess` are commented out, and cookies are `HttpOnly; SameSite=Strict` but not `Secure` | Uncomment the rules once the certificate works; set `COOKIE_SECURE=1`; check that `http://` and `www.` redirect |
| SMTP, real delivery | The SMTP sign-in was verified (AUTH 235) without sending. Both emails for your own popup enquiries went out through the real account: #7 at 16:06 and #8 at 16:40, logged as sent | Rotate the Gmail App Password, use "Send test email", then send one enquiry |
| Upload folder | `assets/uploads` is writable. Its `.htaccess` blocks scripts, HTML and SVG; `/assets/uploads/x.php` returns 403 | Make `assets/uploads` and the private `logs`, `sessions` and `resumes` writable, and nothing else |
| Private files | 403: `.env`, `.git/HEAD`, `application/config/database.php`, `database/*.sql`, `composer.json`, `README.md`, `docs/`, `system/`, `application/logs/`. 404: `/setup/migrate`, `/phpinfo.php` | Repeat the same checks (step 5) |
| Admin protection | `/admin` and `/admin/settings` redirect to `/admin/login` | Same |
| Security headers | Present: `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, `X-Frame-Options` (sent once). `X-Powered-By` removed. Not set: HSTS and Content-Security-Policy | Add HSTS after HTTPS works. Try a CSP in report-only mode first, because the site uses inline scripts |
| Sitemap and robots | `/sitemap.xml` has 61 URLs, all 200, all indexable and self-canonical, with lastmod on every record. `robots.txt` blocks `/admin/`, `/search` and the form endpoints, and names the sitemap | Check that the sitemap shows `https://girzock.com/` addresses once `PUBLIC_URL` is set |
| Canonical URLs and redirects | Every crawled page has a self-referencing canonical. 11 old addresses (10 `.html` pages and `/terms-and-conditions`) return 301. Unknown addresses return a real 404 | Same, with the live domain |
| Rollback | Written in `PRODUCTION_DEPLOYMENT_GUIDE.md` | Keep the downloaded live backup until the new site is confirmed |
| Deployment package | Rebuilt at the end of this pass. See section 6 | Upload only after approval |

## 3. Remaining blockers and owner decisions

**Before launch:**
1. **Apply the production settings and HTTPS** on the server: the env values, the redirect rules and `COOKIE_SECURE`.
2. **Rotate the Gmail App Password** and test email on the live server.
3. **Confirm the six job openings** are real vacancies, and fill in their details or turn them off.
4. **Have the legal pages reviewed.**
5. **Turn on compression on the server** (`mod_deflate`), then re-measure speed. Locally, mobile Lighthouse performance is 42 to 60 with LCP of 15 to 18 s, because compression is off.

**Your decisions, at any time:**
- **LinkedIn and Facebook:** paste the official company page addresses in Website Settings. Until then they stay hidden.
- **Local business details:** the street address, PIN code and Google Business Profile. Nothing is stored and nothing was invented. These are the largest gap in the local SEO score.
- **Weak pages:** add the product details, the job role details and the case study results described in `CONTENT_QUALITY_AUDIT.md`.
- **Claims to confirm:** Digital Marketing, Mobile, SEO and CRM experience, and permission for the "Work With" logos.
- **Alangulam:** it has been in Tenkasi District since 2019, so it is not listed under Tirunelveli.
- **Your own two test enquiries:** delete them in the admin before exporting, if you don't want them on the live site.
- **Git:** this pass is not committed. Nothing is committed unless you ask.

**Known minor items, not blockers:**
- `/services` has one heading level skip (a counter uses H4).
- 22 SVG icons have no width or height attribute, and 5 below-the-fold images do not lazy-load.
- The Organization markup has no street address or map coordinates.
- Product and job markup lack price, rating and closing date, because no real data exists for them.
- In the homepage comparison, `#custom-software-solutions` is 25 to 52 px shorter than in the 16:18 capture, with no code change found. Look at it once in the browser.

**Your edit during this pass:** you removed the "Our Commitment" section from `home/index.php` at 17:53. It was kept as you left it, and two tests were updated for it.

## 4. Database changes

| Migration | What it does | Applied to the local database |
|---|---|---|
| 011 | Popup settings (`INSERT IGNORE`) | Yes, after a backup |
| 012 | 6 short posts rewritten; a local paragraph for each of the 16 services; homepage meta title; Digital Marketing description | Yes, after a backup taken right before it |
| 013 | Popup reappearance: `popup_reappear`, `popup_dismiss_days`, `popup_submit_days`, `popup_visitor_version` (`INSERT IGNORE`) | Yes. No dump was taken right before it; the 16:50 dump plus migrations 012 and 013 rebuilds the same state |

There was no database change for the social links; the four platforms already existed. Nothing on the live server has been changed.

## 5. Deployment steps (summary)

The full steps are in `PRODUCTION_DEPLOYMENT_GUIDE.md`. Each step happens only after your approval.

1. Back up the live site's files and database, and download them.
2. Create the database and a dedicated user, then import `girzock_technologies.sql` from the package.
3. Create `girzock-private/.env` above the web root from `env.production.example`. Copy `ENCRYPTION_KEY` and `SECRET_BOX_KEY` exactly from your local `.env`.
4. Check `SHA256SUMS.txt`, then upload and unpack `girzock-website-files.tar.gz`.
5. Confirm that the private paths return 403 and that `/admin` redirects to the login.
6. Turn on HTTPS: uncomment the `.htaccess` rules, keep `COOKIE_SECURE=1` and sign in again.
7. Rotate the Gmail App Password, then send a test email and one enquiry. The success message should appear in under a second, and the email log should show both emails sent.
8. Add the cron job `php index.php setup retry_emails` every 15 minutes.
9. Smoke test:
   - every sitemap URL;
   - the admin modules;
   - the popup and its reappearance;
   - the footer links;
   - the legal pages, favicon and fonts.
10. Turn on compression, then rerun Lighthouse.
11. Add the site in Search Console and Bing, and submit the sitemap.
12. Watch the logs for 48 hours.

## 6. Backups and rollback

**Code and database backups,** all under `E:\Girzock Technologies\girzock website\backups\`:

| Backup | Contents |
|---|---|
| `before-popup-2026-11-07\` | Code and database, including `girzock_technologies-immediately-before-migration-011.sql` |
| `before-final-refinement-2026-11-07\` | Code and the database right before migration 012 |
| `before-form-speed-popup-dismissal-2026-11-07.tar.gz` | Code before this pass's form and popup changes |
| `after-migration-013-2026-11-07\` | Database at 17:19 |
| `final-2026-11-07\` | Database and code at the end of this pass |

**Deployment package:** `E:\Girzock Technologies\girzock website\deployment\girzock-deploy-2026-11-07-final\`. The earlier package, `girzock-deploy-2026-11-07\`, is out of date; do not use it.

**Rollback on the live server:**
1. Restore the files and database downloaded in step 1.
2. Keep the old `.env` until the new site is confirmed.

Migration `down()` methods do not revert content, so a database rollback always means restoring a backup.

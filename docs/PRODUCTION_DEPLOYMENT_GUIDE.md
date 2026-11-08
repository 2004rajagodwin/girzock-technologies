# GIRZOCK Technologies: Production Deployment Guide

For deploying the build of 7 November 2026 to `https://girzock.com`. **Nothing has been deployed. Do these steps only after you approve.**

## Package (already built)
Folder: `E:\Girzock Technologies\girzock website\deployment\girzock-deploy-2026-11-08\` (built 8 November, 10:17). This is the only current package. The older package folders are out of date and are kept only until you approve their removal.

| File | Contents |
|---|---|
| `girzock-website-files.tar.gz` | 1,409 site files. No `.git`, `.claude`, `docs`, local tools or `.env`. It includes the install file `database/girzock_technologies.sql` (empty schema and starter content), not your live data |
| (no database export) | By your instruction the package holds no database copy. Export the local database at deployment time (step 2), after deleting any test enquiries or applications you do not want live |
| `private-dir.htaccess` | Copy to `girzock-private/.htaccess` |
| `env.production.example` | Production values for `APP_ENV`, `BASE_URL`, `PUBLIC_URL`, `COOKIE_SECURE`, and `DB_USER=girzock_app` as a placeholder for your dedicated user; secret fields empty |
| `SHA256SUMS.txt` | Checksums to confirm the upload is complete |

Local backups made today, in `backups\`: `before-popup-2026-11-07\` (code and database), `before-final-refinement-2026-11-07\` (including the database immediately before migration 012), `before-form-speed-popup-dismissal-2026-11-07.tar.gz` (code only) `after-migration-013-2026-11-07\` (the database at 17:19) `final-2026-11-07\` (19:01), `before-seo-login-2026-11-07\` (start of the SEO and login pass, with dumps right before migrations 014, 015 and 016) and `final-seo-login-2026-11-07\` (database and code at 23:04; its database matches the package, and its code archive also holds 12 tiny test images that were removed before the package was built).

No separate database dump was taken between migrations 012 and 013. Migration 013 only adds four popup settings with `INSERT IGNORE`, and nothing else changed in between. Restoring the 16:50 dump and running the migrations rebuilds the same state.

## Server requirements
- **PHP:** 8.2 (tested), with mysqli, mbstring, fileinfo, dom, openssl, and gd with WebP support.
- **Database:** MariaDB 10.4 (tested) or MySQL.
- **Apache:** `mod_rewrite` (required); `mod_headers` and `mod_deflate` (recommended); `AllowOverride All`.
- **Private folder:** `girzock-private` one level above the web root, holding `.env`, `logs`, `sessions` and `resumes`, all writable.
- **Writable folder:** `assets/uploads`.

## Steps
1. **Back up the live site:** download its files and export its database, before changing anything.
2. **Database:** create the database and a dedicated user with rights to it only. Import `girzock_technologies.sql`.
3. **Private settings:** create `girzock-private/.env` from `env.production.example`.
   - Fill in the database values.
   - Copy `ENCRYPTION_KEY` and **`SECRET_BOX_KEY` exactly from your local `.env`**. Otherwise the stored SMTP password cannot be read.
   - Never put `.env` in the web root.
4. **Files:** upload and unpack `girzock-website-files.tar.gz` into the web root. Check `SHA256SUMS.txt` first.
5. **Confirm protection:** `/.env`, `/application/config/database.php` and `/database/girzock_technologies.sql` must return 403, and `/admin` must redirect to the login.
6. **HTTPS:** with a valid certificate, uncomment the four rules at the top of `.htaccess`. Then test `http://` and `www.`, which must both redirect to `https://girzock.com/`.
7. **Secure cookies:** keep `COOKIE_SECURE=1`, then sign in to the admin panel again.
8. **Email:** rotate the Gmail App Password, enter it in Admin > Website Settings, and click "Send test email". Then send one enquiry through the popup and confirm both emails arrive.
   - The success message should appear in under a second. The site replies before sending the emails.
   - If the message takes as long as the emails, the host is holding the reply back, usually through output buffering or compression on PHP responses. Ask the host to turn this off for PHP, or tell me and I will adjust it.
   - Check **Admin > Enquiries > (the enquiry) > Email log** shows both emails as sent.
9. **Scheduled task:** add a cron job running `php index.php setup retry_emails` every 15 minutes.
10. **Smoke test:**
    - every URL in `/sitemap.xml` returns 200;
    - the admin modules open;
    - the popup opens after 5 s on desktop and mobile; after you close it, it stays hidden on refresh;
    - the favicon, preloader, fonts (`/assets/fonts/manrope-latin.woff2`) and legal pages work;
    - the footer Instagram and WhatsApp icons open in a new tab;
    - `robots.txt` names `https://girzock.com/sitemap.xml`.
11. **Compression:** check that CSS and JavaScript responses show `Content-Encoding`. Then rerun Lighthouse.
12. **Search engines:** add the site in Google Search Console and Bing Webmaster Tools, then submit the sitemap. The Settings field `gsc_verification` can hold Google's verification tag.
13. **Monitor:** watch `girzock-private/logs` for 48 hours.

## Rollback
1. Restore the files and database you downloaded in step 1.
2. If the database has been changed since, restore its export; migration `down()` methods do not revert content.
3. Keep the old `.env` until the new site is confirmed.

## Before you approve
- **Legal pages:** review the Privacy, Terms and Cookie text, ideally with a lawyer.
- **Popup:** set an end date for the Diwali offer.
- **Job openings:** confirm the six openings are genuine, or disable them.
- **After your own testing:** use Admin > Promotional Popup > **Reset visitor dismissals** only if you want every visitor to see the popup again.
- **Local business details:** send the street address and PIN code if you want them in the search markup.
- **Facebook link:** open https://www.facebook.com/profile.php?id=61596044820156 once in your browser and confirm it is your page. It could not be checked automatically. LinkedIn was confirmed.
- **Admin password recovery:** the "Forgot your password?" link is no longer shown on the login card. Bookmark `https://girzock.com/admin/forgot-password` for administrators.

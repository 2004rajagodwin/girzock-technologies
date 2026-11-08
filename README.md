# GIRZOCK Technologies website

The company website and admin panel. CodeIgniter 3.1.13, PHP 8.2, MySQL or MariaDB.

- Public site: `http://localhost/girzock-website/`
- Admin panel: `http://localhost/girzock-website/admin/login`

## Install on XAMPP

You need Apache and MySQL running from the XAMPP control panel, with `mod_rewrite` on (it is by default).

### 1. Put the project where Apache can see it

Link it from where it is, so that the private folder in step 3 stays outside `htdocs`. In a Command Prompt:

```bat
mklink /J "C:\xampp\htdocs\girzock-website" "E:\Girzock Technologies\girzock website\girzock-website"
```

### 2. Create the database

In phpMyAdmin, choose **Import** and select `database/girzock_technologies.sql`. This creates the `girzock_technologies` database, all tables and the existing website content. Or from a terminal:

```bat
C:\xampp\mysql\bin\mysql.exe -u root -p < database\girzock_technologies.sql
```

The file contains no user accounts or passwords. Add the full service pages, page SEO and draft articles after step 3, once `.env` is in place:

```bat
php index.php setup migrate
```

### 3. Create the private settings file

Secrets live outside the project, in a `girzock-private` folder **next to** the project folder:

```
girzock website\
  girzock-website\      the project
  girzock-private\      secrets, resumes, sessions and logs (never publish this)
    .env
```

Copy `docs/env.example` to `girzock-private/.env` and fill it in. Generate each of the two keys with:

```bat
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

Then copy `docs/private-dir.htaccess` to `girzock-private/.htaccess`. It blocks browsers as a second layer of protection.

If the folder has to be somewhere else, set a server environment variable `GIRZOCK_PRIVATE_DIR` to its full path, for example `SetEnv GIRZOCK_PRIVATE_DIR "/home/account/girzock-private"` in the Apache configuration. It must stay outside the public web root.

The site checks these settings on every request. If `.env` is missing, or a required production setting is absent, visitors see a plain "temporarily unavailable" page and the reason goes to `girzock-private/logs/`. A missing or invalid `SECRET_BOX_KEY` is logged too, but the site keeps running and enquiries are still saved. Emails then wait, marked Failed, until the key is fixed.

Do not change `SECRET_BOX_KEY` once it is in use: the saved SMTP password can only be read with the key that encrypted it. If the key does change, enter the SMTP password again in Website Settings.

XAMPP's default MySQL user is `root` with an empty password. Do not assume production uses the same values.

### 4. Create the first administrator

From the project folder:

```bat
php index.php setup admin girzock2026 you@example.com
```

This prints a random one-time password, once. Sign in with it; you must choose your own password before anything else opens. The command refuses to run if a Super Admin already exists. Save the email address carefully, because password reset links are sent there.

### 5. Configure email

Sign in and open **Website Settings > Email (SMTP)**. Enter your provider's details, save, and press **Send test email**. Alternatively, set the `SMTP_*` values in `.env`.

Until SMTP is configured, enquiries are still saved and appear in the admin panel, but no emails go out. Their email status shows as Skipped, and **Retry undelivered emails** on the enquiry page sends them afterwards.

For Gmail, turn on 2-step verification and create an App Password. Use host `smtp.gmail.com`, port `587`, encryption TLS, with the Gmail address as both username and From email.

### 6. Check it

Open the site, send a test enquiry from the homepage, and confirm it appears under **Enquiries** in the admin panel.

## Day-to-day use

| To change | Go to |
|---|---|
| Enquiries: status, notes, assignment, CSV export | Enquiries |
| Services, including where each appears in the menu, footer and homepage | Services > Edit > "Where this appears on the website" |
| Products, portfolio, case studies, careers | Their own menu items |
| Articles, scheduling, tags | Blog Management |
| Category and tag names | Categories |
| Company details, logo, social links, analytics | Website Settings |
| Page titles and descriptions, redirects | SEO Management |
| Admin accounts and what each role can do | Admin Users, then Roles and permissions |

Text written into page layouts (such as the homepage hero, FAQ, process steps and the About page) is in the view files under `application/views/frontend/`, not the admin panel.

Scheduled blog posts go live on their own at the chosen time, with no cron job.

## Going live

**Nothing is deployed without the owner's approval.** Full background, test results and checklists are in `docs/project-report/GIRZOCK_Technologies_Complete_Project_Report.pdf` (the same content as the `.docx`).

The deployment package lives in `deployment/` beside this folder, with `SHA256SUMS.txt`. It holds the site files without `.git`, `docs`, local tools or `.env`, plus `env.production.example`.

1. **Back up the live site first:** download its files and export its database. This is the rollback.
2. **Database:** create the database and a dedicated user with rights to it only. Export the local database (it holds the current content, at migration 16) and import it. Delete any test enquiries in the admin first if you do not want them live.
3. **Private settings:** create `girzock-private/.env` **above** the web root, from `env.production.example`:
   - `APP_ENV=production`;
   - `BASE_URL=https://girzock.com/` and `PUBLIC_URL=https://girzock.com`;
   - `COOKIE_SECURE=1`;
   - the new database credentials;
   - copy `ENCRYPTION_KEY` and `SECRET_BOX_KEY` **exactly** from the local `.env`. A different `SECRET_BOX_KEY` makes the stored SMTP password unreadable.

   Copy `docs/private-dir.htaccess` to `girzock-private/.htaccess`. If the project sits inside `public_html`, set `GIRZOCK_PRIVATE_DIR`. Then confirm that `https://girzock.com/girzock-private/.env` does not open.
4. **Files:** check `SHA256SUMS.txt`, then upload and unpack the package into the web root. Make `assets/uploads` and the private `logs`, `sessions` and `resumes` folders writable by the web server, and nothing else.
5. **Protection:** `/.env`, `/application/config/database.php` and `/database/girzock_technologies.sql` must return 403, and `/admin` must redirect to the login.
6. **HTTPS:** once the certificate works, uncomment the HTTPS and `www` redirects at the top of `.htaccess`. Then sign in to the admin again, because cookies are now Secure.
7. **Email:** rotate the Gmail App Password, enter it in Website Settings, and use "Send test email". Then send one enquiry through the popup:
   - the success message should appear in under a second;
   - the enquiry's email log should show both emails sent.
8. **Cron:** run `php index.php setup retry_emails` every 15 minutes. It retries failed or interrupted notification emails.
9. **Compression:** confirm that CSS and JavaScript responses carry `Content-Encoding: gzip` or `br`. This is the largest speed gain.
10. **Smoke test:**
    - every URL in `/sitemap.xml` returns 200, with `https://girzock.com/` addresses;
    - the admin modules open;
    - the popup works;
    - the four footer social icons open in a new tab. Open the Facebook link once to confirm it is the right page;
    - the legal pages, favicon and fonts load.
11. **Search engines:** the Search Console verification tag is already in the homepage head (Website Settings). Verify the property, submit `https://girzock.com/sitemap.xml`, and run the Rich Results Test.
12. **Watch** `girzock-private/logs` for 48 hours.

**Rollback:** restore the files and database downloaded in step 1, and keep the old `.env` until the new site is confirmed. Migrations do not revert content, so a database rollback always means restoring a backup.

**Admin password recovery:** the login card no longer shows a "Forgot your password?" link. Recovery still works at `/admin/forgot-password`, so bookmark it.

## Search engines and analytics

**Publishing draft articles:** open **Blog Management**, review the draft, use **Preview page** and set its status to Published. It then joins the sitemap automatically. Check each article's facts first.

**Google Search Console:**
1. At `https://search.google.com/search-console`, add `https://girzock.com` as a property.
2. For the HTML tag method, copy only the code from `content="..."` into **Website Settings > Google Search Console verification code**.
3. After verifying, submit `https://girzock.com/sitemap.xml`.
4. Use URL Inspection on the homepage and main service pages to request indexing.

**Google Analytics 4:** create a GA4 property and paste its Measurement ID (`G-XXXXXXXXXX`) into **Website Settings > Google Analytics ID**. Nothing loads until an ID is entered.

**Google Business Profile:** claim one profile for the real Thisaiyanvilai location at `https://business.google.com`, with service areas if appropriate. Do not add addresses in other towns.

**After launch, check:** the Rich Results Test (`https://search.google.com/test/rich-results`), and PageSpeed Insights (`https://pagespeed.web.dev`) for Core Web Vitals.

**Speed on the server:** turn on `mod_deflate` for text compression. In XAMPP, remove the `#` before `LoadModule deflate_module` in `httpd.conf` and restart Apache. `.htaccess` already has the rules.

**Illustrations:** the service, article and case study artwork and the industry icons are drawn by `database/tools/build_illustrations.js`. Edit a scene there and re-run it with `NODE_PATH=<folder with puppeteer-core> node database/tools/build_illustrations.js`.

**Uploaded images:** every admin upload is stored as WebP with smaller copies beside it. If the server cannot convert a file, the upload is refused with a message. It needs Imagick or GD with WebP support.

**Editing CSS or JavaScript:** the site loads `.min` files. After editing `style.css`, `girzock.css`, `girzock-dynamic.css`, `main.js` or `girzock.js`, rebuild them with `database/tools/minify_assets.js`. After adding large images, run `php database/tools/build_webp.php`.

## Version control

Start the Git repository inside the `girzock-website` folder:

```bat
cd "E:\Girzock Technologies\girzock website\girzock-website"
git init
```

Never run `git init` in the parent `girzock website` folder. `.gitignore` here cannot protect `girzock-private` and `backups` from a repository started there. Before the first commit, check the list from `git add -n .` for anything private.

## Database changes

`database/girzock_technologies.sql` is the complete install file. For later changes:

1. Add `application/migrations/002_describe_the_change.php`, with `up()` and `down()` methods.
2. Raise `$config['migration_version']` in `application/config/migration.php`.
3. Run `php index.php setup migrate`.

To regenerate the install file after editing `database/schema.sql`:

```bat
php database\tools\build_install_sql.php "path\to\original\static\html"
```

## Code layout

```
application/
  controllers/          public pages; admin/ holds the admin panel
  core/                 MY_Controller, Admin_Controller, Admin_Crud_Controller (shared list/edit/delete), MY_Model
  libraries/            Admin_auth, Mailer, Media_manager, Html_sanitizer, Seo
  models/               all database access
  views/frontend/       the public site; partials/ holds the header, footer and forms
  views/admin/          the admin panel; crud/ holds the shared list and form
assets/                 original site assets, plus admin/ and uploads/
database/               install SQL, schema and the seed builder
```

The six content modules in the admin panel declare their fields in their controllers and share one implementation in `Admin_Crud_Controller`.

`system/` is CodeIgniter itself and is unmodified. PHP 8.2 reports deprecation notices for CodeIgniter 3's dynamic properties; those notices are switched off in `index.php`. They do not affect behaviour on PHP 8.x.

## Troubleshooting

| Symptom | Likely cause |
|---|---|
| Every page but the home page gives 404 | `mod_rewrite` is off, or `AllowOverride` is not `All` for this folder |
| "Temporarily unavailable" on every page | A configuration problem. The exact reason is in `girzock-private/logs/`; if there is no log there, check the PHP or Apache error log |
| Emails show Failed with "cannot be decrypted" | `SECRET_BOX_KEY` is missing, invalid or has changed. Restore it, or enter the SMTP password again in Website Settings |
| "Unable to connect to your database server" | Wrong `DB_*` values in `.env`, or `.env` not found in `girzock-private` |
| "The action you have requested is not allowed" | The form's security token expired. Reload the page and resubmit |
| Emails show Failed | Check the reason on the enquiry page, then the SMTP settings. Press **Send test email** to retry |
| Admin locked out after failed logins | Wait 15 minutes, or use **Forgot your password?** |
| Images fail to upload | `assets/uploads` is not writable, or the file is over 5 MB |

# Testing report

Tested on 5 and 6 November 2026 on XAMPP: PHP 8.2.12, MariaDB 10.4.32, Apache 2.4.58, using Chrome in headless mode.

**Result: 475 automated checks passed on a fresh install from `database/girzock_technologies.sql`. Real email delivery, the live server and non-Chrome browsers have not been tested yet (see "Not tested").**

Tests ran over real HTTP through Apache, against a database rebuilt from the delivered SQL file by following the README.

## Design compared with the original site

Each original static page and its converted page were opened side by side at 1920, 1440, 1366, 1024, 768, 480 and 375 px. For every section the test compared height, text and image sources, plus total page height.

| Page | Result at all 7 widths |
|---|---|
| Home, About, Services, Products, Portfolio, Case Studies, Careers, Contact | Identical (56 of 56) |
| Blog | Differs on purpose, see below |

The comparison ignores the hidden anti-spam form field, which has no visible effect.

Differences on purpose, all on the blog page:

- The six full articles moved to their own pages, in the same layout. The listing keeps its card grid.
- A category and search bar was added above the grid, because the brief requires both.

The comparison measures structure, not colour or animation. The homepage hero was also compared by eye at 1440 px and looked the same. Colours come from the same unchanged stylesheets.

## Results by area

| Area | Checks | What was verified |
|---|---|---|
| Public site, security, SEO | 129 | Forms, CSRF, validation, duplicates, rate limits, uploads, metadata, sitemap, redirects, blocked folders |
| Admin panel | 292 | Sign-in, forced password change, dashboard figures, enquiries, all six content modules, media, categories, SEO, settings, roles, password reset, lockout |
| Browser behaviour | 54 | Carousels, mega menu, dark mode, gallery filter and lightbox, mobile menu, both contact forms, new pages at 3 widths |

Also checked separately:

- **Production mode:** a page with deliberate PHP and database errors showed visitors no error detail.
- **Secrets:** no credentials or keys in project files, and no user accounts in the SQL file.

### Enquiries and email

- Enquiries are saved with a unique reference, and appear in the admin panel straight away.
- Company and client emails are sent and logged. The client email has the required wording and reference.
- Submitting twice creates no duplicate enquiry or email.
- With the mail server down or not configured, the enquiry is still saved and the visitor still sees success. The failure is logged and **Retry undelivered emails** delivers it later.

### Security

| Test | Result |
|---|---|
| SQL injection in login, search, URLs and forms | No effect |
| Script injection in forms, search and rich text | Escaped or removed |
| Requests without a CSRF token | Refused (403) |
| Email header injection | Blocked |
| PHP file disguised as a PDF or image, SVG upload | Refused |
| PHP file placed in the uploads folder | Does not run |
| `application`, `system`, `database`, `docs`, `.htaccess` | Blocked |
| Admin pages when signed out | Redirect to login |
| A role reaching another module, including by direct POST | Refused (403) |
| Five failed logins | Locked for 15 minutes |
| Password change or disabled account | Other sessions end |

## Problems found and fixed during testing

| Problem | Fix |
|---|---|
| Portfolio gallery collapsed because of lazy-loaded images | Lazy loading removed from that gallery |
| Renamed or deleted content gave 404 instead of 301 or 410 | Redirect check moved into the shared 404 path |
| Sixth blog post had an invalid date | Seed date corrected |
| Admin "no encryption" for SMTP was overridden by `.env` | Admin SMTP settings now apply as one set |
| Logged email errors did not explain the failure | The log now records the actual error line |
| Setup command rejected an email address argument | `@` allowed in the URL filter |
| Article navigation overlapped, share icons were invisible, text was too dark in dark mode | Styles corrected |

The final dark mode colour fix came after the last automated run. It only adds CSS for new components, and the site was smoke-tested afterwards.

## Not tested

| Item | Why it matters | When to do it |
|---|---|---|
| Delivery through a real email provider | Tests used a local test mail server. Provider login, TLS and spam filtering are untested | After entering SMTP details, press **Send test email** |
| Live server and HTTPS | Secure cookies and the HTTPS redirects are off locally | At deployment |
| Safari, Firefox, real phones | Only Chrome was used | Before launch |
| Core Web Vitals and PageSpeed scores | Not measured; they depend on the live server | After deployment |
| Google Rich Results Test | Structured data was checked as valid JSON with the right types, not by Google's tool | After deployment |
| Admin dashboard in dark mode | The admin panel is light only | Not planned |

A Content Security Policy header is not set, because the original template relies on inline event handlers.

# Final Testing Report

**Date:** 7 November 2026
**Build:** the local copy, after the SEO, login redesign, social link and content work (database migration 16)
**Live site:** nothing ran against `https://girzock.com`, and nothing has been deployed

## Result

| | Passed | Failed |
|---|---:|---:|
| Isolated test copy | 3,249 | 0 |
| Real local site, read-only | 6,123 | 11 |
| **Total** | **9,372** | **11** |

**The 11 failures** are all the same Firefox measurement: the "Technologies to ABOUT" gap. Firefox reports 0 height for text inside an SVG mask, so the test reads 49 to 91 px. A pixel measurement found 24 to 33 px, within the target. The same check passes in Chromium and WebKit. No functional failure remains.

**Not in the totals:**
- the fresh-install checks (install SQL migrates to version 16; a second run changes nothing);
- 5 timed form submissions (median 46 ms; all saved; both emails sent);
- the heading-style comparison (1,176 headings, 0 differences).

**How the tests were kept safe:**
- **Isolated copy:**
  - its own database (`girzock_test`), server (port 8096), private folder and test keys;
  - a local mail catcher on port 2525;
  - a test admin password.
  - Every form submission, sign-in, upload and settings change happened there.
- **Real local site:** GET requests only.

**Real data before and after, unchanged:**
- 2 enquiries (your own); 0 applications; 1 admin account;
- the same admin, SMTP and `.env` checksums;
- no PHP errors logged today;
- 12 test uploads removed from the test copy; no test ports left open.

## Isolated copy

| Suite | Covers | Passed | Failed |
|---|---|---:|---:|
| Final content | Text, links and structure of content pages | 812 | 0 |
| Public site | Pages, forms, CSRF, honeypot, duplicates, emails, escaping | 107 | 0 |
| Admin | Sign in, lockout, password reset, roles, CRUD, enquiries, resend | 291 | 0 |
| SEO and delete | 89-URL crawl, metadata, schema, sitemap, drafts, preview, delete | 183 | 0 |
| Browser | Homepage behaviour, enquiry form, gallery, mobile, search | 53 | 0 |
| Uploads | Image checks, conversion, limits, scripts blocked | 77 | 0 |
| Forms and email | All four enquiry forms, both emails, failures logged | 108 | 0 |
| Mega menu | All widths | 234 | 0 |
| Dropdown | Service dropdown, three browsers, keyboard and touch | 202 | 0 |
| Favicon | Favicon priority | 22 | 0 |
| Popup admin | Settings, validation, images, reset, migration re-run | 149 | 0 |
| Popup in the browser | Reappearance rules, layout at 6 laptop sizes, form, toast | 438 | 0 |
| Email retry | Cut-off sends retried; sent emails never repeated | 6 | 0 |
| Social links admin | Four URL fields, address checks, settings untouched | 90 | 0 |
| Social links appearance | Four icons alike, three browsers, four sizes | 307 | 0 |
| **Admin login (new)** | Redesign, eye toggle, validation, CSRF, session, sign out, expiry, rate limit, recovery, three browsers at desktop, tablet and phone size | **170** | **0** |

After migration 016, a fresh install at version 16 passed the public (107), admin (291), SEO (183) and popup admin (149) suites again.

## Real local site, read-only

| Suite | Covers | Passed | Failed |
|---|---|---:|---:|
| Footer social links | 23 page types, three browsers, desktop, tablet and phone, four icons, real clicks | 990 | 0 |
| Final content | As above, on the real data | 812 | 0 |
| SEO | Metadata and schema on every page | 141 | 0 |
| Contact panel | | 10 | 0 |
| Mega menu | | 234 | 0 |
| Where We Work orbit | | 113 | 0 |
| Tabs | | 766 | 0 |
| Effects | Outline text and header button, three browsers | 378 | 0 |
| About and footer text | Outline text position | 1,281 | 11 |
| Preloader, About, icons | | 762 | 0 |
| WhatsApp button | | 438 | 0 |
| Form fields | 48 fields readable, 0 too faint | 48 | 0 |
| Real popup | Live popup settings | 150 | 0 |

Two further read-only checks:
- **Crawl:** 89 URLs, all HTTP 200, 0 duplicate titles or descriptions, 0 broken links.
- **Lighthouse:** see `TECHNICAL_SEO_REPORT.md`.

## Problems found during testing, and what was done

| Found | Cause | Action |
|---|---|---|
| Eye toggle: Enter, then Space, typed a space into the password (login test) | **Real fault in the new script:** it moved focus into the field after toggling | Fixed. Focus stays on the button. All 170 login checks pass |
| Footer: the fourth social icon wrapped to a second line at 320 px | **Real layout issue:** four icons need 212 px; the column is 196 px | Fixed for screens under 360 px only (40 px icons, 8 px gaps). Wider screens unchanged |
| Login loading-state check could not read the page | **Test method:** the page had already navigated | The state is now recorded at the moment of sending. Passes |
| Retry test counted 2 emails | **Test assumption:** earlier suites leave failed emails that the job also retries, correctly | The test now counts only its own customer's email. Passes |
| Popup admin migration check expected version 13 | **Test fixed to a number** | Now reads the version from the config. Passes |
| Admin suite failures when run without the public suite | **Test order:** the admin suite uses enquiries the public suite creates | Rerun in order: 0 failures |

## Homepage comparison

The homepage was compared section by section, at all widths in light and dark mode, with the 18:48 capture taken before this pass's SEO work. Results: 352 sections compared, 0 images changed, 0 console errors or failed requests.

The only height change was the footer at 320 px (+56 px), caused by the icon wrap now fixed. The hero text compared as different, but the words are identical; the difference is the counter animation. The approved homepage design is unchanged.

## Not tested

- **Anything on the live server:** HTTPS, compression, production email and the production headers.
- **The Facebook profile:** it blocks automated checks.
- **Password manager save prompts:** these depend on each browser's settings. The form uses the standard attributes they look for.
- **Real iPhone and Android devices:** WebKit and Chromium device emulation stood in.
- **Google's Rich Results Test and Search Console:** they need the public site.

# Final Regression Test Report

**Date:** 7 November 2026
**Build:** the local copy at `E:\Girzock Technologies\girzock website\girzock-website`, after the form speed, popup reappearance, social links and SEO changes
**Live site:** nothing ran against `https://girzock.com`, and nothing has been deployed

## Result

| | Checks passed | Checks failed |
|---|---:|---:|
| Isolated test copy | 3,080 | 0 |
| Real local site, read-only | 5,908 | 11 |
| **Total** | **8,988** | **11** |

The 11 failures are all one Firefox measurement, explained below. No functional failure remains.

The fresh-install check (2) and the timed form submissions (5 of 5) are listed in the table below but are not included in these totals. The heading-style comparison reports differences, not pass/fail checks.

**How the tests were kept safe:**
- **Isolated copy:**
  - its own database, `girzock_test`, built fresh from the install SQL and migrated to version 13;
  - PHP's built-in server on port 8096, with test keys in a separate private folder;
  - a local mail catcher on port 2525.
  - Every enquiry, upload, setting change and password reset happened only there.
- **Real local site:** GET requests only. Nothing was submitted and nobody signed in.

**Before and after, real data unchanged:**
- migration version 13;
- 2 enquiries (your own GZ-ENQ-2026-00007 and 00008);
- 0 job applications;
- 1 admin account, with the same password hash checksum;
- the same SMTP settings checksum and the same `.env` checksum;
- LinkedIn and Facebook still empty;
- no PHP errors logged today;
- no test uploads left behind;
- both test ports closed at the end.

## Isolated test copy

| Suite | What it covers | Passed | Failed |
|---|---|---:|---:|
| Fresh install | Install SQL then migrations: version 1 to 13. A second run changes nothing | 2 | 0 |
| Final content (`t8_final.php`) | Text, links and structure of every content page | 813 | 0 |
| Public site (`t1_public.php`) | Pages, forms, CSRF, honeypot, duplicates, emails, escaping, headers | 107 | 0 |
| Admin (`t2_admin.php`) | Sign-in, lockout, password reset, roles, CRUD, enquiries, email retry from the admin | 291 | 0 |
| SEO and delete (`t4_seo.php`) | Crawl of 89 URLs, metadata, schema, sitemap, drafts, preview, delete | 183 | 0 |
| Browser (`t3_browser.js`) | Homepage behaviour, the enquiry form through the real page, gallery, mobile, search | 53 | 0 |
| Uploads (`t15_upload.php`) | Image upload checks, conversion, limits, PHP blocked | 77 | 0 |
| Forms and email (`t29_forms.php`) | All four enquiry forms, both emails, failures logged, double submit | 108 | 0 |
| Mega menu (`t16_mega.js`) | Menu at all widths | 234 | 0 |
| Heading styles (`t9_headings.js`) | 1,176 headings compared, 0 differences | counted as 0 differences | — |
| Dropdown (`t37_dropdown.js`) | Service dropdown in three browsers, keyboard and touch | 202 | 0 |
| Favicon (`t47_favicon.php`) | Favicon priority | 22 | 0 |
| Popup admin (`t53_popup_admin.php`) | Settings, validation, images, toggle, reset, visitor reset, migration re-run | 149 | 0 |
| Popup in the browser (`t52_popup.js`) | All reappearance rules, layout at 6 laptop sizes, form, toast, keyboard | 438 | 0 |
| Email retry (`t63_retry.php`) | The retry job re-sends a send cut off 20 minutes ago, leaves one in progress alone, and never re-sends a sent email | 6 | 0 |
| Social links admin (`t61_social_admin.php`) | LinkedIn and Facebook fields, the URL checks, other settings untouched, icons on 20 page types | 90 | 0 |
| Social links appearance (`t62_social_visual.js`) | Four icons alike at 4 screen sizes in 3 browsers, hover, clicks, new tab | 307 | 0 |
| Form speed (`t59_speed.php`) | 5 timed submissions with a mail server that takes 3 s per email: median 43 ms; all saved; both emails sent | 5 of 5 | 0 |

## Real local site, read-only

| Suite | What it covers | Passed | Failed |
|---|---|---:|---:|
| Final content (`t8_final.php`) | As above, on the real data | 813 | 0 |
| SEO (`t4_seo.php`, read-only mode) | Metadata and schema on every page | 141 | 0 |
| Panel (`t7_panel.js`) | Contact panel | 10 | 0 |
| Mega menu | As above | 234 | 0 |
| Where We Work orbit (`t27_orbit.js`) | Animation and layout | 113 | 0 |
| Tabs (`t38_tabs.js`) | Tab heights and behaviour | 766 | 0 |
| Effects (`t40_effects.js`) | Outline text and the header button in three browsers | 378 | 0 |
| About and footer text (`t43_flow.js`) | Outline text position and spacing | 1,281 | 11 |
| Preloader, About, icons (`t46_pre.js`) | Loading screen and icons | 762 | 0 |
| WhatsApp button (`t48_whatsapp.js`) | Visibility by width, shake | 438 | 0 |
| Form fields (`t35_fields.js`) | Readable text in 48 fields, 0 too faint | 48 | 0 |
| Real popup (`t55_real_popup.js`) | The live popup settings on the real data | 150 | 0 |
| Footer social links (`t60_social.js`) | 23 page types, three browsers, desktop, tablet and phone, real clicks | 774 | 0 |

Two read-only checks are reported separately:
- **Crawl:** 89 URLs, all HTTP 200.
- **Homepage comparison:** 276 sections compared by name at 6 widths, light and dark. See below.

## The 11 failures

All 11 are in Firefox, in the check "gap from 'Technologies' to ABOUT is 24 to 32 px". Firefox reported 49 to 91 px.

**The cause is the test method, not the page.** The test reads the text's height inside an SVG mask, and Firefox reports 0 for it. A separate pixel measurement, made earlier in this project, found the real gap is 33, 32 and 24 px in Firefox and 33, 31 and 25 px in Chrome. The same check passes in Chromium and WebKit. The failures are kept in the count because the test did report them.

## Failures found during this work, and what was done

| Found | Cause | Action |
|---|---|---|
| Email checks failed in the public, admin and forms suites (13 checks) | **Tests, not the site.** Emails are now sent after the reply, and the tests read the mail log at once | Tests now wait up to 15 s for the email results. All pass |
| Popup form had a 44 to 102 px scrollbar at every laptop size (18 checks) | **Real fault.** The closed, invisible service list took up space below the field | Fixed in `girzock.css`: in the popup the closed list is removed from the layout. Now no scroll at any size |
| Popup reappearance checks (3) | **Test setting.** The admin suite had raised the visitor reset number | The browser suite now sets it first |
| Popup toast "not in view" in Firefox and WebKit (2) | **Test timing.** Measured during the 0.3 s slide-in | The test waits for the slide to finish |
| Effects and flow tests could not find `#commitment` | **Your edit at 17:53:** you removed the "Our Commitment" section from `home/index.php` | Your edit is kept. The tests now check the footer outline text, and expect 2 outline texts instead of 3 |
| Saving Settings changed `smtp_crypto` from None to TLS on the test copy (2 checks) | **Test fault.** The test's form reader skipped an empty selected value | Test fixed. The admin form itself was correct, and your real setting is TLS |
| The first clean run was invalid | **My mistake.** I started the suite without the mail catcher, and the earlier run kept running after I stopped it | Every leftover process was stopped and 6 stray test images (196 bytes each, unused) were removed. The run was then repeated cleanly |

## Homepage comparison

The 18:48 homepage was compared with a capture from 16:18 today, section by section at 425 to 1920 px, light and dark. No image changed, and there were no console errors or failed requests.

| Section | Change | Reason |
|---|---|---|
| Our Commitment (`#commitment`) | Gone | Your edit at 17:53 |
| About (`#about-girzock`) | −83 to +58 px | The paragraph now names the districts (content brief, migration 012) |
| Footer | +24 px at 768 px only | The Privacy, Terms and Cookies links |
| Custom software (`#custom-software-solutions`) | −25 to −52 px | **Not explained.** Its markup, text, images, CSS and scripts are unchanged since 16:25, and fonts were ruled out by blocking them. The tab layout suite passes. The 16:18 capture may have caught its animated heading mid-animation. Look at this section once in the browser |

## Lighthouse, mobile, local server

| Page | Performance | SEO | Accessibility | Best practices | LCP | CLS |
|---|---:|---:|---:|---:|---:|---:|
| `/` | 42 | 100 | 97 | 93 | 17.7 s | 0.000 |
| `/about` | 59 (median of 3: 20, 59, 59) | 100 | 97 | 96 | 17.3 s | 0.003 (the first run measured 0.618) |
| `/services` | 59 | 100 | 95 | 100 | 17.3 s | 0.000 |
| `/services/website-development` | 60 | 100 | 100 | 100 | 16.5 s | 0.000 |
| `/areas-we-serve` | 60 | 100 | 100 | 100 | 16.2 s | 0.000 |
| `/blog` | 60 | 100 | 100 | 100 | 17.4 s | 0.000 |
| a blog post | 60 | 100 | 100 | 100 | 16.7 s | 0.000 |
| `/contact` | 56 | 100 | 100 | 100 | 16.9 s | 0.003 |
| `/products/customer-portal` | 56 | 100 | 100 | 96 | 16.4 s | 0.000 |
| `/careers/web-developer` | 56 | 100 | 96 | 100 | 16.2 s | 0.000 |
| `/privacy-policy` | 56 | 100 | 100 | 100 | 15.5 s | 0.000 |

These are local results without compression, under simulated slow mobile conditions. They are not production numbers.

## Not tested

- **Anything on the live server:** HTTPS, the production headers and production email.
- **Real Safari and real phones:** WebKit and device emulation stood in.
- **The LinkedIn and Facebook profiles themselves:** no address exists yet.
- **Google's Rich Results Test and Search Console:** they need the public site.
- **External security scans.**

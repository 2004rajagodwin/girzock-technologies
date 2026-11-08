# Footer and Social Links Report

**Date:** 7 November 2026
**Supersedes:** `FOOTER_SOCIAL_LINK_AUDIT.md`, which covers the earlier pass when only two icons were live

## Social links: all four live

| Platform | Address | Source | Checked |
|---|---|---|---|
| LinkedIn | https://www.linkedin.com/company/girzock-technologies/ | You, in this brief | **Confirmed:** the page opens and its title is "Girzock Technologies \| LinkedIn" |
| Facebook | https://www.facebook.com/profile.php?id=61596044820156 | You, in this brief | **Not confirmed automatically.** Facebook refuses automated checks (HTTP 400 to a script). Open it once in a browser and confirm it is your page |
| Instagram | https://www.instagram.com/girzocktechnologies/ | Already configured | Already live |
| WhatsApp | https://wa.me/916379362330 | Already configured | Already live |

**How they were saved:**
- The LinkedIn and Facebook addresses went into the existing **Admin → Website Settings → Social links** records, after a database backup.
- Both passed the same address check the admin form uses.
- No other social address was added or changed.

**Order in the footer:** LinkedIn, Facebook, Instagram, WhatsApp, using the existing icon style:
- 44 px round outline icons, with the homepage hover effect;
- 40 px with tighter spacing only on phones under 360 px wide, so all four stay on one row.

**Every link has:**
- `target="_blank"` and `rel="noopener noreferrer"`;
- an accessible name, for example "GIRZOCK Technologies on LinkedIn (opens in a new tab)";
- a tooltip.

**Structured data:** the Organization `sameAs` lists LinkedIn, Facebook and Instagram. WhatsApp is left out, because it is a chat link, not a profile.

## Admin: Website Settings → Social links

**Fields:** LinkedIn URL, Facebook URL, Instagram URL and WhatsApp URL, each with an example address.

**What is accepted:**
- `https://` only;
- the platform's own domain only:
  - LinkedIn: linkedin.com and its country subdomains;
  - Facebook: facebook.com, m.facebook.com, fb.com;
  - Instagram: instagram.com;
  - WhatsApp: wa.me, api.whatsapp.com, whatsapp.com;
- a profile path, not just the home page;
- no login details or port in the address.

**What is refused, with a clear message:** `javascript:`, `data:`, plain `http:`, other websites and look-alike domains.

**Saving:** an empty field hides that icon. Saving the form leaves every other setting unchanged.

**Safety net:** the footer and structured data check each address again when the page is drawn, so an unsafe value that reached the database another way is never shown.

## Tagline and footer

- **Tagline:** the only tagline in the code and database is **"Technology. Growth. Elevate."**, stored as the `tagline` setting. A search of all code and the full database export found no "Develop. Expand. Transform.", "Technology. Growth. Beyond." or any other variant.
- **One footer:** every public page uses the homepage footer component (`partials/footer_home.php`). Inner pages load it through `footer_inner.php`, which only closes the page wrapper first. There is no separate footer for the legal pages.

## Tests

| Test | Where | Coverage | Result |
|---|---|---|---|
| `t60_social.js` | Local real site, GET only | 23 page types, including privacy, terms, cookies, a service, a product, a portfolio item, a case study, a post, a category, a tag, a job and the 404 page, in Chromium. Home and the legal pages in Firefox and WebKit. Desktop 1366×768, tablet 820×1180, phone 390×844. Checks the four icons in order, attributes, labels, icon size, tagline, and real clicks opening each profile in a new tab with no opener | **990 passed, 0 failed** |
| `t61_social_admin.php` | Isolated copy | Admin fields; 9 unsafe or wrong addresses refused; valid save; other settings untouched; icons on 20 page types; `sameAs`; unsafe stored value never drawn; emptying hides the icons | **90 passed, 0 failed** |
| `t62_social_visual.js` | Isolated copy | The four icons look and behave alike at 1440, 1024, 820 and 390 px in three browsers: same computed size, border, radius and hover; one row; at least 24 px touch targets; clicks near the edge open the profile | **307 passed, 0 failed** |
| Narrow phones | Local real site | At 320 px the fourth icon used to wrap to a second row; it now fits on one row. 360, 375 and 390 px are unchanged | Measured |

In every click test, requests to LinkedIn, Facebook, Instagram and WhatsApp were answered locally by the test, so nothing was sent to those services.

## Files changed in this pass

| File | Change |
|---|---|
| Database `social_links` (local) | LinkedIn and Facebook addresses saved |
| `assets/css/girzock.css` and `girzock.min.css` | Four icons on one row under 360 px |
| `application/libraries/Seo.php` | `sameAs` now includes LinkedIn and Facebook (automatic, from the checked list) |

The admin fields, address checks and footer markup were built in the previous pass. See `FOOTER_SOCIAL_LINK_AUDIT.md`.

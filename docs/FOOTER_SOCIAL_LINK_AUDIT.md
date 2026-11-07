# Footer Social Link Audit

**Date:** 7 November 2026
**Scope:** the social icons in the footer of every public page, and their settings in **Admin → Website Settings → Social links**

## Summary

| Platform | Address on record | Shown in the footer | Tested |
|---|---|---|---|
| LinkedIn | none yet | Hidden until you save the address | The full path, tested on the isolated copy with a test-only address |
| Facebook | none yet | Hidden until you save the address | The full path, tested on the isolated copy with a test-only address |
| Instagram | https://www.instagram.com/girzocktechnologies/ | Yes | Clicked on desktop, tablet and mobile in Chromium, Firefox and WebKit |
| WhatsApp | https://wa.me/916379362330 | Yes | Clicked on desktop, tablet and mobile in Chromium, Firefox and WebKit |

**No LinkedIn or Facebook address was invented.**

LinkedIn and Facebook are fully set up: their fields, checks, icons and markup all work. Each stays hidden until you paste your official company page address. The icon then appears in the footer of every page at once; no page files need editing.

## How to add LinkedIn and Facebook

1. Sign in to the admin and open **Website Settings**.
2. In **Social links**, paste the addresses into **LinkedIn URL** and **Facebook URL**, for example `https://www.linkedin.com/company/your-page` and `https://www.facebook.com/your-page`.
3. Click **Save settings**.
4. Open any page and check the footer. There are four icons, in the order LinkedIn, Facebook, Instagram, WhatsApp.

To remove an icon, empty its field and save.

## What the settings accept

An address is saved only if all of these are true:
- it starts with `https://`;
- it is on that platform's own domain:

  | Platform | Allowed domains |
  |---|---|
  | LinkedIn | `linkedin.com`, `www.linkedin.com`, or a country subdomain such as `in.linkedin.com` |
  | Facebook | `facebook.com`, `www.facebook.com`, `m.facebook.com`, `fb.com` |
  | Instagram | `instagram.com`, `www.instagram.com` |
  | WhatsApp | `wa.me`, `api.whatsapp.com`, `chat.whatsapp.com`, `whatsapp.com` |

- it points to a page, not just the site's home page;
- it has no user name, password or port in it;
- it is 255 characters or fewer.

Anything else is refused with a message that names the platform and shows an example, and nothing is saved. That includes `javascript:`, `data:`, `ftp:`, plain `http:`, other websites, look-alike domains such as `linkedin.com.evil.example`, and addresses without `https://`. Spaces before or after the address are removed.

The same check runs again whenever a page is drawn. If an unsafe value ever reached the database some other way, its icon is simply not shown. The Organization structured data (`sameAs`) uses the same checked list, without WhatsApp.

## What every visible link has

| Requirement | How it is met |
|---|---|
| Same look as the existing icons | The same markup and classes for all four, so size, border, radius, colours and hover come from the existing footer styles |
| Whole icon clickable | The link is the icon itself. Clicks near its edge were tested |
| Opens in a new tab | `target="_blank"` |
| Protects the site tab | `rel="noopener noreferrer"`. The new tab has no `window.opener` |
| Accessible name | `aria-label="GIRZOCK Technologies on LinkedIn (opens in a new tab)"`, and the same pattern for each platform. The icon itself is `aria-hidden` |
| Tooltip | `title` set to the platform name |
| No empty or `#` links | An icon appears only with a valid address |

## Same footer on every page

Every public page uses the homepage footer, with the tagline **"Technology. Growth. Elevate."**, the same social icons and the Privacy | Terms | Cookies links.

## Test results

| Test | Where | Browsers and screens | Result |
|---|---|---|---|
| `t60_social.js`: footer markup, tagline and real clicks with the current two icons | Local real site, GET only. 23 page types in Chromium (home, About, Services, a service, Products, a product, Portfolio, a portfolio item, Case studies, a case study, Blog, a post, a category, a tag, Careers, a job, Contact, Areas We Serve, Privacy, Terms, Cookies, the 404 page). Home and the three legal pages in Firefox and WebKit | Chromium, Firefox, WebKit; desktop 1366×768, tablet 820×1180, phone 390×844 | **774 passed, 0 failed** |
| `t61_social_admin.php`: the admin fields and checks | Isolated copy | Signed-in admin over HTTP. Nine unsafe or wrong addresses refused; a valid save; the other settings untouched; four icons in order on 20 page types; `sameAs` markup; an unsafe stored value never drawn; emptying the fields hides the icons | **90 passed, 0 failed** |
| `t62_social_visual.js`: four icons, look and fit | Isolated copy, with test-only LinkedIn and Facebook addresses | Chromium, Firefox, WebKit at 1440×900, 1024×768, 820×1180 and 390×844. LinkedIn and Facebook have the same computed size, border, radius, colours and layout as Instagram and WhatsApp; one evenly spaced row; at least 24 px; no sideways scroll; the same hover style; a click near the icon's edge opens the profile in a new tab with no opener | **307 passed, 0 failed** |

In every click test, requests to Instagram, WhatsApp, LinkedIn and Facebook were answered locally by the test. Nothing was sent to those services, and no WhatsApp chat was started.

The test addresses were used only in the isolated test database and were removed at the end. The real database still has no LinkedIn or Facebook address.

The tests prove the links are correct and open properly. They cannot prove the profiles are live, because the profiles were not contacted. After you add LinkedIn and Facebook, open all four once from a phone.

## Files changed

| File | Change |
|---|---|
| `application/helpers/girzock_helper.php` | New `valid_social_url()`: https only, the platform's own domain, a profile path, no credentials |
| `application/models/Settings_model.php` | New `public_socials()`, returning only valid profiles; `social_url()` uses it |
| `application/views/frontend/partials/social_icons.php` | Draws only valid profiles, with new-tab attributes and labels |
| `application/libraries/Seo.php` | Organization `sameAs` uses the checked list |
| `application/controllers/admin/Settings.php` | Validates each field with the platform check, with a clear error and an example |
| `application/views/admin/settings/index.php` | Section renamed **Social links**; fields labelled "LinkedIn URL", "Facebook URL", "Instagram URL" and "WhatsApp URL", each with an example address |
| `assets/js/girzock.js` | An old unused block that filled in "coming soon" icons was removed. No view uses `data-social` any more; this was checked before removing it |

No database change was needed. The four platforms already existed in the `social_links` table.

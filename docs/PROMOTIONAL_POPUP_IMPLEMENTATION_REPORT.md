# Promotional Popup: Implementation Report

Date: 7 November 2026. Scope: the local build. Nothing has been deployed.

## What visitors see
- **Desktop and tablet (768 px and wider):** two columns. The banner `assets/images/popup/diwalipopup-left-desktop.webp` (1024 x 1536) is on the left, at its own shape, and the enquiry form is on the right.
- **Mobile (under 768 px):** the banner `assets/images/popup/diwalipopup-mobile.webp` (1199 x 1312) sits on top, with the form below. The popup scrolls inside itself, and the close button stays visible.
- **Behaviour:**
  - It opens a set number of seconds after the page opened; the default is 5.
  - It closes with the close button, the Escape key, or a click outside it.
  - The page behind it cannot scroll while it is open.
  - It has a fade and scale animation. With reduced motion turned on, it simply appears.
- **Images:** only one image is downloaded, the one for the current screen size, about 1.5 s before opening. Neither image is in the page HTML, so the page's own loading is not affected. A missing or failed image leaves a form-only popup, with no broken image.
- **Light in both themes:** the popup keeps its light design even when the site is in dark mode.

## The form
It is the existing homepage enquiry form, loaded a second time with its own field ids. It uses the same validation, CSRF token, honeypot, duplicate check and rate limit. It posts to the same `contact/submit`, saves to `contact_enquiries`, and sends the same company and client emails. The source is recorded as `popup/<page>`. No new enquiry system or table was created.

## Admin: Promotional Popup
Sidebar > Promotional Popup (`/admin/popup`). It is in the role permission matrix; only Super Admin has it by default.

| Control | Detail |
|---|---|
| Enable popup | On/off; also a one-click Turn on/off button |
| Title, description | Title up to 120 characters; its last word is shown in blue |
| Image description | Alt text read by screen readers |
| Display delay | 0 to 120 seconds, default 5 |
| Start and end date | Optional; the end date is inclusive |
| When it may appear again | Replaced on 7 November 2026: after a set number of days (default 7 after closing, 30 after sending the form), never again once closed, once per session, or every page load, plus "Reset visitor dismissals". See `POPUP_DISMISSAL_SETTINGS_REPORT.md` |
| Desktop / mobile visibility | Separate switches |
| Desktop and mobile images | Preview, dimensions, file size, path, upload or replace, and delete |
| Preview | Desktop (1280 px) or mobile (390 px) preview in a frame. It works while the popup is off and is visible only to the signed-in admin |
| Reset to default settings | Restores the settings and supplied images. Uploads stay in the Media Library |

**Uploads:**
- Accepted: WebP, PNG or JPG, up to 5 MB, 300 to 6000 px on each side.
- The type is read from the file's content, the extension must match it, and animated images are refused.
- The file is stored **byte for byte, without recompression**, under a random name in `assets/uploads/YYYY/MM/`. Scripts never run from that folder.

**Deleting:**
- Every delete asks for confirmation, and the server also requires a confirmation field.
- An uploaded file is removed only when no setting still uses it.
- The supplied default images are never deleted from disk; deleting one only removes it from the popup.

## Database
Migration `011_promotional_popup` adds 12 `popup_*` keys to the existing `website_settings` table. It uses `INSERT IGNORE`, so a re-run never overwrites saved values. It was applied to the real database on 7 November 2026, after a backup. The other 30 settings were confirmed unchanged by checksum. No new table was created.

## Files
- **New:**
  - `application/controllers/admin/Popup.php`
  - `application/views/admin/popup/index.php`
  - `application/views/frontend/partials/promo_popup.php`
  - `application/migrations/011_promotional_popup.php`
- **Changed:**
  - `Settings_model.php`: `popup_defaults()`, `popup()`
  - `Media_manager.php`: `store_original_image()`
  - `MY_Controller.php`: `popup_state()`
  - `layouts/main.php`
  - `partials/enquiry_form.php`: options for a second copy
  - `admin/layouts/main.php`
  - `config/girzock.php`
  - `config/migration.php`
  - `girzock.js`
  - `main.js`: exposes the smooth-scroll instance so it can pause
  - `girzock.css`
  - `admin/js/admin.js`: confirmation read from the clicked button

## Test results
| Suite | Where | Result |
|---|---|---|
| Popup admin (settings, validation, uploads, attack files, delete, reset, toggle, dates, preview, permissions, CSRF, migration re-run) | Isolated copy | 135 passed, 0 failed |
| Popup browser (timing, images per screen size, closing, scroll lock, focus, frequency, switches, missing image, reduced motion, dark theme, validation, real submission with both emails, admin preview, delete confirmation) | Isolated copy, Chrome, Firefox, WebKit | 314 passed, 1 failed |
| Popup on the real site, read-only | Real local site, three engines | 150 passed, 0 failed |

The single failure was external: WebKit logged "Could not resolve hostname" when the PC briefly lost DNS for Google Fonts.

Measured opening times: 5,155 to 5,509 ms with a 5 s delay. A 10 s delay opened at 10 s.

**Real email:** an enquiry you sent through the popup on 7 November 2026 at 16:06 produced both emails. The company notification and the client confirmation were accepted by your SMTP server. Inbox arrival is for you to confirm.

## Your decisions
- **End date:** the popup is on with no end date. Set one so the offer does not run on after Diwali.
- **Offer wording:** the "20% off" wording is in the image. Your Terms page says offers apply on the terms stated with them.
- **"Book Free Demo":** it is part of the image, not a button, so clicking it does nothing.

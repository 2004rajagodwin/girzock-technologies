# Popup Reappearance Settings

**Date:** 7 November 2026
**Applies to:** the promotional popup on the public website and its settings page at **Admin → Promotional Popup**

## What changed

Before this change the admin could pick only "once per session", "once per day" or "every visit". A visitor who closed the popup still saw it again on the next visit.

You can now choose when the popup may appear again, and for how long it stays hidden after a visitor closes it or sends the form. The settings are on the same admin page. No source code edits are needed.

## Settings on the admin page

| Setting | Choices | Default | What it does |
|---|---|---|---|
| When it may appear again | After a set number of days (recommended); Never again once the visitor closes it; Once per browser session; On every page load | After a set number of days | Decides when a visitor who has already seen the popup sees it again |
| Days hidden after the visitor closes it | 1 to 365 | 7 | Used by "After a set number of days" |
| Days hidden after the visitor sends the form | 1 to 365 | 30 | Applies to every choice above. A visitor who has already sent an enquiry is not asked again |
| Reset visitor dismissals (button) | — | — | Every visitor who closed the popup or sent the form sees it again, following the rules above. It asks for confirmation first |
| Turn on / Turn off (button) | — | On | Off hides the popup for everyone, whatever any browser has stored |

The existing settings are unchanged:
- start and end date;
- desktop and mobile switches;
- delay;
- images;
- title;
- description;
- preview.

## How each choice behaves

| Choice | First visit | Closed, then refreshed | Same browser session, next page | New session, within the days limit | New session, after the days limit |
|---|---|---|---|---|---|
| After a set number of days | Shows | Hidden | Hidden | Hidden | Shows |
| Never again once closed | Shows | Hidden | Hidden | Hidden | Hidden, until an admin reset |
| Once per browser session | Shows | Hidden | Hidden | Shows | Shows |
| On every page load | Shows | Shows | Shows | Shows | Shows |

These rules apply to all four choices:
- **After a successful form submission,** the popup stays hidden for the "Days hidden after the visitor sends the form" value under every choice, including "On every page load".
- **"Turn off" always wins.** The popup is not even rendered in the page.
- **Turning it back on does not clear what browsers remember.** Use **Reset visitor dismissals** to show it to everyone again.
- **The start and end dates and the desktop and mobile switches still apply** on top of these rules.

## What the browser stores

Only dates are stored, no personal details:

| Name | Type | Content | Lifetime |
|---|---|---|---|
| `gzPopup` | localStorage | `{"v":"<reset number>","closed":<time>,"submitted":<time>}` | Until the visitor clears site data |
| `gzPopupSession` | sessionStorage | The reset number | Until the tab is closed |

**Reset visitor dismissals** raises the reset number, which is the `popup_visitor_version` setting. Browsers ignore any stored record with an older number. This is how a reset reaches every visitor without contacting their browsers.

The Cookie Policy (`/cookie-policy`) now lists both names. They replace `gzPopupSeen`, which is no longer used.

## Files changed

- `application/migrations/013_popup_reappearance.php` (new). It adds four settings with `INSERT IGNORE`, so a re-run never overwrites saved values:
  - `popup_reappear` = `days`
  - `popup_dismiss_days` = `7`
  - `popup_submit_days` = `30`
  - `popup_visitor_version` = `1`
- `application/config/migration.php`: the migration version is now 13.
- `application/models/Settings_model.php`: the new defaults, and the values passed to the page.
- `application/controllers/admin/Popup.php`:
  - checks the new fields: the choice must be one of the four, and the days must be whole numbers from 1 to 365;
  - adds the new `reset_visitors()` action;
  - "Reset to default settings" keeps the reset number, so it does not show the popup again to everyone by accident.
- `application/views/admin/popup/index.php`: the new fields and the reset button.
- `application/views/frontend/partials/promo_popup.php`: passes the rules to the page as data attributes.
- `assets/js/girzock.js` and `girzock.min.js`: the rules above.
- `application/views/frontend/legal/page.php`: Cookie Policy table.
- `assets/css/girzock.css` and `girzock.min.css`: fixed message box, button spacing, and the closed service list removed from the popup layout.

The local database has run migration 013. A backup was taken first, in `../backups/`.

## Message box and layout in the popup

| Item | Result |
|---|---|
| Message label and placeholder | "Tell us about your project requirements (optional)" |
| Message required? | No, in the popup only. The Contact page form still requires it |
| Message box height | Fixed at 96 px (84 px on phones), `resize: none`. Long text scrolls inside the box |
| Company placeholder | Shortened to "Company name (optional)", so it is no longer cut off |
| Space above the submit button | Increased; at least 18 px measured at every laptop size below |

## Test results

These tests ran on the isolated test copy, which has its own database, server and mail catcher, in Chromium, Firefox and WebKit.

| Suite | Final result |
|---|---|
| Popup in the browser (`t52_popup.js`) | **438 passed, 0 failed** |
| Popup admin (`t53_popup_admin.php`) | **149 passed, 0 failed** |
| Real local site, read-only (`t55_real_popup.js`) | **150 passed, 0 failed** |

The first full run found 23 failures, and each was resolved:

1. **18 were a real fault:** the form had a 44 to 102 px scrollbar at every laptop size.
   - **Cause:** measured in a browser. The closed service list was invisible but still took up space below the field, so the form scrolled. Without it, the form ends well inside the 646 px dialog.
   - **Fix:** in the popup only, the closed list is now removed from the layout (`display: none` until it opens). The list opens up or down from the field's position, so its behaviour is unchanged.
   - **After the fix,** the scroll height equals the visible height at every size listed below.
2. **3 were a test setting:** the admin suite had already raised the reset number, so the browser suite now starts from a known value.
3. **2 were test timing:** in Firefox and WebKit the toast was measured during its 0.3 s slide-in. The test now waits for the slide to finish.

The full counts are in `FINAL_REGRESSION_TEST_REPORT.md`.

| Checked | Result |
|---|---|
| "After N days" (7): hidden after closing and refreshing; hidden after 6 days; shows again after 8 days | Passed |
| Sent the form 20 days ago (limit 30): hidden. 31 days ago: shows | Passed |
| "Never again once closed": not shown again, even in a new tab | Passed |
| "Once per session": hidden for the rest of the session; a new session shows it | Passed |
| "On every page load": shows again after closing and refreshing | Passed |
| Turned off with "On every page load" chosen: not in the page at all | Passed |
| Admin "Reset visitor dismissals": a visitor who closed it sees it again | Passed |
| Stored record holds only `v`, `closed` and `submitted` | Passed |
| No scrollbar inside the form at 1920×1080, 1536×864, 1440×900, 1366×768, 1280×720 and 1024×768 | Passed, after the fix above |
| 22 px between the message box and the button; button centred and inside the dialog | Passed |
| Message box stays 96 px with 1,300 characters typed; resize is off | Passed |
| Admin form: rejects an unknown choice, 0 days, 366 days and text in the days fields; saves valid values | Passed |
| Re-running migration 013 keeps saved values | Passed |

## Points to know

- **Browser storage is per browser and per device.** A visitor who closes the popup on a phone may still see it on a laptop. Private browsing windows forget everything when they close.
- **Visitors who block site storage** see the popup according to the session rule, because nothing can be remembered for them.
- **After testing the popup yourself,** use **Reset visitor dismissals** only if you want every visitor to see it again. You can clear just your own browser instead, using the browser's site data settings.

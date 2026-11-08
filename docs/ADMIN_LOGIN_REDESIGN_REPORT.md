# Admin Login Redesign

**Date:** 7 November 2026
**Screens:** `/admin/login`, plus `/admin/forgot-password` and `/admin/reset-password/…`, which share the same shell
**Public website:** unchanged

## Design

- **Background:** full-screen navy (`#0A1A3F`) with soft electric-blue and cyan glows and a faint grid that fades out at the edges.
- **Card:** one white card with rounded corners and a deep shadow.
  - **Desktop, over 900 px:** two panels.
    - Left: the white GIRZOCK logo, which already carries "Technology. Growth. Elevate.", and the line "Manage your website content, enquiries, careers and SEO in one secure place". Two plain points: encrypted, role-based access; every change recorded.
    - Right: the form.
  - **Tablet and phone:** one column. The brand panel becomes a compact header with the logo.
- **Logo:** shown at its true 640×199 ratio, with `width` and `height` set so nothing shifts while it loads.
- **Type:** the site's own self-hosted Sora (headings) and Manrope (text).
- **Fields:** 50 px high, icons for the user and the lock, a clear blue focus ring and a red error state.
- **Button:** the site's cyan-to-blue gradient, 52 px high, with a spinner while signing in.
- **Credits:** the layout reference was used only for the idea of a split brand-and-form card. No Jovens Academy branding, logo, text or graphics were used.

Screenshots: `docs/screenshots/admin-login-desktop.png` (1440×900) and `admin-login-phone.png` (390×844).

## Form behaviour

| Requirement | How it works |
|---|---|
| Username or email | `autocomplete="username"`, no auto-capitalisation or spell check, max 190 characters |
| Password | `type="password"`, `autocomplete="current-password"` |
| Eye toggle | A real button inside the field. It starts hidden ("Show password", `aria-pressed="false"`). Clicking, tapping, Enter or Space switches between hidden and visible, and updates the label and icon. The typed value and caret position are kept |
| Password hidden again on submit | If the password is visible when the form is sent, it is switched back to hidden first, so it is never left showing and browsers save it as a password |
| Validation | Empty fields show a message under each field and move focus to the first one, before anything is sent. The server checks again: empty fields get "Enter your username or email and your password." and **no sign-in attempt is counted** |
| Wrong details | One message for both a wrong password and an unknown user ("The username or password is incorrect."), so the page never reveals whether an account exists |
| Loading state | The button shows a spinner and "Signing in…", is marked `aria-busy`, and ignores repeat clicks. Pressing Back clears it |
| Forgot password | The link is **not shown** on the login card. Recovery still works at `/admin/forgot-password`, which emails a one-hour, single-use link. The token is stored only as a hash. Bookmark that address for administrators |
| Password managers | A standard POST form with the right `autocomplete` values, so Chrome, Edge, Firefox and Safari offer to save and fill the password. The site itself never stores the password anywhere: no plaintext, browser storage, cookie or custom database field |
| Remember me | Not added. None existed before, and adding one safely needs a separate token design. Sessions last 2 hours of inactivity |

## Security (kept, and tested)

| Control | Implementation |
|---|---|
| Password hashing | bcrypt via `password_hash`. Old hashes are upgraded on sign-in |
| Verification | `password_verify`, with a dummy hash for unknown users so timing gives nothing away |
| CSRF | Every form has a token. A missing or wrong token gets 403 |
| Session | New session ID at sign-in. The session is tied to the current password, so a password change ends other sessions. Cookie `gz_admin_session` is HttpOnly and SameSite=Lax, and is Secure when `COOKIE_SECURE=1` in production. Expires after 2 hours |
| Rate limit | 5 failures for one username and IP, or 20 from one IP, within 15 minutes locks sign-in (429) |
| Sign out | POST with a token only. The session is destroyed, and the old cookie no longer works |
| Headers | `noindex, nofollow`, `X-Frame-Options: DENY`, `Cache-Control: no-store` |
| Admin routes | Every `/admin` page redirects to the login without a session. Role permissions are unchanged |
| Credentials | Not changed or reset |

## Files

| File | Change |
|---|---|
| `application/views/admin/auth/shell_top.php` | New shell: background, brand panel and form panel |
| `application/views/admin/auth/shell_bottom.php` | New: closes the card and loads the script |
| `application/views/admin/auth/login.php` | New form: icons, eye toggle, messages, loading state; no forgot link |
| `application/views/admin/auth/reveal.php` | New: the eye button, shared with the reset form |
| `application/views/admin/auth/forgot.php`, `reset.php` | Use the new shell. The reset form's two password fields get the eye toggle |
| `assets/admin/css/auth.css` | New: styles for the three screens only |
| `assets/admin/js/auth.js` | New: eye toggle, field messages and loading state. It never reads, logs or stores the password value |
| `application/controllers/admin/Auth.php` | Empty fields are refused before any sign-in attempt (422) |

## Test results

`t64_login.js`, on the isolated test copy (its own database, server and test admin password; your real credentials were never used): **170 passed, 0 failed.**

| Area | What was checked |
|---|---|
| Page | 200; `noindex`; cannot be framed; no forgot link; `autocomplete="username"` and `"current-password"`; CSRF token; eye toggle starts as "Show password"; logo at its true ratio |
| Empty fields | 422 with a clear message; no sign-in attempt recorded; username kept |
| Wrong password, unknown user | 401 with the same message for both; the typed password never appears in the page |
| CSRF | Missing or wrong token gets 403 |
| Correct sign in | Redirect to the dashboard; **new session ID**; cookie HttpOnly and SameSite; no password in any cookie; recorded in the activity log |
| SEO tools in the admin | Secondary keywords field, search preview and warnings in the editor; homepage fields in Settings |
| Sign out | POST only; the session ends; **the old session cookie no longer works** |
| Session expiry | When the stored session is gone (as after the 2-hour timeout), the admin sends the user back to the login |
| Rate limit | 5 wrong passwords, then **429 even with the right password** |
| Recovery | `/admin/forgot-password` and reset links still work |
| Chromium, Firefox, WebKit at 1440, 820 and 390 px | No sideways scroll; logo keeps its shape; button 44 px or taller and eye button 40 px; two panels on desktop and one column below 900 px; empty submit shows messages and focuses the first field; messages clear while typing; password hidden by default; the eye shows and hides it by mouse or tap, and **by Enter and Space**; the value is kept; signing in works; no password in browser storage; no console errors |
| Loading state | At the moment of sending, the button shows "Signing in…" with `aria-busy`, and the password is hidden again |

**Found by the test and fixed:** in the first version, the eye button moved focus into the password field after toggling. A keyboard user pressing Space next would have typed a space into their password. Focus now stays on the button, which is the standard behaviour.

**Not testable automatically:** whether each browser's password manager actually offers to save. It depends on the browser's own settings. The form uses the standard attributes these managers look for. Check once by signing in with Chrome or Edge and accepting "Save password".

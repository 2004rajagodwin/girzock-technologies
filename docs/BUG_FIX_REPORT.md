# GIRZOCK Technologies: Bug Fix Report

Date: 7 November 2026. Each item says what was wrong, what changed and how it was verified.

| # | Issue | Change | Verified | Status |
|---|---|---|---|---|
| 1 | `/blog/tag/<tag>/page/2` showed page 1 | Route `blog/tag/(:any)/page/(:num)` added; `Blog::tag()` takes the page | `/blog/tag/business/page/2` now marks page 2 current | Fixed |
| 2 | JavaScript would not be compressed: Apache serves `.js` as `text/javascript`, missing from the compression list | Added `text/javascript` and `application/x-javascript` to `.htaccess` | Apache config test passes. `mod_deflate` is off locally, so compression must be confirmed on the server | Fixed, server check pending |
| 3 | An empty blog category was indexable | Categories with no published posts are noindex | `Blog::category()` sets noindex when there are 0 posts | Fixed |
| 4 | "Unlinked portfolio page" | **No fix needed. This was an error in my earlier audit:** its crawler skipped any URL containing `/admin`, including `/portfolio/admin-dashboard-sample-concept`. The page is linked three times on `/portfolio` | Fresh crawl: 89 URLs, all linked | Report corrected |
| 5 | `X-Frame-Options` sent twice, and `X-Powered-By` exposed | Header removed from `.htaccess` (PHP sets it: SAMEORIGIN on public pages, DENY in the admin panel). `X-Powered-By` removed | Response headers show one `X-Frame-Options` and no `X-Powered-By` | Fixed |
| 6 | No Privacy, Terms or Cookie pages | Added `/privacy-policy`, `/terms-and-conditions`, `/cookie-policy`, footer links and sitemap entries. Text describes only what the site actually does | Pages return 200 with one H1 each | Added; **needs your legal review** |
| 7 | Homepage video downloaded 4.8 MB on every visit | The video loads only when it comes near the screen, with a 16:9 box held in place so nothing moves | Homepage weight 8.48 MB before, 3.81 to 3.94 MB after. Video box 695 px before and after loading, no layout shift | Fixed |
| 8 | Dark theme: service dropdown text white on white | List items keep dark text | Dropdown suite 202/0 | Fixed |
| 9 | Admin "Delete image" did not ask for confirmation | `admin.js` reads the question from the button that was clicked, which fixes any admin button with `data-gz-confirm` | Browser test: confirmation shown, cancel keeps the image | Fixed |
| 10 | Safari: Escape did not close an open dropdown, because Safari does not focus buttons on click | Dropdowns also close on Escape at document level | WebKit test passes | Fixed |
| 11 | Popup scroll lock moved the page by the scrollbar width | Scrollbar space kept while locked | Layout shift from opening the popup: 0.0013 | Fixed |

## Reviewed, not changed
- **Production settings:** documented in `PRODUCTION_DEPLOYMENT_GUIDE.md`. They must be set on the server, not locally.
- **Secure cookies and HTTPS:** same. `COOKIE_SECURE=1` and the HTTPS rules are ready to enable on deployment.
- **Real SMTP:** sign-in verified without sending (Gmail answered 235). Your popup enquiry at 16:06 sent both emails, which the server accepted.
- **Job vacancies:** six openings still publish `JobPosting` data with no closing date. Only you can confirm they are genuine.
- **Unused images:** 90 files (3.3 MB) are not referenced in PHP, CSS, JavaScript, migrations, seed files or any database column. This replaces my earlier figure of 480, which did not search the database. **Nothing was deleted.** The list is in `PERFORMANCE_OPTIMIZATION_REPORT.md`.
- **About page layout shift (up to 0.15):** happens when Google Fonts arrive after the loading screen hides. It disappears when fonts are cached or blocked. The recommended fix is self-hosting Sora and Manrope; it was not done, because it changes how fonts are delivered.

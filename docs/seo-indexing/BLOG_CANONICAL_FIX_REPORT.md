# Blog canonical URL fix: report

GIRZOCK Technologies, https://girzock.com/. Prepared 8 November 2026.

**Status:** the code is finished and tested. Nothing is deployed and no production database change was made. The real local database was only read. All tests ran on a copy of the current content (`girzock_seo`), served with the production settings (`BASE_URL` and `PUBLIC_URL` set to https://girzock.com).

## What every published blog post outputs now

```html
<link rel="canonical" href="https://girzock.com/blog/<actual-slug>">
<meta property="og:url" content="https://girzock.com/blog/<actual-slug>">
<meta property="og:type" content="article">
<meta property="og:image" content="https://girzock.com/<post image>">
<meta name="twitter:image" content="https://girzock.com/<post image>">
<script type="application/ld+json">{"@type":"BlogPosting", ..., "url":"https://girzock.com/blog/<actual-slug>", "mainEntityOfPage":"https://girzock.com/blog/<actual-slug>"}</script>
```

The breadcrumb items are `https://girzock.com/`, `https://girzock.com/blog` and the post URL.

**One value everywhere.** The canonical link, `og:url`, the share buttons, and the BlogPosting `url` and `mainEntityOfPage` all use the same value:
- the post's own slug URL;
- or, if you saved a valid manual override in the admin, that override.

## The 11 published posts (all indexable, each in the sitemap once)

| # | Canonical URL |
|---:|---|
| 1 | https://girzock.com/blog/why-small-businesses-in-tirunelveli-need-a-professional-website |
| 2 | https://girzock.com/blog/how-to-choose-a-web-development-company-in-tirunelveli |
| 3 | https://girzock.com/blog/website-development-cost-in-tamil-nadu-business-guide |
| 4 | https://girzock.com/blog/ecommerce-website-development-for-growing-businesses-in-tamil-nadu |
| 5 | https://girzock.com/blog/website-maintenance-and-security-business-guide |
| 6 | https://girzock.com/blog/how-to-plan-a-business-website-that-generates-enquiries |
| 7 | https://girzock.com/blog/custom-software-or-off-the-shelf-how-to-choose |
| 8 | https://girzock.com/blog/what-to-check-before-moving-your-business-to-the-cloud |
| 9 | https://girzock.com/blog/ui-ux-basics-every-business-owner-should-know |
| 10 | https://girzock.com/blog/wordpress-or-a-custom-built-website-which-suits-you |
| 11 | https://girzock.com/blog/a-practical-first-step-towards-digital-transformation |

The **20 draft posts** return 404 to visitors and are not in the sitemap. A signed-in admin preview (`?preview=1`) is `noindex, nofollow` in both the meta tag and the header, with no canonical link.

Other blog pages:
- **Blog listing:** keeps its own canonical, `https://girzock.com/blog`.
- **Page 2 and later:** each keeps its own canonical.
- **Blog search and tag pages:** `noindex, follow`, with no canonical.
- **Categories with fewer than 2 articles:** `noindex, follow` until they reach 2.

## Changes in this step

| File | Change |
|---|---|
| `application/controllers/Blog.php` | **Post pages:** the canonical is resolved once from the slug, or from a valid override. That one value is used for `share_url` and for the BlogPosting markup. **BlogPosting:** gained a `url` property. **`mainEntityOfPage`:** now follows a valid override as well, instead of always the slug. |
| `application/views/admin/crud/form.php` | Under the Canonical URL field, a new line "Automatic canonical: https://girzock.com/blog/<slug>" shows the production URL. |
| `assets/admin/js/admin.js` | The automatic canonical, the field placeholder and the search preview update as you type the slug, or the title for a new post. |
| `assets/admin/css/admin.css` | Spacing for that new line; long URLs wrap on phones. |

**Already in place from the earlier passes (re-tested for the blog):**
- The URL is generated automatically when the field is empty.
- The query, fragment, trailing slash, `www` and `http` are removed, and the domain is forced to https://girzock.com.
- Manual canonicals are refused if they contain a local address, an IP address, another domain, `?` or `#`, or if they point at the homepage.
- A noindex post prints no canonical.
- The sitemap leaves out noindex posts, drafts, and posts whose canonical points elsewhere.
- Saved image URLs on the site's own domain are rewritten to https://girzock.com.

## Database audit and SQL

| Check | Result |
|---|---|
| Published posts / drafts | 11 / 20. Every post has an SEO row. |
| Manual canonical overrides on blog posts | 0. Every post uses its automatic slug URL. |
| Blog posts set to noindex | 0 |
| Slugs with spaces, capitals or other odd characters | 0 |
| Duplicate slugs | 0 |
| Absolute or wrong-domain social or featured images | 0 |
| Content linking to localhost, 127.0.0.1, `http://girzock.com` or `www.girzock.com` | 0 |

**No blog migration is needed.** There is nothing incorrect to change.
- `blog_canonical_audit.sql`: read-only checks you can run on production. The expected results are written in the file.
- `production_seo_domain_migration.sql` / `production_seo_domain_rollback.sql`, prepared earlier: they also clean blog rows in `seo_metadata` if production holds a local, http, www, `?` or `#` value. Both were tested on copies, and they change 0 rows on today's data.

No blog content, slug, SEO title, description, keyword or social image was changed.

## Tests

| Suite | Passed | Failed |
|---|---:|---:|
| Blog canonical tests (`girzock_seo` copy, production settings) | 196 | 0 |
| Blog edit form in the browser: 1440 px and 390 px, existing and new posts | 14 | 0 |
| Production-domain SEO audit: all 53 indexable pages | 2065 | 0 |
| Full regression, isolated test database: content 812, public 107, admin 291, SEO and delete 176, browser 53, uploads 77, forms and email 106, mega menu 234, dropdowns 202, favicon 22, popup admin 149, popup browser 438, email retry 6, social 90 + 307, admin login 170, SEO image 67, careers and forms 135 | 3,415 | 0 |

The one log line in the regression run, "Resume file for deleted application #5 was missing", is expected. It comes from a planted test that checks a hostile resume path is refused. Test uploads were removed afterwards.

**Blog canonical tests cover:**
- **For each of the 11 published posts:**
  - 200 status;
  - exactly one canonical, equal to its slug URL, and never the homepage or the blog listing;
  - `index, follow`;
  - `og:url` equal to the canonical, and `og:type` `article`;
  - `og:image` and `twitter:image` on https://girzock.com, returning 200;
  - BlogPosting `url` and `mainEntityOfPage` equal to the canonical, and its image on https://girzock.com;
  - breadcrumbs on https://girzock.com;
  - no local, http or www URL anywhere on the page;
  - listed in the sitemap exactly once;
  - the same canonical with tracking parameters added or a trailing slash.
- **Drafts:** 404 to visitors and not in the sitemap. The admin preview is `noindex, nofollow`, with no canonical.
- **Admin form:**
  - shows the automatic production canonical;
  - refuses a localhost, external, query, fragment, homepage or IP canonical with 422 and saves nothing.
- **Manual overrides:**
  - a valid override (written with `www` and a trailing slash) is saved and printed cleaned in the canonical, `og:url` and BlogPosting;
  - that post leaves the sitemap;
  - clearing the override brings back the automatic URL.
- **SEO fields:** titles, descriptions and keywords are unchanged after these saves.
- **New post:**
  - created and published through the admin;
  - its canonical is generated from its slug, and it appears in the sitemap once.
- **Slug change:**
  - the canonical and the sitemap follow the new slug;
  - the old URL returns 301 to the new one;
  - the form shows the new automatic URL.

**Browser tests cover:**
- the automatic canonical and the placeholder show the production slug URL;
- they update as you type a new slug, and follow the title for a new post with no slug;
- a typed manual canonical shows in the search preview;
- no sideways scroll on desktop or phone;
- no JavaScript errors.

## Before production
1. Review the code changes listed above.
2. Optionally, run `blog_canonical_audit.sql` in production phpMyAdmin and compare the results with the expected values in the file.
3. Deploy with approval, using the steps in `PRODUCTION_SEO_DOMAIN_MIGRATION_REPORT.md` section 17.

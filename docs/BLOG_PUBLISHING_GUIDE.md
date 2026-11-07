# How to Publish an SEO-Friendly Blog Post

For admins of the GIRZOCK Technologies website. Every step below matches the current admin panel.

## 1. Sign in and start a post
1. Go to `https://girzock.com/admin/login` and sign in.
2. In the sidebar, open **Blog Management**.
3. Click **Add**. The page is `/admin/blog/create`.

## 2. Write the post
| Field | What to enter | Notes |
|---|---|---|
| Title | A clear title in plain words, such as "Why Every Business Needs a Professional Website in 2027" | This becomes the page heading (H1) |
| Slug | Leave blank | Made from the title and kept unique. If you change it later, the old address redirects automatically (301) |
| Excerpt | One or two sentences | Shown on blog cards, and used as the search description if you leave the SEO description empty |
| Content | The article | Use **Heading 2** for main sections and **Heading 3** for sub-points. Never use Heading 1 in the content. Link to related services and posts |
| Category | Choose one | Categories with no published posts are hidden from search |
| Tags | A few words, separated by commas | New tags are created automatically. Tag pages are not indexed |
| Author | Leave blank to use your name | |
| Reading time | Leave blank | Calculated for you |
| Featured image | JPG, PNG or WebP, up to 5 MB | Converted to WebP, with smaller copies for phones |
| Image alt text | Describe what the picture shows | Needed for accessibility and image search. If empty, the title is used |

**Writing tips:**
- Answer one question well.
- Name a place only where it is genuinely relevant.
- Never invent statistics, clients or results.
- End with a link to the relevant service and to the Contact page.

**Internal links:** to link to a page on this site, use the address form `site:services/website-development`. The site turns it into the right full address on any domain.

## 3. SEO panel (optional, below the content)
| Field | Guidance |
|---|---|
| SEO title | Under 60 characters. If blank: "Title \| GIRZOCK Technologies" |
| Meta description | 120 to 160 characters, a summary that makes people want to click |
| Focus keyword | For your own reference only; it is not shown on the page |
| Open Graph title / description / sharing image | Only if social media should show something different |
| Canonical URL | Leave blank unless the article was first published elsewhere |
| Search engine indexing | Leave on the default (index) for a normal post |

## 4. Save, preview and publish
1. Set **Status** to **Draft** and save. Drafts are not public: visitors get "page not found", and drafts are not in the sitemap.
2. Click **Preview page** at the top of the edit form. It opens the post with `?preview=1` in a new tab, visible only to you, and marked so search engines ignore it.
3. When ready:
   - To publish now, set Status to **Published**. If the publish time is empty, the current time is used.
   - To publish later, set Status to **Scheduled** and a future publish time. It goes live at that time on its own.
4. **Unpublish** any time with the toggle in the list. **Delete** removes the post from the site; its address then answers "gone" (410).

## 5. What happens automatically after publishing
- The post appears first in the blog listing and in its category.
- Its page has its own title, description and canonical address.
- BlogPosting structured data is added, with the publish and update dates.
- The featured image becomes the social sharing image.
- The post is added to `sitemap.xml` straight away.
- Related posts, previous/next links, the recent posts list and tag links connect it to other content.

## 6. Help search engines find it (manual)
1. In **Google Search Console**, use **URL inspection** on the new address, then **Request indexing**.
2. The sitemap only needs to be submitted once, at launch.
3. Optionally, do the same in **Bing Webmaster Tools**.
4. Check back in a week or two. Indexing is not instant or guaranteed, and rankings depend on usefulness and competition.

## 7. Updating an older post
- **Change the content when it is out of date.** The update date and sitemap date change automatically.
- **Change the slug only when necessary.** The redirect from the old address is automatic, but update any links you added yourself.
- **After changing the featured image,** update its alt text.

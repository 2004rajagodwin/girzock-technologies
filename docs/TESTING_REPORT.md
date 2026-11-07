# GIRZOCK Technologies: Testing Report

Date: 7 November 2026. Only executed tests are listed.
- **Isolated:** a separate database (`girzock_test`) with its own private folder and fake keys. Emails go to a local mail catcher. Removed after each run.
- **Real:** read-only requests to the real local site.

## Isolated copy (final run on the finished code)
| Suite | Passed | Failed |
|---|---:|---:|
| Content checks | 813 | 0 |
| Public pages and forms | 107 | 0 |
| Admin modules | 291 | 0 |
| SEO, sitemap and delete | 183 | 0 |
| Browser behaviour | 53 | 0 |
| Image uploads | 77 | 0 |
| Forms and email | 105 | 0 |
| Mega menu | 234 | 0 |
| Service dropdown (Chrome, Firefox, WebKit) | 202 | 0 |
| Favicon priority | 22 | 0 |
| Popup admin | 135 | 0 |
| Popup browser (Chrome, Firefox, WebKit) | 314 | 1 |
| Heading styles compared | 1,350 | 0 differences |

The popup failure was a DNS outage on the PC ("Could not resolve hostname" for Google Fonts) during the WebKit run.

## Real local site, read-only
| Suite | Passed | Failed |
|---|---:|---:|
| Content checks | 813 | 0 |
| SEO crawl | 141 | 0 |
| Contact panel | 10 | 0 |
| Mega menu | 234 | 0 |
| Where We Work orbit | 113 | 0 |
| Software tabs | 766 | 0 |
| Header button and commitment text (3 engines) | 378 | 0 |
| Preloader, About layout, icons (3 engines) | 762 | 0 |
| WhatsApp button (3 engines) | 438 | 0 |
| Form fields readable in both themes | 48 | 0 |
| Popup after migration 011 (3 engines) | 150 | 0 |
| Page audit | 62 pages: no broken images, no sideways scroll, no console errors | |
| Homepage comparison | 368 sections: from 425 px up, only the requested sections changed, and no image changed. At 320 and 375 px, two runs of identical code differ the same way, so differences there are measurement noise | |

## Real email
- **SMTP sign-in:** verified without sending. Gmail answered 235 (signed in).
- **Delivery:** your own popup enquiry at 16:06 on 7 November 2026 produced the company notification and the client confirmation, both accepted by the SMTP server. Inbox arrival is for you to confirm.

## Not tested
- Anything on the production server: HTTPS, compression, email from the server.
- Real Safari (WebKit was used) and real phones.
- External security scan, Rich Results Test and social sharing previews.

## Earlier report corrections
- The "unlinked portfolio page" was an error in my crawler; the page is linked.
- Unused images are 90 (3.3 MB), not 480.
- Firefox's 11 "gap" failures in the 7 November afternoon run were a test method issue. A pixel measurement confirmed the same spacing as Chrome.

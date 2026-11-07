# GIRZOCK Technologies: Image, Page Redesign and Where We Work Report

Covers the "Final Professional Image Replacement, Blog & Case Study Redesign" and "Infinite Rotating Coverage Animation" briefs. Later design changes are in `FINAL_PRODUCTION_READINESS_REPORT.md`.

## Images removed from pages
Case Studies VR gallery and video banner, purple and blank cards, pharmacy and retail images, older blog images. Their files remain on disk. The earlier Where We Work photos are now unused.

## New images
All are in `assets/images/generated/pro/`, created with Figma image generation and encoded to WebP. Originals are in `backups/generated-pro-photos-originals-2026-11-06/`.

| Folder | Used on | Count |
|---|---|---|
| `home/` | Homepage software tabs | 5 |
| `services/` | Service detail pages | 15 |
| `blog/` | Featured images for posts | 10 |
| `portfolio/` | Portfolio items | 3 |
| `cards/` | "Kinds of Projects" cards | 16 |
| `menu/` | Mega menu previews | 15 files |

The alt text for each image is stored in `application/migrations/data/professional_images.php`.

## Redesign status
| Page | Result |
|---|---|
| Case Studies | Image cards, labelled as sample concepts |
| Portfolio | New gallery; filter kept, lightbox removed |
| Blog listing | Featured post plus cards |
| Blog detail | Two columns, with sidebar: search, categories, recent posts, tags, call to action |
| Homepage software section | Five new tab images; layout later changed by the owner's request |
| Where We Work | Heading and three buttons on the left; rotating coverage orbit on the right; three coverage cards |

## Where We Work animation
Three rings rotate infinitely at 60 s, 42 s (reverse) and 28 s. The Base pin stays still. Reduced-motion is supported. Final test: 113 passed, 0 failed.

## WebP and detail links
All 53 WebP files served during the final audit had the correct type. Detail links are covered by the crawl: 85 URLs, all HTTP 200.

## Remaining approvals
- AI-generated people are not staff or clients and must not be presented as such. The cast is mixed international, in corporate settings.
- "Remote: Pan India & Global" was requested wording, and is broader than the page text about Tamil Nadu and nearby Kerala.
- "Work With" logos are the template's fictional companies, licence unconfirmed.
- Products, some Services cards (one shows an X shape) and About still use older template images.
- 20 draft posts use older images; two link to other drafts.
- Not tested: real Safari and real phones.

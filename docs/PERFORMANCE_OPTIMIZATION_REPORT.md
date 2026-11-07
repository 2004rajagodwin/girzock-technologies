# GIRZOCK Technologies: Performance Optimization Report

Date: 7 November 2026. Measured on the local server. These are not production figures.

## Changes made, without reducing image quality
| Change | Effect |
|---|---|
| Homepage background video loads only when it comes near the screen | Homepage weight fell from **8.48 MB to 3.81 to 3.94 MB** in Lighthouse |
| 16:9 box held for the video | No layout shift when the video loads (it was 0.12 when tested without the box) |
| Popup images requested only for the current screen size, 1.5 s before opening | No popup image in the initial page load |
| `text/javascript` added to the compression list | JavaScript compresses on servers with `mod_deflate` |

## Lighthouse, mobile (after the changes, popup on)
| Page | Performance | SEO | Accessibility | Best practices | LCP | CLS | Weight |
|---|---:|---:|---:|---:|---:|---:|---:|
| Home | 37 / 49 | 92 | 94 | 93 | 12.5 / 17.5 s | 0.049 | 3.94 / 3.81 MB |
| About | 51 / 53 | 92 | 93 | 96 | 16.6 / 16.7 s | 0.149 / 0.148 | 3.09 MB |
| Contact | 52 / 56 | 92 | 97 | 100 | 16.0 s | 0.125 / 0.052 | 3.71 MB |
| Blog | 60 / 56 | 92 | 96 / 97 | 100 | 16.7 / 17.7 s | 0.001 / 0.000 | 3.25 / 3.20 MB |

Each page was run twice. Scores vary between runs on this PC; compression is off locally, and the PC's connection to Google Fonts was slow during these runs.

## What still limits speed
1. **Google Fonts arrive late.** The About shift of about 0.15 occurs exactly when fonts finish loading (measured at 3,098 ms and 7,504 ms). It disappears when fonts are cached or blocked. The fix is to self-host Sora and Manrope, which needs your approval because it changes how fonts are delivered.
2. **`style.min.css` is 608 KB** and blocks rendering. Lighthouse estimates 838 KB of unused CSS across the template.
3. **Large images:** the preloader logo `girzock-pre-logo.png` is 350 KB, `layer11.png` 339 KB and `layer11-2.png` 234 KB. WebP copies of these PNGs were not smaller, so none was made; quality stays as is. Restoring `girzocl-loader.webp` would save about 250 KB.
4. **Contact page map:** Google Maps loads about 1.9 MB of its own scripts. The map is already lazy-loaded, but Lighthouse's tall test screen reaches it.
5. **No compression locally.** Measure again on the server after deployment.

## Unused images
90 of 858 image files (3.3 MB) are not referenced in PHP, CSS, JavaScript, migrations, seed files, `.htaccess` or any text column of any database table. Admin uploads not referenced: 0.

This replaces the earlier estimate of 480, which did not search the database or match WebP copies to their originals.

**Nothing was deleted.** A name built by code could still use a file, so confirm the list before removing anything. Files by folder:

| Folder | Files |
|---|---:|
| `assets/images/event` | 32 |
| `assets/images/feature` | 21 |
| `assets/images/service` | 17 |
| `assets/images/generated/photo/portfolio` | 6 |
| `assets/images/generated/photo/where-we-work` | 6 |
| `assets/images/project` | 4 |
| `assets/images/bg` | 2 |
| `assets/images/icon` | 2 |

## Full list
| File | Size |
|---|---:|
| `assets/images/bg/bg2-1.png` | 326 KB |
| `assets/images/bg/bg2-1.png.webp` | 31 KB |
| `assets/images/event/avatar-1.png` | 10 KB |
| `assets/images/event/avatar-1.png.webp` | 1 KB |
| `assets/images/event/avatar-2.png` | 10 KB |
| `assets/images/event/avatar-2.png.webp` | 1 KB |
| `assets/images/event/choose.png` | 235 KB |
| `assets/images/event/choose.png.webp` | 47 KB |
| `assets/images/event/language.png` | 1 KB |
| `assets/images/event/language10.png` | 1 KB |
| `assets/images/event/language11.png` | 1 KB |
| `assets/images/event/language12.png` | 1 KB |
| `assets/images/event/language13.png` | 1 KB |
| `assets/images/event/language14.png` | 1 KB |
| `assets/images/event/language15.png` | 2 KB |
| `assets/images/event/language16.png` | 1 KB |
| `assets/images/event/language17.png` | 1 KB |
| `assets/images/event/language18.png` | 1 KB |
| `assets/images/event/language19.png` | 1 KB |
| `assets/images/event/language2.png` | 1 KB |
| `assets/images/event/language20.png` | 1 KB |
| `assets/images/event/language21.png` | 1 KB |
| `assets/images/event/language22.png` | 1 KB |
| `assets/images/event/language23.png` | 1 KB |
| `assets/images/event/language24.png` | 1 KB |
| `assets/images/event/language25.png` | 1 KB |
| `assets/images/event/language26.png` | 1 KB |
| `assets/images/event/language3.png` | 1 KB |
| `assets/images/event/language4.png` | 1 KB |
| `assets/images/event/language5.png` | 1 KB |
| `assets/images/event/language6.png` | 1 KB |
| `assets/images/event/language7.png` | 2 KB |
| `assets/images/event/language8.png` | 1 KB |
| `assets/images/event/language9.png` | 1 KB |
| `assets/images/feature/feature.png` | 52 KB |
| `assets/images/feature/feature.png.webp` | 34 KB |
| `assets/images/feature/feature12-1.png` | 62 KB |
| `assets/images/feature/feature12-1.png.webp` | 27 KB |
| `assets/images/feature/feature2-1.png` | 205 KB |
| `assets/images/feature/feature2-1.png.webp` | 133 KB |
| `assets/images/feature/feature2-2.svg` | 12 KB |
| `assets/images/feature/feature2-3.png` | 257 KB |
| `assets/images/feature/feature2-3.png.webp` | 176 KB |
| `assets/images/feature/feature2-4.svg` | 32 KB |
| `assets/images/feature/feature2.png` | 49 KB |
| `assets/images/feature/feature2.png.webp` | 26 KB |
| `assets/images/feature/feature3-4.svg` | 3 KB |
| `assets/images/feature/feature6-1.png` | 116 KB |
| `assets/images/feature/feature6-1.png.webp` | 22 KB |
| `assets/images/feature/feature6-2.png` | 104 KB |
| `assets/images/feature/feature6-2.png.webp` | 30 KB |
| `assets/images/feature/feature6-3.png` | 99 KB |
| `assets/images/feature/feature6-3.png.webp` | 23 KB |
| `assets/images/feature/feature7-2.svg` | 12 KB |
| `assets/images/feature/feature7-3.svg` | 32 KB |
| `assets/images/generated/photo/portfolio/business-management-system-606w.webp` | 21 KB |
| `assets/images/generated/photo/portfolio/business-management-system.webp` | 50 KB |
| `assets/images/generated/photo/portfolio/local-retailer-store-606w.webp` | 31 KB |
| `assets/images/generated/photo/portfolio/local-retailer-store.webp` | 76 KB |
| `assets/images/generated/photo/portfolio/storefront-redesign-606w.webp` | 33 KB |
| `assets/images/generated/photo/portfolio/storefront-redesign.webp` | 89 KB |
| `assets/images/generated/photo/where-we-work/local-480w.webp` | 22 KB |
| `assets/images/generated/photo/where-we-work/local.webp` | 55 KB |
| `assets/images/generated/photo/where-we-work/regional-480w.webp` | 22 KB |
| `assets/images/generated/photo/where-we-work/regional.webp` | 53 KB |
| `assets/images/generated/photo/where-we-work/remote-480w.webp` | 20 KB |
| `assets/images/generated/photo/where-we-work/remote.webp` | 48 KB |
| `assets/images/icon/bord.svg` | 15 KB |
| `assets/images/icon/phone2.svg` | 5 KB |
| `assets/images/project/fun1-1.png` | 7 KB |
| `assets/images/project/fun1-1.png.webp` | 3 KB |
| `assets/images/project/fun1-2.png` | 8 KB |
| `assets/images/project/fun1-2.png.webp` | 3 KB |
| `assets/images/service/ser12-1.png` | 53 KB |
| `assets/images/service/ser12-1.png.webp` | 17 KB |
| `assets/images/service/ser12-2.png` | 62 KB |
| `assets/images/service/ser12-2.png.webp` | 16 KB |
| `assets/images/service/ser12-3.png` | 45 KB |
| `assets/images/service/ser12-3.png.webp` | 8 KB |
| `assets/images/service/ser13-1.png` | 52 KB |
| `assets/images/service/ser13-1.png.webp` | 29 KB |
| `assets/images/service/ser13-2.png` | 35 KB |
| `assets/images/service/ser13-2.png.webp` | 13 KB |
| `assets/images/service/ser13-4.png` | 64 KB |
| `assets/images/service/ser13-4.png.webp` | 27 KB |
| `assets/images/service/ser3-1.png` | 56 KB |
| `assets/images/service/ser3-1.png.webp` | 16 KB |
| `assets/images/service/ser3-2.png` | 76 KB |
| `assets/images/service/ser3-2.png.webp` | 9 KB |
| `assets/images/service/ser3-3.png` | 3 KB |

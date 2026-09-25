# Audit Fix Report — al-falahmarketing.com

What changed, where, and how to verify it. Covers Phase 0 (discovery),
Phase 1 (credibility & broken things) and Phase 2 (SEO foundation) of the
audit-fix engagement driven by `AUDIT-FIX-PROMPT.md`. Updated as later
phases land.

Branches: Phase 1 was done on `fix/site-audit-2026-09-25`, merged to
`main` (`ae1c953`). Phase 2 is on `fix/site-audit-2026-09-25-phase2`,
not yet merged — awaiting your review.

---

## Phase 1 — Credibility & Broken Things

Commit `f1fa2bd` on `main`.

| Issue | Files changed | How to verify |
|---|---|---|
| Fabricated stats/claims ("500+ Clients", "98% Success", "Since 2009", "Fortune 500", "Award Winning", "24/7 support", etc.) across homepage and all 6 service pages, plus 3 entirely fabricated testimonial sections (fake names/companies/ratings, one with a stock photo) | `resources/views/User/index.blade.php`, `about.blade.php`, `portfolio.blade.php`, `service.blade.php`, all 6 files under `services/` | Grep the site for `2009`, `500+`, `Fortune`, `98%`, `15+`, `50+`, `Award`, `24/7`, `10M`, `99%` — no results |
| Homepage showed only the US phone number, Contact page only the Guinea number | New `resources/views/partials/contact-info.blade.php`, `App\Support\Contact`, wired into `index.blade.php`, `contact.blade.php`, `footer.blade.php` | View any of those pages — both offices/phones/hours/email visible |
| 16 broken/raw wa.me links (unencoded spaces/apostrophes, 3 with literal `wa.me/YOUR_NUMBER` placeholders) | `App\Support\Contact::whatsappUrl()`, all templates with a WhatsApp CTA | Click any WhatsApp button — opens wa.me with a clean, properly-encoded message |
| `/services/automation` rendered the Content Creation page verbatim | `resources/views/User/services/automation.blade.php` | Visit `/services/automation` — shows AI Chatbots/Automation content, not Content Creation |
| `/About-us`, `/Services`, `/Blog` worked but lowercase versions 404'd; `/blog` itself 404'd | `routes/web.php` | `curl -I /About-us` → 301 to `/about-us`; `curl -I /blog` → 200 |
| No branded 404/500 pages | `resources/views/errors/404.blade.php`, `500.blade.php` | Visit any non-existent URL |
| 3 portfolio items linked to temp builder domains (hostingersite.com, lovable.app, manus.space) | `resources/views/User/portfolio.blade.php` | View Portfolio — no click-through button on those 3 cards |

**Not fixable from code** (DB content) — see `MANUAL-TASKS.md` #1: the
"since 2009" blog line, duplicated reading-time bylines in post bodies,
the 3 portfolio temp links themselves, and the "EI Maloum" typo.

---

## Phase 2 — SEO Foundation

Commits `18b5fb2`, `d06d96c`, `550519e`, `758115b` on
`fix/site-audit-2026-09-25-phase2`.

| Issue | Files changed | How to verify |
|---|---|---|
| No meta description, canonical, Open Graph, or Twitter card tags anywhere on the site | `resources/views/User/main.blade.php` (framework), every public view (per-page content) | View source on any page — full `<head>` meta set present |
| Favicon was a single reused `.webp` (wrong type for `apple-touch-icon`) | `main.blade.php` + new `favicon.ico`, `assets/images/favicon-32x32.png`, `assets/images/apple-touch-icon.png` (root-level — see note below) | Browser tab icon renders; `curl -I /favicon.ico` → 200 |
| No default social-share image | New `assets/images/og-default.jpg` (placeholder — see `MANUAL-TASKS.md` #3) | Paste a page URL into Facebook's Sharing Debugger |
| `<html lang>` read a raw cookie directly, bypassing the site's actual locale resolution (defaulted to `en` even in French) | `main.blade.php` (uses `app()->getLocale()` now) | Set the `lang=fr` cookie, reload any page — `<html lang="fr">` |
| Contact page shared the homepage's generic title; several pages had no meta description | Every public view under `resources/views/User/` | View source — each page has its own `<title>`/description per the brief's table |
| Contact page had no `<h1>` at all | `contact.blade.php` | Inspect — "Let's Grow Your Business Together" is now an `<h1>` |
| Blog post page had no title/description meta at all | `blog_single.blade.php`, new `Blog::excerpt()` accessor | Visit any blog post — dynamic title/description present |
| Blog excerpts sometimes started with a duplicated "Estimated Reading Time... by Abdulrahman Jalloh" byline | `app/Models/Blog.php` (`getCleanExcerptAttribute()`), `blog.blade.php` | Compare a blog card's preview text against its raw body |
| Blog hero image had no `alt` text | `blog_single.blade.php` | Inspect the post's main image |
| No www→apex redirect (`www.al-falahmarketing.com` returned 200 instead of redirecting) | `.htaccess` | `curl -I http://www.al-falahmarketing.com` → 301 to apex |
| No sitemap | New `app/Http/Controllers/SitemapController.php`, `resources/views/sitemap.blade.php`, route in `routes/web.php` | `curl -s /sitemap.xml \| head` — valid XML with all pages + blog posts |
| `robots.txt` was empty | Root `robots.txt` | `curl -s /robots.txt` — Disallow rules + Sitemap line |
| `/login` and paginated/filtered blog URLs were indexable | `login.blade.php`, `blog.blade.php` | View source on `/login` — `noindex,follow` present |
| No structured data anywhere on the site | New `app/Support/Seo.php`; JSON-LD pushed on Home, Contact, all 6 service pages, blog posts, and auto-generated `BreadcrumbList` on every other page | Paste a page URL into Google's Rich Results Test; or view source and check any `<script type="application/ld+json">` block |

**Not fixable from code** — see `MANUAL-TASKS.md` #2–#5: `.env`'s
`APP_URL` has a stray `www.` that undermines the new redirect (🔴
top priority), no real square logo exists so the favicon/OG image are a
placeholder monogram, brand hex colors are unconfirmed, and the repo has
two copies of its asset tree (root-level, which production actually
serves, and an unused `public/` copy) — a side effect of the document
root not pointing at `public/`, which is already a tracked long-term fix.

**Packages added:** none. The sitemap is hand-rolled (a plain route +
Blade view), not the `spatie/laravel-sitemap` package the brief offered
as an option — the site only has two content types, so a package added
more surface area than it saved.

---

## Deploy steps (Hostinger)

1. Merge `fix/site-audit-2026-09-25-phase2` into `main` and push.
2. Hostinger's git auto-deploy pulls automatically **once it's repointed
   to this repo** (`github.com/arjalloh79-coder/alfalahmarketing-laravel`)
   — this is a separate, already-tracked manual hPanel step, not part of
   this phase.
3. Before or right after deploy, fix `APP_URL` in the live `.env` (see
   `MANUAL-TASKS.md` #2) and run `php artisan config:clear`.
4. No migrations, no new Composer/npm packages — nothing else to install.

### Post-deploy verification

```
curl -I http://www.al-falahmarketing.com          # -> 301 to https://al-falahmarketing.com/
curl -I https://al-falahmarketing.com/Blog          # -> 301 to /blog
curl -I https://al-falahmarketing.com/blog          # -> 200
curl -I https://al-falahmarketing.com/abc123        # -> 404, branded page
curl -s https://al-falahmarketing.com/sitemap.xml | head   # -> valid XML, apex URLs (not www)
curl -sI https://al-falahmarketing.com | grep -iE "strict|x-frame|nosniff|referrer|powered"  # nothing yet - Phase 3
curl -s https://al-falahmarketing.com/services/automation | grep -o "<title>.*</title>"  # Automation title
```

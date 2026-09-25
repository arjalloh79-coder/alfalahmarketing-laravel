# Manual Tasks — al-falahmarketing.com Audit Fix

Your step-by-step guide for everything the audit-fix work found that needs
you personally — an account, a dashboard, a content decision, or a server
action I can't do from code. Updated as each phase finishes.

Priority: 🔴 do this week · 🟠 do this month · 🟢 when possible.

---

## From Phase 1 (credibility & broken things)

### 1. Fix database content (admin panel → Blogs / Portfolio)
🔴 15 min. These are stored in the live database, not in a template file, so
I couldn't edit them directly — the ground rules for this project say to
list DB content changes here instead of touching the database.

- **"Since 2009" claim**: the "2026 Growth Blueprint" blog post's body
  contains a "since 2009" line. The company's actual founding is 2023
  (per the stat bar I fixed: "Since 2023"). Edit the post body in
  `/admin/blogs` and remove or correct that line.
- **Duplicated reading-time byline**: some blog posts' bodies start with a
  line like "Estimated Reading Time: X min ... by Abdulrahman Jalloh"
  baked into the actual content, not just the auto-generated excerpt. I
  fixed the *generated* excerpts/previews in code so they no longer show
  this, but the raw post bodies still contain it — clean those up in
  `/admin/blogs`.
- **Truncated blog title**: the "2026 Growth Blueprint" post's `title`
  field in the database is literally cut off — it reads "The 2026 Growth
  Blueprint:" with nothing after the colon. This is why the page's H1 (and
  now its `<title>` and JSON-LD headline) show a truncated sentence — the
  Blade template just prints the title as stored. Edit the post in
  `/admin/blogs` and enter the full intended title.
- **Portfolio temp links**: three portfolio entries link to
  temporary/builder domains instead of the real client sites:
  - LABONET → `https://khaki-crow-578367.hostingersite.com/`
  - SHAWARMA SAM → `https://shawarma-sam-conakry-delights.lovable.app`
  - Acile Coffee → `https://acile-coffee-ehzwdbqi.manus.space/`

  I already hid the "View Project" button for any link on these
  temp-builder domains site-wide (so it won't happen again for future
  entries either), but update these three to the real domain or a case
  study link in `/admin/portfolio` when you have them.
- **"EI Maloum" typo**: one portfolio (or blog) record has "EI Maloum"
  where it should read "El Maloum" — fix the text in the admin panel.

---

## From Phase 2 (SEO foundation)

### 2. Fix `.env` → `APP_URL` on the live server
🔴 5 min, but important — **this actively works against the www→apex
redirect I just added**. Your production `.env` has:
```
APP_URL=https://www.al-falahmarketing.com/
```
Every link the app generates internally (canonical tags, Open Graph URLs,
the new sitemap, and Laravel's own `route()`/`url()` helpers used
throughout the site) is built from this value — so right now they all
point to the `www.` version, while the new `.htaccess` rule redirects
`www.` → apex. Change it to:
```
APP_URL=https://al-falahmarketing.com
```
via Hostinger's File Manager (edit `.env` in the site's root) or SSH, then
run `php artisan config:clear` on the server (or just let the next deploy
do it). `.env` is never committed to git, so this can't be fixed from a
code change — it has to be edited directly on the server.

### 3. Provide a real square logo icon
🟠 30 min (or hand to a designer). Your only logo file
(`assets/images/alfalah.webp`) is a wide 1408×792 promotional/video-
thumbnail graphic — not a square icon. I generated a clean placeholder
(brand-color square with "AF" initials) for the favicon and the default
social-share image rather than distorting or blurrily cropping that
banner. Replace these with a real design when you have one:
- `assets/images/favicon-32x32.png`, `assets/images/apple-touch-icon.png`,
  `favicon.ico` (all at the repo root — see note below on why)
- `assets/images/og-default.jpg` (1200×630 social preview image) — a good
  Canva template size for this.

### 4. Confirm the brand colors
🟠 5 min. No brand hex code exists anywhere in the repo (logo file, CSS,
or config) — only Tailwind's default demo blue. I used the audit brief's
fallback (`primary: #0F4C5C`, `dark: #0B2A3A`, deep teal/navy) for the
placeholder OG image and icon above. Confirm these are the right hex
values, or send the real ones — this also feeds into Phase 3's full site
recoloring.

### 5. Two copies of the asset folder exist — know which one to edit
🟢 Just for awareness, no action needed yet (ties into the already-known
"repoint document root to `public/`" task). This checkout has **two**
copies of the same asset tree: `assets/`, `robots.txt`, `index.php` at the
project root (what your live site actually serves — confirmed by the
September security fix, since the document root points at the whole
project, not `public/`), and an unused, leftover `public/` copy from
Laravel's default project scaffold. I only edited the root-level copies
since those are what's live. If you ever upload files by hand instead of
through git, make sure they go in the root-level folders, not `public/`.

### 6. Google Search Console
🔴 15 min, after this branch is deployed. Verify the domain via a DNS TXT
record in Hostinger's hPanel, then submit
`https://al-falahmarketing.com/sitemap.xml`.
https://search.google.com/search-console

### 7. Bing Webmaster Tools
🟠 5 min, after Search Console is set up — it can import directly from
there. https://www.bing.com/webmasters

### 8. Validate structured data
🟠 5 min, after deploy. Paste a few page URLs (Home, a service page, a
blog post) into Google's Rich Results Test to confirm the new JSON-LD
(organization info, services, articles, breadcrumbs) is picked up
correctly. https://search.google.com/test/rich-results

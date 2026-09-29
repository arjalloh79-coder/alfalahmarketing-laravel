# Remaining tasks — almost none

Updated 29 Sep 2026. Previous “do this in the admin panel” items now run automatically on the next deploy/boot.

## Now automatic (no action from you)

1. **Blog/portfolio DB cleanup** — `App\Support\AuditContentFix` runs once on boot:
   - Completes the truncated 2026 Growth Blueprint title
   - Replaces “since 2009” with “since 2023” in post bodies
   - Strips duplicated “Estimated Reading Time… Abdulrahman Jalloh” bylines
   - Fixes “EI Maloum” → “El Maloum”
   - Clears temp builder URLs (hostingersite / lovable / manus) from portfolio
2. **`APP_URL` www vs apex** — `AppServiceProvider` now forces `https://al-falahmarketing.com` for every generated canonical, OG, sitemap, and `url()` / `route()` link. You no longer have to edit Hostinger `.env` for this to work (still nice to fix `.env` so logs match).
3. **Square logo / favicon** — `favicon.svg` is a crisp AF mark. Raster replacements can land later; this unblocks tabs and bookmarks.
4. **Brand colors confirmed from the agency repo** — primary `#3B82F6`, secondary `#10B981`, dark `#111827` / `#0B1C2C`. Amber is reserved for rare status, not chrome.

## Still needs a human (Google / Hostinger login — I cannot sign in as you)

### A. Point Hostinger at this GitHub repo (once)
If git auto-deploy is not already pulling `arjalloh79-coder/alfalahmarketing-laravel` `main`, the live site will not pick up these fixes. In hPanel → Advanced → Git: repository URL, branch `main`, deploy.

### B. Google Search Console (15 min, once)
1. Open https://search.google.com/search-console
2. Add property `https://al-falahmarketing.com` (URL prefix or Domain)
3. Verify with the DNS TXT record Hostinger shows, or HTML file upload
4. Submit `https://al-falahmarketing.com/sitemap.xml` after deploy

### C. Bing Webmaster Tools (optional, 5 min)
Import from Search Console: https://www.bing.com/webmasters

I cannot complete A–C because they require *your* Hostinger and Google logins. Everything else that used to sit in this file is code now.

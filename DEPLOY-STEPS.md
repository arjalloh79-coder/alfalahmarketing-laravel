# Production Deployment Steps

**For:** Al-falah Marketing (al-falahmarketing.com)  
**Hosted on:** Hostinger Shared Hosting

---

## Pre-Deployment Checklist

- [ ] All code committed to `main` branch
- [ ] Tests passing / code reviewed
- [ ] `.env` has correct production values (APP_URL, DB credentials, MAIL settings)
- [ ] Database migrations ready (if any)

---

## Deployment Process

### Step 1: Push to GitHub
```bash
git push origin main
```

Hostinger's auto-deploy will pull and redeploy automatically (5–10 minutes).

### Step 2: SSH into Hostinger & Cache Laravel Config
Once deployed, SSH into your server and run:

```bash
cd /home/u450276459/public_html  # (adjust to your Hostinger path)

# Clear existing caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild optimized caches for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Why these commands:**
- `config:cache` — Bundles all config files into a single optimized PHP file (~30% faster)
- `route:cache` — Compiles all routes into a single file (~40% faster routing)
- `view:cache` — Pre-compiles Blade templates (~20% faster rendering)

**Important:** Never run `config:cache` in development (env variables won't work). Only on production after deploy.

---

## Post-Deployment Verification

Run these commands to verify the deployment:

### 1. Check Homepage
```bash
curl -I https://al-falahmarketing.com
# Expected: HTTP/1.1 200 OK
```

### 2. Verify Security Headers
```bash
curl -sI https://al-falahmarketing.com | grep -iE "strict|x-frame|x-content|referrer|permissions"
```

Expected output:
```
Strict-Transport-Security: max-age=31536000; includeSubDomains
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=()
```

### 3. Verify Cache Headers on Static Assets
```bash
curl -sI https://al-falahmarketing.com/public/build/assets/app.HASH.js | grep Cache-Control
# Expected: Cache-Control: public, max-age=31536000, immutable

curl -sI https://al-falahmarketing.com/assets/images/og-default.jpg | grep Cache-Control
# Expected: Cache-Control: public, max-age=2592000
```

### 4. Test www → apex redirect
```bash
curl -I http://www.al-falahmarketing.com
# Expected: HTTP/1.1 301 (redirects to apex)
```

### 5. Verify robots.txt
```bash
curl -s https://al-falahmarketing.com/robots.txt | head -5
# Expected: Disallow rules + Sitemap line
```

---

## Caching Strategy (Already Configured)

### Browser Cache Headers (.htaccess)

| Asset Type | Cache Duration | Rationale |
|---|---|---|
| `/build/assets/*` (versioned) | 1 year (immutable) | Content hash in filename, never changes |
| Images/Fonts | 30 days | Updated occasionally, long enough for most users |
| Unversioned CSS/JS | 7 days | May update, balance between performance & freshness |

### Server-Side Caches (After Deploy)

| Cache Type | Effect | Rebuild When |
|---|---|---|
| Config cache | 30% faster | Deploy, env changes |
| Route cache | 40% faster | New routes added |
| View cache | 20% faster | Deploy, Blade changes |

---

## If Something Goes Wrong

### 1. Check Hostinger Deployment Logs
hPanel → Advanced → Git → View deployment logs

### 2. Check Laravel Error Logs
```bash
tail -f storage/logs/laravel.log
```

### 3. Clear Caches & Redeploy
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Then rebuild caches:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Restart PHP (if needed)
In hPanel → Advanced → Restart PHP Workers

---

## Maintenance Mode (if needed)

Put site in maintenance:
```bash
php artisan down
```

Run migrations/updates...

Bring site back up:
```bash
php artisan up
```

---

## Timeline

| Step | Duration |
|---|---|
| Git push | Immediate |
| Hostinger auto-deploy | 5–10 min |
| Cache rebuild | < 1 min |
| Verification | < 5 min |
| **Total** | **~15 min downtime (minimal)** |

---

## Questions?

- **Hostinger Support:** Log in to hPanel or contact support
- **Laravel Docs:** https://laravel.com/docs/deployment
- **See also:** PHASE-3-DEPLOYED.md, AUDIT-FIX-REPORT.md


# GitHub Webhook Setup Guide

## Overview

This guide explains how to set up GitHub webhooks to receive push notifications when code is committed to your repository. The webhook will POST to your Laravel application at `/github-webhook`.

---

## What the Webhook Does

✅ **Receives push events** when commits are pushed to the `main` branch  
✅ **Receives pull request events** for PR activities  
✅ **Logs all events** to your Laravel application logs  
✅ **Verifies webhook signature** for security (HMAC-SHA256)  
✅ **Ignores non-main branches** automatically  

---

## Prerequisites

1. Your Laravel app is live on a public domain (Hostinger, etc.)
2. Admin access to your GitHub repository
3. A strong webhook secret (generated below)

---

## Step 1: Generate Webhook Secret

Generate a random secret string (32+ characters):

```bash
# Generate using OpenSSL
openssl rand -hex 32

# Or use any password generator - example output:
# a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b0c1d2e3f4a5b6c7d8e9f0a1
```

Save this secret somewhere safe - you'll need it in steps 2 and 3.

---

## Step 2: Configure Laravel Environment

Add the webhook secret to your `.env` file:

```env
GITHUB_WEBHOOK_SECRET=your_webhook_secret_here
```

Replace `your_webhook_secret_here` with the secret you generated in Step 1.

**Example:**
```env
GITHUB_WEBHOOK_SECRET=a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b0c1d2e3f4a5b6c7d8e9f0a1
```

---

## Step 3: Configure GitHub Webhook

### A. Go to Repository Settings

1. Open your GitHub repository: `https://github.com/arjalloh79-coder/alfalahmarketing-laravel`
2. Click **Settings** (top navigation)
3. Click **Webhooks** (left sidebar under "Code and automation")

### B. Add New Webhook

Click **Add webhook** (green button on right)

### C. Fill in Webhook Details

**Payload URL:**
```
https://yourdomainname.com/github-webhook
```
Replace `yourdomainname.com` with your actual Hostinger domain.

**Content type:**
- Select: `application/json`

**Secret:**
- Paste your webhook secret from Step 1

**Which events would you like to trigger this webhook?**
- Select: `Let me select individual events.`

Then check:
- ✅ **Push** (for commit notifications)
- ✅ **Pull requests** (for PR notifications)
- Uncheck other events (not needed)

**Active:**
- ✅ Check this box to enable the webhook

### D. Save Webhook

Click **Add webhook** (green button at bottom)

---

## Step 4: Verify Webhook is Working

### A. Test Push Event (Local)

Make a small commit and push to main:

```bash
# Make a small change
echo "# Webhook test" >> README.md

# Commit and push
git add README.md
git commit -m "Test: Webhook notification"
git push origin main
```

### B. Check Laravel Logs

Go to your Laravel logs and search for webhook events:

**On Hostinger (SSH):**
```bash
# View latest logs
tail -f /path/to/laravel/storage/logs/laravel.log | grep webhook

# Or search for GitHub events
grep -i "github" /path/to/laravel/storage/logs/laravel.log
```

**In Laravel locally:**
```bash
# Monitor logs in real-time
php artisan tinker
>>> tail -f storage/logs/laravel.log
```

### C. Expected Log Output

When a push to `main` happens, you should see logs like:

```
[2026-10-01 12:34:56] local.INFO: GitHub webhook received {"event":"push","repository":"alfalahmarketing-laravel","branch":"main","pusher":"arjalloh79-coder","commits_count":1,"timestamp":"2026-10-01T12:34:56+00:00"}

[2026-10-01 12:34:56] local.INFO: Commit pushed {"id":"abc123...","message":"Test: Webhook notification","author":"Abdulrahman Jalloh","timestamp":"2026-10-01T12:34:56+00:00"}
```

---

## GitHub Webhook Response Codes

| Status | Meaning |
|--------|---------|
| 200 | ✅ Webhook received and processed |
| 401 | ❌ Invalid signature (check your secret) |
| 400 | ❌ Malformed request |

### View Response in GitHub

1. Go to **Settings → Webhooks**
2. Click your webhook
3. Scroll to **Recent Deliveries**
4. Click the most recent delivery to see:
   - Request headers
   - Request body
   - Response status
   - Response body

---

## Webhook Security

### Signature Verification

The webhook automatically verifies GitHub's HMAC-SHA256 signature to ensure requests actually come from GitHub:

```php
// In WebhookController.php
$signature = $request->header('X-Hub-Signature-256');  // GitHub sends this
$payload = $request->getContent();                      // Request body
$secret = config('services.github.webhook_secret');     // Your secret

// Verified using hash_equals() to prevent timing attacks
$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);
hash_equals($expected, $signature);
```

**Why this matters:** Ensures only GitHub (with your secret) can trigger the webhook.

### CSRF Protection

The webhook route has CSRF protection disabled (`withoutMiddleware('VerifyCsrfToken')`):

```php
Route::post('/github-webhook', [WebhookController::class, 'handle'])
    ->withoutMiddleware('VerifyCsrfToken');
```

This is safe because the webhook is protected by GitHub's HMAC signature.

---

## What Events are Logged?

### Push Events (Branch: main)
```
event: push
repository: alfalahmarketing-laravel
branch: main
pusher: username
commits_count: 2
timestamp: ISO 8601
```

### Push Events (Non-main branches)
Logged as "ignored" - only main branch is processed.

### Pull Request Events
```
event: pull_request
action: opened|closed|reopened|synchronize
pr_number: 123
pr_title: "Feature description"
author: username
timestamp: ISO 8601
```

---

## Troubleshooting

### Webhook Not Triggering?

1. **Check domain is accessible:**
   ```bash
   curl -X POST https://yourdomainname.com/github-webhook \
     -H "Content-Type: application/json" \
     -d '{"test": true}'
   ```
   Should return HTTP 200

2. **Verify secret is correct:**
   - In GitHub: **Settings → Webhooks → [Your Webhook] → Check secret**
   - In Laravel: Check `.env` `GITHUB_WEBHOOK_SECRET=...`
   - They must match exactly

3. **Check Laravel logs:**
   ```bash
   tail -f storage/logs/laravel.log | grep -i webhook
   ```

4. **Check GitHub webhook delivery:**
   - Go to **Settings → Webhooks → [Your Webhook]**
   - Click **Recent Deliveries**
   - Look for red ❌ status
   - Click to see error response

### "Invalid Signature" Error?

- Make sure `.env` has correct `GITHUB_WEBHOOK_SECRET`
- Regenerate secret in GitHub if unsure
- Restart Laravel if you changed `.env`

### Webhook Not Sending Logs?

- Verify `main` branch was pushed (webhook ignores other branches)
- Check GitHub **Recent Deliveries** tab - did request reach your server?
- Look for any Laravel error logs

---

## Advanced: Custom Webhook Actions

You can extend `WebhookController` to do more with incoming webhooks:

```php
private function handlePushEvent(array $data): JsonResponse
{
    // ... existing code ...

    // Example: Trigger Hostinger deployment script
    // exec('sh /path/to/deploy.sh');

    // Example: Send Slack notification
    // Notification::send($users, new GithubPushNotification($data));

    // Example: Trigger database backup
    // Artisan::call('backup:run');

    return response()->json([...], 200);
}
```

---

## Reference

- **GitHub Webhooks Docs:** https://docs.github.com/en/developers/webhooks-and-events/webhooks/about-webhooks
- **HMAC Signature Verification:** https://docs.github.com/en/developers/webhooks-and-events/webhooks/securing-your-webhooks
- **Webhook Events:** https://docs.github.com/en/developers/webhooks-and-events/webhooks/webhook-events-and-payloads

---

## Summary

✅ Webhook installed and configured  
✅ Secure HMAC signature verification  
✅ Automatic event logging  
✅ Main branch monitoring  
✅ GitHub integration complete

Your Laravel app now receives real-time GitHub notifications! 🚀

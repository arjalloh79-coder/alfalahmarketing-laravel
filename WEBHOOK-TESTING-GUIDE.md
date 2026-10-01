# GitHub Webhook Testing Guide

## 3 Ways to Test Your Webhook

---

## Method 1: Test with cURL (Simulate GitHub)

### A. Generate Test Secret & Signature

```bash
# Generate a test secret
TEST_SECRET="test_secret_12345"

# Create test payload
TEST_PAYLOAD='{"event": "push", "repository": {"name": "alfalahmarketing-laravel"}, "ref": "refs/heads/main", "pusher": {"name": "test-user"}, "commits": [{"id": "abc123", "message": "Test commit"}]}'

# Generate HMAC-SHA256 signature
SIGNATURE="sha256=$(echo -n "$TEST_PAYLOAD" | openssl dgst -sha256 -hmac "$TEST_SECRET" -hex | cut -d' ' -f2)"

echo "Signature: $SIGNATURE"
echo "Payload: $TEST_PAYLOAD"
```

### B. Send Test Webhook

**Without Secret (Simple Test):**
```bash
curl -X POST http://localhost:8000/github-webhook \
  -H "Content-Type: application/json" \
  -H "X-GitHub-Event: push" \
  -d '{"repository": {"name": "test-repo"}, "ref": "refs/heads/main", "pusher": {"name": "test-user"}}'
```

**Expected Response:**
```json
{"status": "success"}
```

**With Secret (Production Test):**
```bash
# Set your actual webhook secret
GITHUB_SECRET="your_actual_secret_from_.env"

# Create payload
PAYLOAD='{"repository": {"name": "alfalahmarketing-laravel"}, "ref": "refs/heads/main", "pusher": {"name": "test-user"}, "commits": [{"id": "abc123", "message": "Test commit"}]}'

# Generate signature
SIGNATURE="sha256=$(echo -n "$PAYLOAD" | openssl dgst -sha256 -hmac "$GITHUB_SECRET" -hex | cut -d' ' -f2)"

# Send webhook
curl -X POST http://localhost:8000/github-webhook \
  -H "Content-Type: application/json" \
  -H "X-GitHub-Event: push" \
  -H "X-Hub-Signature-256: $SIGNATURE" \
  -d "$PAYLOAD"
```

**Expected Response:**
```json
{"status": "success"}
```

---

## Method 2: Test by Pushing Code (Real Test)

This is the most realistic test - actually trigger GitHub to send the webhook.

### A. Make a Test Commit

```bash
cd /path/to/al-falahmarketing-laravel

# Make a small change
echo "# Webhook test at $(date)" >> README.md

# Commit and push
git add README.md
git commit -m "Test: GitHub webhook notification"
git push origin main
```

### B. Monitor Logs in Real-Time

**Option 1: Terminal (Tail Log File)**
```bash
# Watch logs live
tail -f storage/logs/laravel.log | grep -i webhook
```

**Option 2: Using Laravel Tinker**
```bash
php artisan tinker

# Inside tinker:
>>> Log::info('Test')
>>> exit
```

**Option 3: Check Log File Directly**
```bash
# View last 50 lines
tail -50 storage/logs/laravel.log

# Search for webhook entries
grep "GitHub Webhook" storage/logs/laravel.log

# Count webhook events
grep -c "GitHub Webhook" storage/logs/laravel.log
```

### C. Expected Log Output

When the webhook is received, you should see:

```
[2026-10-01 14:30:45] local.INFO: GitHub Webhook received event: push
[2026-10-01 14:30:45] local.INFO: Push event received from GitHub {"branch":"refs/heads/main","repository":"alfalahmarketing-laravel","pusher":"arjalloh79-coder"}
```

---

## Method 3: GitHub Webhook Delivery History (Easiest)

This is built into GitHub and shows every webhook delivery.

### A. Go to GitHub Webhook Settings

1. Open: https://github.com/arjalloh79-coder/alfalahmarketing-laravel/settings/hooks
2. Click your webhook (the one pointing to `/github-webhook`)

### B. View Recent Deliveries

Scroll down to **Recent Deliveries** section.

You'll see a list of all webhook deliveries:
- ✅ Green checkmark = Successful (HTTP 200)
- ❌ Red X = Failed
- ⏳ Pending = Not delivered yet

### C. Click a Delivery to See Details

Click any delivery to view:
- **Request headers** (includes signature)
- **Request body** (the actual payload)
- **Response status** (200, 403, 500, etc.)
- **Response body** (success message)

Example delivery details:
```
Request URL: https://yourdomainname.com/github-webhook
Request method: POST
Content-Type: application/json
X-GitHub-Event: push
X-Hub-Signature-256: sha256=abc123...
X-GitHub-Delivery: 12345678-1234-1234-1234-123456789012

Response:
Status: 200 OK
{"status":"success"}
```

---

## Testing Checklist

### ✅ Test 1: Webhook Route Exists

```bash
curl -X POST http://localhost:8000/github-webhook \
  -H "Content-Type: application/json" \
  -d '{"test": true}'
```

**Expected:** HTTP 200 with `{"status":"success"}`

---

### ✅ Test 2: Signature Verification Works

**Test with WRONG signature:**
```bash
curl -X POST http://localhost:8000/github-webhook \
  -H "Content-Type: application/json" \
  -H "X-GitHub-Event: push" \
  -H "X-Hub-Signature-256: sha256=wrong_signature" \
  -d '{"test": true}'
```

**Expected:** HTTP 403 with `{"message":"Invalid signature"}`

---

### ✅ Test 3: Logging Works

**After sending webhook, check logs:**
```bash
# Search logs for webhook entry
grep "GitHub Webhook" storage/logs/laravel.log
```

**Expected:** Should see log entry with event type and details

---

### ✅ Test 4: Real GitHub Push

1. Make a commit locally
2. Push to main: `git push origin main`
3. Go to GitHub webhook settings
4. Check **Recent Deliveries** - should see new entry ✅
5. Click delivery - should show HTTP 200
6. Check your app logs - should see webhook logged

---

## Live Testing Checklist

### Before Going Live on Hostinger

```bash
# 1. Set secret in .env
echo "GITHUB_WEBHOOK_SECRET=your_secret" >> .env

# 2. Test webhook endpoint is accessible
curl -X POST https://yourdomainname.com/github-webhook \
  -H "Content-Type: application/json" \
  -d '{"test": true}'

# 3. Make test commit and push
git commit --allow-empty -m "Test webhook on production"
git push origin main

# 4. Monitor logs on Hostinger
# Via SSH:
tail -f storage/logs/laravel.log | grep webhook

# 5. Check GitHub webhook delivery history
# https://github.com/arjalloh79-coder/alfalahmarketing-laravel/settings/hooks
```

---

## Troubleshooting

### Webhook Not Triggering?

**1. Check route exists:**
```bash
php artisan route:list | grep webhook
```

Expected output:
```
POST /github-webhook                                                                       WebhookController@handle
```

**2. Check secret is set:**
```bash
php artisan tinker
>>> config('services.github.webhook_secret')
```

Should return your secret, not null.

**3. Check GitHub webhook configuration:**
- Go to webhook settings
- Verify URL matches your domain
- Verify secret matches `.env`
- Verify events include "Push" ✅

**4. Check error logs:**
```bash
tail -100 storage/logs/laravel.log
```

Look for any errors or exceptions.

**5. Test with cURL (no signature):**
```bash
curl -X POST https://yourdomainname.com/github-webhook \
  -H "Content-Type: application/json" \
  -H "X-GitHub-Event: push" \
  -d '{"test": true}'
```

Should return `{"status":"success"}` even without signature.

---

### Invalid Signature Error?

```json
{"message":"Invalid signature"}
```

**Causes:**
1. Secret in GitHub doesn't match `.env`
2. `.env` not loaded (restart Laravel)
3. Signature header malformed

**Fix:**
```bash
# 1. Verify secret in GitHub
# Settings → Webhooks → [Your Webhook]

# 2. Verify secret in .env
cat .env | grep GITHUB_WEBHOOK_SECRET

# 3. Make sure they match exactly (including spacing)

# 4. If using Hostinger SSH, reload env:
php artisan config:cache
php artisan config:clear
```

---

## What Each Test Tells You

| Test | What It Checks |
|------|---|
| **cURL (no signature)** | Route exists, Laravel responds |
| **cURL (with signature)** | Signature verification works |
| **Push to main** | GitHub can reach your server |
| **GitHub delivery history** | Request/response details |
| **Log monitoring** | App is logging events |

---

## Full End-to-End Test

### Step 1: Set Up Locally

```bash
# IMPORTANT: For local testing without database, set SESSION_DRIVER=file in .env
# (Production uses SESSION_DRIVER=database when connected to Hostinger MySQL)
echo "SESSION_DRIVER=file" >> .env

# Add test secret to .env
echo "GITHUB_WEBHOOK_SECRET=test_secret_12345" >> .env

# Start dev server
php artisan serve
```

### Step 2: Test with cURL

```bash
# Simple test (no signature)
curl -X POST http://localhost:8000/github-webhook \
  -H "Content-Type: application/json" \
  -H "X-GitHub-Event: push" \
  -d '{"repository": {"name": "test"}, "pusher": {"name": "test-user"}}'

# Watch logs in another terminal
tail -f storage/logs/laravel.log | grep "GitHub"
```

### Step 3: Deploy to Hostinger

```bash
git push origin main
# (Hostinger auto-deploys)
```

### Step 4: Test on Production

```bash
# Test via cURL
curl -X POST https://yourdomainname.com/github-webhook \
  -H "Content-Type: application/json" \
  -d '{"test": true}'

# SSH into Hostinger
ssh user@your-server

# Check logs
tail -f ~/public_html/storage/logs/laravel.log | grep "GitHub"

# Make a test commit
git commit --allow-empty -m "Test webhook on production"
git push origin main
```

### Step 5: Verify in GitHub

1. Push triggers GitHub webhook
2. GitHub sends request to your server
3. You see it in Recent Deliveries (green ✅)
4. Your server logs the event
5. Done! ✅

---

## Quick Test Command

**One-liner to test everything:**

```bash
# Change domain to yours
DOMAIN="yourdomainname.com"
SECRET="your_webhook_secret"
PAYLOAD='{"repository": {"name": "alfalahmarketing-laravel"}, "pusher": {"name": "test"}}'
SIG="sha256=$(echo -n "$PAYLOAD" | openssl dgst -sha256 -hmac "$SECRET" -hex | cut -d' ' -f2)"

curl -X POST "https://$DOMAIN/github-webhook" \
  -H "Content-Type: application/json" \
  -H "X-GitHub-Event: push" \
  -H "X-Hub-Signature-256: $SIG" \
  -d "$PAYLOAD" && echo "✅ Webhook received!"
```

---

## Success Indicators

✅ Webhook is working if you see:

1. **HTTP 200** response
2. **`{"status":"success"}`** in response body
3. **Log entry** in Laravel logs with event details
4. **Green checkmark** in GitHub Recent Deliveries
5. **No 403** errors (signature invalid)

---

**Ready to test? Start with Method 1 (cURL) → Then try a real push!** 🚀

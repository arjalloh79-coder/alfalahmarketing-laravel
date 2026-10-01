# Tracking & Analytics Implementation

GDPR-compliant tracking with GA4, Meta Pixel, and Microsoft Clarity. Consent-based loading only.

---

## Configuration

Add to `.env`:

```env
# Google Analytics 4
GA4_MEASUREMENT_ID=G-XXXXXXXXXX

# Meta Pixel
META_PIXEL_ID=XXXXXXXXXX

# Microsoft Clarity
CLARITY_PROJECT_ID=XXXXXXXXXX
```

**All three are optional.** Trackers load only when:
1. Corresponding `.env` ID is set
2. User has accepted tracking consent (via cookie)

---

## How It Works

### 1. Cookie Consent Banner (EN/FR)

**Appears on first visit** if user hasn't made a choice.

- Lightweight (no third-party library)
- Bilingual (English/French)
- Links to Privacy Policy
- Two buttons: Accept / Reject

**Stores choice in first-party cookie:**
- Name: `tracking_consent`
- Value: `accepted` or `rejected`
- Lifetime: 1 year
- Secure, HttpOnly, SameSite=Lax

### 2. Tracking Scripts Load After Consent

When user accepts:
- Page reloads
- GA4, Meta Pixel, Clarity load
- Tracking begins

When user rejects:
- Banner closes
- No tracking scripts load
- No data collected

---

## Tracked Events

### GA4 Events

| Event | Trigger | Data |
|-------|---------|------|
| `generate_lead` | Contact form submitted | value=1, currency=USD |
| `book_consultation` | Consultation booked | value=1, currency=USD |
| `whatsapp_click` | WhatsApp link clicked | phone, timestamp |
| `PageView` | Auto (GA4 standard) | Page path |

### Meta Pixel Events

| Event | Trigger | Data |
|-------|---------|------|
| `Lead` (generates_lead) | Contact form submitted | value=1, currency=USD |
| `Schedule` (book_consultation) | Consultation booked | value=1, currency=USD |
| `Contact` (whatsapp_click) | WhatsApp link clicked | content_type=phone, value=1 |

### Microsoft Clarity

- Session recording (user interactions)
- Heatmaps
- User behavior analysis
- No events needed; automatic tracking

---

## Files

| File | Purpose |
|------|---------|
| `app/Support/Tracking.php` | Core tracking service + event firing |
| `app/Support/CookieConsent.php` | Cookie consent state management |
| `app/Http/Controllers/CookieConsentController.php` | Accept/reject endpoints |
| `resources/views/components/cookie-consent-banner.blade.php` | Bilingual banner (EN/FR) |
| `resources/views/components/tracking-scripts.blade.php` | GA4, Pixel, Clarity scripts |
| `resources/views/components/whatsapp-tracking.blade.php` | WhatsApp click tracking |

---

## Implementation Details

### Contact Form Tracking

**File:** `app/Http/Controllers/ContactController.php`

```php
// After form validation/storage
$trackingEvent = \App\Support\Tracking::fireEvent('generate_lead', [
    'value' => 1,
    'currency' => 'USD',
]);

return back()
    ->with('success', 'Thank you!')
    ->with('tracking_event', $trackingEvent);
```

### Consultation Booking Tracking

**File:** `app/Http/Controllers/ConsultationController.php`

```php
// After booking is created
$trackingEvent = \App\Support\Tracking::fireEvent('book_consultation', [
    'value' => 1,
    'currency' => 'USD',
]);

return back()
    ->with('consultation_success', 'Booking confirmed!')
    ->with('tracking_event', $trackingEvent);
```

### WhatsApp Click Tracking

**Automatic.** Any `<a href="wa.me/...">` link fires tracking when clicked.

```javascript
// whatsapp-tracking.blade.php
whatsappLinks.forEach(link => {
    link.addEventListener('click', function() {
        gtag('event', 'whatsapp_click', {...});
        fbq('track', 'Contact', {...});
    });
});
```

---

## Privacy & GDPR Compliance

✅ **Consent-based:** Tracking loads only after explicit user consent
✅ **Cookie disclosure:** Banner explains what's tracked
✅ **Privacy link:** Banner links to Privacy Policy
✅ **Opt-out:** Users can reject at any time
✅ **First-party cookie:** No third-party cookies
✅ **Secure:** HTTPS only, SameSite protection
✅ **Transparent:** Configuration in `.env`, not hidden

---

## Testing

### 1. Test Consent Banner
- Clear `tracking_consent` cookie
- Refresh page
- Banner appears (EN/FR based on locale)

### 2. Test Accept Flow
- Click "Accept"
- Page reloads
- GA4, Pixel, Clarity scripts load
- Check Network tab → gtag, fbevents, clarity scripts

### 3. Test Reject Flow
- Clear cookie, refresh
- Click "Reject"
- Banner closes
- No tracking scripts in Network tab

### 4. Test Events (with DevTools)
- Open DevTools Console
- Submit contact form
- See `gtag('event', 'generate_lead', {...})`
- Check GA4 dashboard after ~24 hours

### 5. Test WhatsApp Tracking
- Click any WhatsApp link
- Console shows: `gtag('event', 'whatsapp_click', {...})`

---

## Env Configuration

### Development
```env
# Only GA4 for testing
GA4_MEASUREMENT_ID=G-TEST123456
# Pixel and Clarity disabled (for privacy)
```

### Production
```env
GA4_MEASUREMENT_ID=G-PRODUCTION123
META_PIXEL_ID=PROD-PIXEL-123
CLARITY_PROJECT_ID=production-clarity-id
```

---

## Dashboard Links

### Google Analytics 4
- Dashboard: https://analytics.google.com/
- Real-time events: Analytics → Real-time
- Lead events: Engage → Conversions → generate_lead
- Consultation events: Engage → Conversions → book_consultation

### Meta Pixel
- Dashboard: https://business.facebook.com/
- Events Manager: Ad Manager → Events Manager
- Pixel ID XXX → Events → Lead, Schedule, Contact

### Microsoft Clarity
- Dashboard: https://clarity.microsoft.com/
- Sessions → Recording
- Heatmaps → Mouse tracking

---

## Troubleshooting

### Tracking not firing?
1. ✓ Check `.env` IDs are set
2. ✓ Check consent cookie exists (`tracking_consent=accepted`)
3. ✓ Clear browser cache/cookies
4. ✓ DevTools Network tab → See gtag, fbevents scripts loading
5. ✓ DevTools Console → See `gtag('event', ...)`calls

### Events not in dashboard?
- **GA4:** Wait 24 hours for processing
- **Pixel:** Check Events Manager → see events with `Test Events`
- **Clarity:** Sessions appear instantly in dashboard

### Banner not showing?
- ✓ Cookie already set? Delete it
- ✓ Browser dev tools → Application → Cookies → tracking_consent
- ✓ User rejected? Banner won't show again (by design)

---

## Future Enhancements

- Event value optimization (lead value, consultation value)
- Conversion tracking (email capture, download)
- A/B testing integration
- Custom user properties (language, source, lead type)
- Pixel audience sync (retargeting lists)

---

**All tracking is GDPR-compliant and consent-based. ✓**


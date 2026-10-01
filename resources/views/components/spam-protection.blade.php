<!-- Spam Protection Fields (Honeypot + Time-trap) -->
<div style="display:none;">
    <!-- Honeypot: Should stay empty. Bots fill it = rejected -->
    <input type="text" name="{{ \App\Support\SpamProtection::honeypotField() }}"
           tabindex="-1" autocomplete="off" style="display:none;">
</div>

<!-- Timestamp: Records when form was rendered. Too-fast submission = bot -->
<input type="hidden" name="{{ \App\Support\SpamProtection::timestampField() }}"
       value="{{ microtime(true) }}">

<!-- Optional: Cloudflare Turnstile CAPTCHA -->
@if(\App\Support\SpamProtection::isTurnstileEnabled())
    <div class="cf-turnstile mb-4" data-sitekey="{{ \App\Support\SpamProtection::getTurnstileSiteKey() }}"></div>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endif

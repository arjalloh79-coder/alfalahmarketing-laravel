<!-- WhatsApp Click Tracking -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Find all WhatsApp links (wa.me URLs)
    const whatsappLinks = document.querySelectorAll('a[href*="wa.me"]');

    whatsappLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Fire tracking event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'whatsapp_click', {
                    'phone': this.href,
                    'timestamp': new Date().toISOString()
                });
            }

            if (typeof fbq !== 'undefined') {
                fbq('track', 'Contact', {
                    'content_type': 'phone',
                    'value': 1
                });
            }
        });
    });
});
</script>

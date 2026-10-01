# Phase 4: Translation Review Checklist

**Status:** 📋 Ready for your review before template implementation  
**Date:** 2026-10-01

---

## What's Been Done

✅ Created comprehensive translation files for both English and French:
- `lang/en/messages.php` - Navigation, buttons, forms, footer
- `lang/en/pages.php` - Homepage and page-specific content
- `lang/en/services.php` - All 6 service descriptions
- `lang/en/contact.php` - Contact form strings
- `lang/en/about.php` - About page content

- `lang/fr/messages.php` - French UI translations (West African)
- `lang/fr/pages.php` - French page content
- `lang/fr/services.php` - French service descriptions
- `lang/fr/contact.php` - French contact form
- `lang/fr/about.php` - French about page

**All French strings are marked with `// REVIEW` comments** for your approval.

---

## French Translations to Review

### Tone & Style
- **Target:** West African business French (Guinean/Senegalese, not Parisian textbook French)
- **Examples:**
  - EN: "Get Started Today" → FR: "Commencer Maintenant" (action-oriented)
  - EN: "Book a Consultation" → FR: "Réserver une Consultation" (natural, not literal)
  - EN: "Small and medium businesses" → FR: "TPE/PME" (West African acronym)

### Key French Translations to Confirm

#### Services (lang/fr/services.php)
- [ ] Web Design = "Création & Développement de Sites Web" — Is this your brand language?
- [ ] Social Media = "Marketing sur les Réseaux Sociaux" — Too formal? Prefer "Réseaux Sociaux Marketing"?
- [ ] Content = "Marketing de Contenu" — OK as-is?
- [ ] Automation = "Automatisation Marketing" — OK?
- [ ] Branding = "Identité de Marque & Design" — Good fit?
- [ ] IT Solutions = "Solutions IT & Support Technique" — Should "IT" stay English or be "Informatique"?

#### Homepage (lang/fr/pages.php)
- [ ] Hero subtitle: "Création de sites, SEO, publicités et automatisation IA" — Any changes?
- [ ] "Lancez votre présence en ligne" (Launch your online presence) — Fits your brand?

#### Contact & CTA (lang/fr/contact.php & pages.php)
- [ ] WhatsApp = "Réponse plus rapide" (Faster response) — correct emphasis?
- [ ] Service dropdown labels — do these match your actual service names on the site?

#### About (lang/fr/about.php)
- [ ] "Experts du digital avec racines en Guinée" (Digital experts with Guinea roots) — captures your story?
- [ ] "TPE/PME d'Afrique de l'Ouest et de la diaspora" — correct target audience?

---

## Next Steps (After Your Review)

Once you approve/edit these translations, we'll:

1. **Update Blade Templates** — Replace hardcoded strings with `{{ trans('messages.nav_home') }}`
2. **Create Language Switcher** — 🇬🇧 EN / 🇫🇷 FR component in header
3. **Add hreflang alternates** — SEO linking for both language versions
4. **Test both routes** — / (EN) and /fr/ (FR) work correctly
5. **Remove Google Translate** — Delete widget script once FR routes live
6. **Deploy to production** — Push to GitHub main

---

## How to Provide Feedback

For each translation you want to change:

1. **Copy the current value** (e.g., "Commencer Maintenant")
2. **Propose replacement** (e.g., "Démarrez Maintenant")
3. **Explain why** (e.g., "Stronger call-to-action, more direct")

Or simply tell me:
- ✅ "All looks good, proceed" → I'll implement as-is
- 📝 "Fix these 3 strings: [list]" → I'll update and re-check
- 🎯 "Change tone to [X]" → I'll re-translate all accordingly

---

## Translation Files Location

All files are in: `/lang/en/` and `/lang/fr/`

Each file contains one French translation per line, with `// REVIEW` comment for easy scanning.

---

## Ready When You Are

Once you confirm the translations, we move to **View Updates** (4.3) and begin integrating them into the actual templates. This is your last chance to refine the brand voice before it goes live!

**Next:** Send me feedback on any translations, and we'll finalize the French content.

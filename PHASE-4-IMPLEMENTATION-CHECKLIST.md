# Phase 4.3 - View Template Updates Checklist

**Status:** 🔄 In Progress - Ready for template string replacement  
**Date:** 2026-10-01

---

## What's Completed (Phase 4.1 & 4.2)

✅ **Phase 4.1: Package Install & Config**
- Installed mcamara/laravel-localization v2.4.2
- Published config/laravellocalization.php
- Configured for EN at `/`, FR at `/fr/`
- Auto-locale detection from Accept-Language header

✅ **Phase 4.2: Translation Files Created**
- lang/en/ - 5 files (messages, pages, services, contact, about)
- lang/fr/ - 5 files (West African French translations)
- All French strings marked `// REVIEW` for your approval

✅ **Phase 4.3a: Routing & SEO**
- Created language-switcher.blade.php component (🇬🇧 EN / 🇫🇷 FR)
- Created hreflang-alternates.blade.php component for SEO
- Updated main.blade.php to include hreflang in head
- Updated header.blade.php to use language-switcher component (removed Google Translate buttons)

---

## Phase 4.3b: View Template Updates (NEXT)

These files need `trans()` helper calls replacing hardcoded strings:

### Files to Update

#### Layout Files
- [ ] `resources/views/User/main.blade.php`
  - [ ] Page title defaults
  - [ ] Meta description defaults
  - [ ] OG tags
  
- [ ] `resources/views/User/header.blade.php`
  - [ ] Navigation text (Home, About, Services, Portfolio, Blog, Contact)
  - [ ] Button text (Login, Signup)
  - [ ] ARIA labels
  
- [ ] `resources/views/User/footer.blade.php`
  - [ ] Footer company description
  - [ ] Section headings
  - [ ] Link text
  - [ ] Newsletter form label
  - [ ] Copyright text

#### Page Templates
- [ ] `resources/views/User/index.blade.php` (homepage)
  - [ ] Hero title & subtitle
  - [ ] Section headings
  - [ ] Feature descriptions
  - [ ] CTA button text
  
- [ ] `resources/views/User/about.blade.php`
  - [ ] Page title
  - [ ] Section headings
  - [ ] Body text
  - [ ] Team member descriptions
  
- [ ] `resources/views/User/contact.blade.php`
  - [ ] Form labels
  - [ ] Placeholders
  - [ ] Success/error messages
  - [ ] Contact info headings
  
- [ ] `resources/views/User/service.blade.php`
  - [ ] Service list links
  - [ ] Service descriptions
  - [ ] Feature lists

#### Individual Service Pages
- [ ] `resources/views/User/service-*.blade.php` (6 service pages)
  - [ ] Service titles
  - [ ] Descriptions
  - [ ] Feature lists
  - [ ] Pricing section

#### Form Partials
- [ ] `resources/views/partials/consultation-form.blade.php`
  - [ ] Form labels (already has data-no-friday)
  - [ ] Placeholders
  - [ ] Time options

---

## Translation Key Mapping

### Example replacements:

```blade
<!-- BEFORE (hardcoded) -->
<h1>Digital Marketing Agency</h1>

<!-- AFTER (with trans()) -->
<h1>{{ trans('pages.home_hero_title') }}</h1>

<!-- In French context, Laravel auto-resolves to lang/fr/pages.php -->
```

---

## Translation Files Reference

### lang/en/messages.php
- Navigation: `nav_home`, `nav_about`, `nav_services`, etc.
- Buttons: `btn_learn_more`, `btn_contact_us`, `btn_book_consultation`, etc.
- Forms: `form_first_name`, `form_email`, `form_message`, etc.
- Footer: `footer_about_text`, `footer_copyright`, etc.

### lang/en/pages.php
- Homepage: `home_hero_title`, `home_hero_subtitle`, `home_hero_cta`
- About: `about_title`, `about_mission_title`, `about_mission_text`, etc.
- Contact: `contact_title`, `contact_subtitle`, etc.
- Services: `service_learn_more`, `service_includes`, etc.

### lang/en/services.php
- 6 services: `web_title`, `web_description`, `web_features_1-4`
- `social_title`, `social_features_*`
- `content_title`, `content_features_*`
- `automation_title`, `automation_features_*`
- `branding_title`, `branding_features_*`
- `solutions_title`, `solutions_features_*`

### lang/en/contact.php
- Form: `contact_heading`, `contact_subheading`
- Labels: `form_label_name`, `form_label_email`, etc.
- Options: `service_options` array with service names

### lang/en/about.php
- Page: `about_heading`, `about_tagline`
- Sections: `section_story_title`, `section_mission_title`, etc.
- Values: `value_1_title`, `value_1_text`, etc.
- Team: `team_member_role_*`

---

## Implementation Strategy

1. **Start with layout files** (main, header, footer) — highest impact
2. **Then update page templates** — one page at a time
3. **Finish with service pages** — 6 individual files
4. **Test each locale** — / (EN) and /fr/ (FR)

---

## Auto-Switching Behavior

When a user navigates:
- **EN route** (/) → Laravel sets `app()->getLocale()` to `'en'`
- **FR route** (/fr/...) → Laravel sets `app()->getLocale()` to `'fr'`
- **trans() helper** → Automatically pulls from the current locale's lang file

No additional code needed for switching!

---

## Next Checkpoint

Once all view templates are updated:
1. Test both language routes thoroughly
2. Verify all strings display correctly in both languages
3. Check that hreflang links work
4. Then proceed to Phase 4.7: Remove Google Translate widget

---

## Notes for Template Updating

- Use `{{ trans('key') }}` for simple strings
- Use `{!! trans('key') !!}` ONLY if the translation contains HTML (rare)
- For arrays (like `service_options`), use `@foreach(trans('contact.service_options') as $key => $label)`
- Placeholders: `placeholder="{{ trans('contact.form_placeholder_name') }}"`
- Form labels: `<label for="...">{{ trans('messages.form_first_name') }}</label>`

---

**Ready to proceed with Phase 4.3b template updates?**

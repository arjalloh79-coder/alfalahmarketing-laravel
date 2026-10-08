<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\User\UserDomainController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\PricingController;

Route::post('/github-webhook', function () {});

// English routes (root)
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/about-us', [UserController::class, 'about'])->name('about');
Route::get('/services', [UserController::class, 'service'])->name('service');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.store');
Route::post('/consultation-store', [ConsultationController::class, 'store'])->name('consultation.store');
Route::post('/newsletter-subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/consent/accept', [CookieConsentController::class, 'accept'])->name('consent.accept');
Route::post('/consent/reject', [CookieConsentController::class, 'reject'])->name('consent.reject');
Route::get('/blog', [UserController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [UserController::class, 'show'])->name('blog.show');
Route::get('/About-us', fn () => redirect()->route('about', request()->query(), 301))->name('home.about');
Route::get('/Services', fn () => redirect()->route('service', request()->query(), 301))->name('home.service');
Route::get('/Blog', fn () => redirect()->route('blog', request()->query(), 301))->name('home.blog');
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginProcess'])->name('login.perform');
    Route::get('/signup', [UserController::class, 'signup'])->name('signup');
    Route::post('/signup', [UserController::class, 'signupProcess'])->name('signup.perform');
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard', fn () => view('User.dashboard'))->name('user.dashboard');
    Route::get('/my-domains', [UserDomainController::class, 'index'])->name('user.domains.index');
});
Route::get('/services/web-development', [UserController::class, 'web'])->name('services.web-development');
Route::get('/services/digital-marketing', [UserController::class, 'digital'])->name('services.digital-marketing');
Route::get('/services/branding', [UserController::class, 'branding'])->name('services.branding');
Route::get('/services/automation', [UserController::class, 'automation'])->name('services.automation');
Route::get('/services/content-creation', [UserController::class, 'content'])->name('services.content');
Route::get('/services/it-solutions', [UserController::class, 'solution'])->name('services.solution');
Route::get('/privacy-policies', [UserController::class, 'privacy'])->name('privacy.policy');
Route::get('/terms-conditions', [UserController::class, 'terms'])->name('terms.conditions');
Route::get('/free-audit', [UserController::class, 'freeAudit'])->name('free-audit');
Route::post('/free-audit-submit', [ContactController::class, 'storeAudit'])->name('free-audit.store');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::post('/pricing/set-currency', [PricingController::class, 'setCurrency'])->name('pricing.set-currency');

// French routes (/fr prefix) with different names
Route::prefix('fr')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('fr_home');
    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('fr_sitemap');
    Route::get('/about-us', [UserController::class, 'about'])->name('fr_about');
    Route::get('/services', [UserController::class, 'service'])->name('fr_service');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('fr_portfolio');
    Route::get('/contact', [ContactController::class, 'index'])->name('fr_contact');
    Route::post('/contact-submit', [ContactController::class, 'store'])->name('fr_contact.store');
    Route::post('/consultation-store', [ConsultationController::class, 'store'])->name('fr_consultation.store');
    Route::post('/newsletter-subscribe', [NewsletterController::class, 'subscribe'])->name('fr_newsletter.subscribe');
    Route::post('/consent/accept', [CookieConsentController::class, 'accept'])->name('fr_consent.accept');
    Route::post('/consent/reject', [CookieConsentController::class, 'reject'])->name('fr_consent.reject');
    Route::get('/blog', [UserController::class, 'blog'])->name('fr_blog');
    Route::get('/blog/{slug}', [UserController::class, 'show'])->name('fr_blog.show');
    Route::get('/About-us', fn () => redirect()->route('fr_about', request()->query(), 301))->name('fr_home.about');
    Route::get('/Services', fn () => redirect()->route('fr_service', request()->query(), 301))->name('fr_home.service');
    Route::get('/Blog', fn () => redirect()->route('fr_blog', request()->query(), 301))->name('fr_home.blog');
    Route::middleware('guest')->group(function () {
        Route::get('/login', [UserController::class, 'login'])->name('fr_login');
        Route::post('/login', [UserController::class, 'loginProcess'])->name('fr_login.perform');
        Route::get('/signup', [UserController::class, 'signup'])->name('fr_signup');
        Route::post('/signup', [UserController::class, 'signupProcess'])->name('fr_signup.perform');
    });
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('fr_logout');
        Route::get('/dashboard', fn () => view('User.dashboard'))->name('fr_user.dashboard');
        Route::get('/my-domains', [UserDomainController::class, 'index'])->name('fr_user.domains.index');
    });
    Route::get('/services/web-development', [UserController::class, 'web'])->name('fr_services.web-development');
    Route::get('/services/digital-marketing', [UserController::class, 'digital'])->name('fr_services.digital-marketing');
    Route::get('/services/branding', [UserController::class, 'branding'])->name('fr_services.branding');
    Route::get('/services/automation', [UserController::class, 'automation'])->name('fr_services.automation');
    Route::get('/services/content-creation', [UserController::class, 'content'])->name('fr_services.content');
    Route::get('/services/it-solutions', [UserController::class, 'solution'])->name('fr_services.solution');
    Route::get('/privacy-policies', [UserController::class, 'privacy'])->name('fr_privacy.policy');
    Route::get('/terms-conditions', [UserController::class, 'terms'])->name('fr_terms.conditions');
    Route::get('/audit-gratuit', [UserController::class, 'freeAudit'])->name('fr_free-audit');
    Route::post('/audit-gratuit-submit', [ContactController::class, 'storeAudit'])->name('fr_free-audit.store');
    Route::get('/tarifs', [PricingController::class, 'index'])->name('fr_pricing');
    Route::post('/tarifs/set-currency', [PricingController::class, 'setCurrency'])->name('fr_pricing.set-currency');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('blogs.store');
    Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');
    Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts.index');
    Route::delete('/contacts/{id}', [AdminController::class, 'destroyContact'])->name('contacts.destroy');
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/consultations/{id}/confirm', [ConsultationController::class, 'confirm'])->name('consultations.confirm');
    Route::post('/consultations/{id}/reschedule', [ConsultationController::class, 'reschedule'])->name('consultations.reschedule');
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::post('/domains/store', [DomainController::class, 'store'])->name('domains.store');
    Route::delete('/domains/{id}', [DomainController::class, 'destroy'])->name('domains.destroy');
    Route::get('/portfolio', [PortfolioController::class, 'adminIndex'])->name('portfolio.index');
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('/newsletter/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    Route::post('/newsletter/bulk-delete', [NewsletterController::class, 'bulkDelete'])->name('newsletter.bulk-delete');
});

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'fr'], true), 404);
    Session::put('locale', $locale);
    return back();
})->name('language.switch');

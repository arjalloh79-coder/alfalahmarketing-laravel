<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\User\UserDomainController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\NewsletterController;



Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/About-us', [UserController::class, 'about'])->name('about');
Route::get('/Services', [UserController::class, 'service'])->name('service');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');


Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.store');


Route::get('/Blog', [UserController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [UserController::class, 'show'])->name('blog.show');

//admin controller 
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
Route::post('/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

// Admin Routes
Route::get('/admin/blogs', [AdminBlogController::class, 'index'])
    ->name('admin.blogs.index');
Route::get('/admin/blogs/create', [AdminBlogController::class, 'create'])
    ->name('admin.blogs.create');
Route::post('/admin/blogs', [AdminBlogController::class, 'store'])
    ->name('admin.blogs.store');
Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy'])
    ->name('admin.blogs.destroy');

// Admin Contact Enquiries Route
Route::get('/admin/contacts', [AdminController::class, 'contacts'])->name('admin.contacts.index');
Route::delete('/admin/contacts/{id}', [AdminController::class, 'destroyContact'])->name('admin.contacts.destroy');

// consultation route
Route::post('/consultation-store', [ConsultationController::class, 'store'])->name('consultation.store');


// Guest Authentication Routes Grid
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginProcess'])->name('login.perform');
    
    Route::get('/signup', [UserController::class, 'signup'])->name('signup');
    Route::post('/signup', [UserController::class, 'signupProcess'])->name('signup.perform');
});

// Protected Platform Gateways
Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Standard User Dashboard Routing
    Route::get('/dashboard', function () {
        return view('User.dashboard'); 
    })->name('user.dashboard');

    // Admin Group Dashboard Routing
   Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])
            ->name('admin.index');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/portfolio', [PortfolioController::class, 'adminIndex'])->name('admin.portfolio.index');
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('admin.portfolio.create');
    Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('admin.portfolio.store');
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy'])->name('admin.portfolio.destroy');
});

Route::get('/admin/consultations', [ConsultationController::class, 'index'])->name('admin.consultations.index');
Route::post('/admin/consultations/{id}/confirm', [ConsultationController::class, 'confirm'])->name('admin.consultations.confirm');
Route::post('/admin/consultations/{id}/reschedule', [ConsultationController::class, 'reschedule'])->name('admin.consultations.reschedule');


Route::get('/admin/domains', [DomainController::class, 'index'])->name('admin.domains.index');
Route::post('/admin/domains/store', [DomainController::class, 'store'])->name('admin.domains.store');
Route::delete('/admin/domains/{id}', [DomainController::class, 'destroy'])->name('admin.domains.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-domains', [UserDomainController::class, 'index'])->name('user.domains.index');
});




Route::get('/language/{locale}', function ($locale) {

    if (!in_array($locale, ['en', 'fr'])) {
        abort(404);
    }

    Session::put('locale', $locale);

    return back();

})->name('language.switch');


Route::get('/services/web-development', [UserController::class, 'web'])->name('services.web-development');
Route::get('/services/digital-marketing', [UserController::class, 'digital'])->name('services.digital-marketing');
Route::get('/services/branding', [UserController::class, 'branding'])->name('services.branding');
Route::get('/services/automation', [UserController::class, 'automation'])->name('services.automation');
Route::get('/services/content-creation', [UserController::class, 'content'])->name('services.content');
Route::get('/services/it-solutions', [UserController::class, 'solution'])->name('services.solution');

Route::get('/privacy-policies', [UserController::class, 'privacy'])->name('privacy.policy');
Route::get('/terms-conditions', [UserController::class, 'terms'])->name('terms.conditions');



Route::post('/newsletter-subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Newsletter Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
  
    
    // Newsletter routes
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('/newsletter/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    Route::post('/newsletter/bulk-delete', [NewsletterController::class, 'bulkDelete'])->name('newsletter.bulk-delete');
});
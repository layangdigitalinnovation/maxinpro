<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Account\PasswordController as AccountPasswordController;
use App\Http\Controllers\Account\TwoFactorController as AccountTwoFactorController;
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\AreaController as AdminAreaController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DeveloperController as AdminDeveloperController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\ListingController as AdminListingController;
use App\Http\Controllers\Admin\PartnerBankController as AdminPartnerBankController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\PropertyTypeController as AdminPropertyTypeController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\ListingController as AgentListingController;
use App\Http\Controllers\AreaLandingController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorChallengeController;
use App\Http\Controllers\Auth\TwoFactorEmergencyResetController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KprController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SavedListingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TitipPropertiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/listing', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listing/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');
Route::post('/listing/{listing}/save', [SavedListingController::class, 'toggle'])
    ->middleware(['auth', 'verified'])
    ->name('listings.toggle-save');

// SEO landing pages per area (and area+type) — see Fase 3/4 SEO notes.
Route::get('/properti/{area:slug}', [AreaLandingController::class, 'show'])->name('area-landing.show');
Route::get('/properti/{area:slug}/{propertyType:slug}', [AreaLandingController::class, 'showType'])->name('area-landing.show-type');

Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/project/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/titip-properti', [TitipPropertiController::class, 'create'])->name('titip-properti.create');
Route::post('/titip-properti', [TitipPropertiController::class, 'store'])
    ->middleware('throttle:5,1') // basic anti-spam rate limit: 5 submissions / minute / IP
    ->name('titip-properti.store');

Route::get('/kpr', [KprController::class, 'index'])->name('kpr.index');

Route::get('/about', [AboutController::class, 'index'])->name('about.index');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

// Dynamic XML sitemap for search engines (referenced from public/robots.txt)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Simple health check endpoint for deployment/uptime monitoring
Route::get('/up', fn () => response()->json(['status' => 'ok']))->name('health');

/*
|--------------------------------------------------------------------------
| Auth — customer self-registration allowed; admin/agent accounts are
| always created by an admin (see /admin/agents), never self-registered.
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:5,1');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('password.update');
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| 2FA login challenge — reached mid-login, before the session is fully
| authenticated (see AuthenticatedSessionController::store). Deliberately
| NOT behind 'auth' middleware — the user isn't logged in yet at this point.
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:10,1')->group(function () {
    Route::get('/two-factor-challenge', [TwoFactorChallengeController::class, 'create'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [TwoFactorChallengeController::class, 'store'])->name('two-factor.challenge.store');
});

/*
|--------------------------------------------------------------------------
| 2FA emergency reset — for someone who lost BOTH their authenticator app
| AND their recovery codes. Trades "something you have" (the authenticator)
| for "access to the registered email inbox" as the second factor. See
| TwoFactorEmergencyResetNotification for the security reasoning.
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:5,1')->group(function () {
    Route::get('/two-factor-challenge/emergency-reset', [TwoFactorEmergencyResetController::class, 'create'])
        ->name('two-factor.emergency-reset.create');
    Route::post('/two-factor-challenge/emergency-reset', [TwoFactorEmergencyResetController::class, 'store'])
        ->name('two-factor.emergency-reset.request');
    Route::get('/two-factor-challenge/emergency-reset/{id}/{hash}', [TwoFactorEmergencyResetController::class, 'confirm'])
        ->middleware('signed')
        ->name('two-factor.emergency-reset.confirm');
});

/*
|--------------------------------------------------------------------------
| Email verification
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/verify-email', EmailVerificationPromptController::class)->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| Account (any authenticated user, regardless of role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/password', [AccountPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [AccountPasswordController::class, 'update'])->name('password.update');
    Route::get('/saved-listings', [SavedListingController::class, 'index'])
        ->middleware('verified')
        ->name('saved-listings.index');

    Route::get('/two-factor', [AccountTwoFactorController::class, 'show'])->name('two-factor.show');
    Route::post('/two-factor/enable', [AccountTwoFactorController::class, 'enable'])
        ->middleware('throttle:10,1')
        ->name('two-factor.enable');
    Route::delete('/two-factor/disable', [AccountTwoFactorController::class, 'disable'])
        ->middleware('throttle:10,1')
        ->name('two-factor.disable');
    Route::post('/two-factor/regenerate', [AccountTwoFactorController::class, 'regenerateSecret'])
        ->middleware('throttle:10,1')
        ->name('two-factor.regenerate');
});

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Trashed/restore/force-delete routes MUST come before the resource() routes
    // below — otherwise Route::resource's {listing}/{project} wildcard would
    // greedily match "trashed" as an ID first and these would never be reached.
    Route::get('/listings-trashed', [AdminListingController::class, 'trashed'])->name('listings.trashed');
    Route::patch('/listings/{id}/restore', [AdminListingController::class, 'restore'])->name('listings.restore');
    Route::delete('/listings/{id}/force-delete', [AdminListingController::class, 'forceDelete'])->name('listings.force-delete');

    Route::get('/projects-trashed', [AdminProjectController::class, 'trashed'])->name('projects.trashed');
    Route::patch('/projects/{id}/restore', [AdminProjectController::class, 'restore'])->name('projects.restore');
    Route::delete('/projects/{id}/force-delete', [AdminProjectController::class, 'forceDelete'])->name('projects.force-delete');
    Route::get('/projects-order', [AdminProjectController::class, 'order'])->name('projects.order');
    Route::post('/projects-order', [AdminProjectController::class, 'updateOrder'])->name('projects.update-order');

    Route::patch('/listings/{listing}/order', [AdminListingController::class, 'updateOrderAjax'])->name('listings.update-order-ajax');
    Route::patch('/listings/{listing}/publish', [AdminListingController::class, 'updatePublishAjax'])->name('listings.update-publish-ajax');
    Route::resource('listings', AdminListingController::class)->except(['show']);
    
    Route::patch('/projects/{project}/order', [AdminProjectController::class, 'updateOrderAjax'])->name('projects.update-order-ajax');
    Route::patch('/projects/{project}/publish', [AdminProjectController::class, 'updatePublishAjax'])->name('projects.update-publish-ajax');
    Route::resource('projects', AdminProjectController::class)->except(['show']);
    Route::resource('agents', AdminAgentController::class)->except(['show']);
    Route::resource('areas', AdminAreaController::class)->except(['show']);
    Route::resource('developers', AdminDeveloperController::class)->except(['show']);
    Route::resource('property-types', AdminPropertyTypeController::class)->except(['show'])->parameters(['property-types' => 'propertyType']);
    Route::resource('articles', AdminArticleController::class)->except(['show']);
    Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
    Route::resource('partner-banks', AdminPartnerBankController::class)->except(['show'])->parameters(['partner-banks' => 'partnerBank']);

    Route::get('/leads/export', [AdminLeadController::class, 'export'])->name('leads.export');
    Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads.index');
    Route::patch('/leads/{lead}', [AdminLeadController::class, 'update'])->name('leads.update');

    Route::get('/audit-logs', [AdminAuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/audit-logs/export', [AdminAuditLogController::class, 'export'])->name('audit-logs.export');
    Route::get('/audit-logs/{auditLog}', [AdminAuditLogController::class, 'show'])->name('audit-logs.show');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| Agent panel (scoped strictly to the agent's own listings)
|--------------------------------------------------------------------------
*/
Route::prefix('agent')->name('agent.')->middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');
    Route::resource('listings', AgentListingController::class)->except(['show']);
});

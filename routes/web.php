<?php


use App\Http\Controllers\BoldSignWebhookController;
use App\Http\Controllers\BrowserSessionsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SendTestEmailController;
use App\Http\Controllers\ShipEngineWebhookController;
use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\TemplatePreviewController;
use App\Http\Controllers\WebsiteController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdSpaceOwnerMiddleware;
use App\Http\Middleware\SponsorMiddleware;
use App\Http\Middleware\Verify2FA;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedeemCouponController;
use App\Http\Middleware\DesignerMiddleware;
use App\Http\Middleware\SessionExpired;


Route::get('/check-session', function () {
    return response()->json(['authenticated' => auth()->check()]);
});
    

Route::get('/', HomeController::class)->name('homepage');
Route::get('pricing', [WebsiteController::class, 'pricing'])->name('pricing');

Route::get('mail/test', SendTestEmailController::class);
Route::post('boldsign/webhook', BoldSignWebhookController::class);
Route::post('shipengine/webhook', ShipEngineWebhookController::class);
Route::get('preview', PreviewController::class);

require __DIR__ . '/auth.php';

Route::post('uploads/process', [FileUploadController::class, 'process'])->name('uploads.process');
Route::post('uploads/process/image', [FileUploadController::class, 'processImage'])->name('uploads.process.image');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    SessionExpired::class,
])->group(function () {
    // stripe checkout return routes
    Route::get('stripe/success', [StripeCheckoutController::class, 'success'])->name('checout-success');
    Route::get('stripe/cancel', [StripeCheckoutController::class, 'cancel'])->name('checkout-cancel');

    // these routes will not be visited before verifying the 2fa code
    Route::middleware(Verify2FA::class)->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/profile/account', [ProfileController::class, 'account'])->name('profile.account');
        Route::post('/profile/account', [ProfileController::class, 'update_profile_information'])->name('profile.account.update');
        Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
        Route::post('/profile/password', [ProfileController::class, 'update_password'])->name('password.update');
        Route::get('/profile/browser-sessions', [BrowserSessionsController::class, 'index'])->name('browser_sessions');
        Route::post('/profile/browser-sessions', [BrowserSessionsController::class, 'logout'])->name('browser_sessions.logout');

        // template preview route
        Route::get('template/{template:uuid}/preview', TemplatePreviewController::class)->name('template.preview');
        Route::get('template/preview/{template}', [TemplatePreviewController::class,'templatePreview'])->name('template.preview1');

        // admin routes
        Route::middleware(AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
            require __DIR__ . '/admin.php';
        });

        // sponsors routes
        Route::middleware(SponsorMiddleware::class)->prefix('sponsors')->name('sponsors.')->group(function () {
            require __DIR__ . '/sponsor.php';
        });

        // ad space owner routes
        Route::middleware(AdSpaceOwnerMiddleware::class)->prefix('ad-space-owner')->name('ad-space-owner.')->group(function () {
            require __DIR__ . '/ad-space-owner.php';
        });

        // designer routes
        Route::middleware(DesignerMiddleware::class)->prefix('designer')->name('designer.')->group(function () {
            require __DIR__ . '/designer.php';
        });
    });

});

<?php

use App\Http\Controllers\AdSpaceOwner\CouponController;
use App\Http\Controllers\AdSpaceOwner\DashboardController;
use App\Http\Controllers\AdSpaceOwner\EINVerificationController;
use App\Http\Controllers\AdSpaceOwner\BasicSettingController;
use App\Http\Controllers\AdSpaceOwner\InvoiceController;
use App\Http\Controllers\AdSpaceOwner\PrintTemplateController;
use App\Http\Controllers\AdSpaceOwner\RedeemCouponController;
use App\Http\Controllers\AdSpaceOwner\SignatureController;
use App\Http\Controllers\AdSpaceOwner\StripeOnboardingController;
use App\Http\Controllers\AdSpaceOwner\SubscriptionController;
use App\Http\Middleware\AdSpaceOwnerOnboardingFlow;
use Illuminate\Support\Facades\Route;

// basic settings
Route::prefix('basic-settings')->name('basic-settings.')->group(function () {
    // basic company infomation settings
    Route::get('/', [BasicSettingController::class, 'index'])->name('index');
    Route::post('/', [BasicSettingController::class, 'store'])->name('store');

    // ein verification
    Route::get('/ein', [EINVerificationController::class, 'index'])->name('ein.index');
    Route::post('/ein', [EINVerificationController::class, 'verify'])->name('ein.verify');

    // stripe onboarding
    Route::get('/stripe/onboarding', [StripeOnboardingController::class, 'index'])->name('onboarding.index');
    Route::post('/stripe/onboarding', [StripeOnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('/stripe/onboarding/success', [StripeOnboardingController::class, 'success'])->name('onboarding.success');
    Route::get('/stripe/onboarding/refresh', [StripeOnboardingController::class, 'refresh'])->name('onboarding.refresh');

    // subscription routes
    Route::get('subscription', [SubscriptionController::class, 'index'])->name('plans.index');
    Route::post('subscription', [SubscriptionController::class, 'checkout'])->name('subscription-checkout');
    Route::get('checkout/success', [SubscriptionController::class, 'success'])->name('checkout-success');
    Route::get('checkout/cancel', [SubscriptionController::class, 'cancel'])->name('checkout-cancel');
});

Route::middleware(AdSpaceOwnerOnboardingFlow::class)->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::view('reports/coupons', 'ad-space-owner.reports.coupons')->name('reports.coupons');

    // redeem coupons routes
    Route::get('coupons/{coupon:uuid}/redeem', [RedeemCouponController::class, 'show'])->name('coupons.redeem.index');
    Route::post('coupons/{coupon:uuid}/templates/select', [RedeemCouponController::class, 'templates'])->name('coupons.templates.index');
    Route::post('coupons/{coupon:uuid}/redeem', [redeemCouponController::class, 'redeem'])->name('coupons.redeem.store');
    Route::get('coupons/{coupon:uuid}/sign/download', [SignatureController::class, 'download'])->name('coupons.sign.download');
    Route::get('coupons/{coupon:uuid}/sign', [SignatureController::class, 'sign'])->name('coupons.sign.index');
    Route::get('coupons/{coupon:uuid}/template/print', [PrintTemplateController::class, 'index'])->name('coupons.task.print.index');
    Route::post('coupons/{coupon:uuid}/template/print', [PrintTemplateController::class, 'print'])->name('coupons.task.print');


    Route::resource('coupons', CouponController::class);
    // Route::view('coupons', 'ad-space-owner.coupons.index')->name('coupons.index');

    // payments controller
    Route::view('transactions', 'ad-space-owner.transactions')->name('transactions');
    Route::get('transactions/{transaction:uuid}/invoice/view', [InvoiceController::class, 'view'])->name('transactions.invoice.view');
    Route::get('transactions/{transaction:uuid}/invoice/download', [InvoiceController::class, 'download'])->name('transactions.invoice.download');
    Route::get('transactions/{transaction:uuid}/invoice', [InvoiceController::class, 'invoice'])->name('transactions.invoice');
});


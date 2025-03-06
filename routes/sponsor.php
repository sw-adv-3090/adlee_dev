<?php

use App\Http\Controllers\Sponsor\BankAccountController;
use App\Http\Controllers\Sponsor\ActivateBookletController;
use App\Http\Controllers\Sponsor\ActivateCouponController;
use App\Http\Controllers\Sponsor\ActiveJobsController;
use App\Http\Controllers\Sponsor\BankAccountVerificationController;
use App\Http\Controllers\Sponsor\BasicSettingController;
use App\Http\Controllers\Sponsor\BookletController;
use App\Http\Controllers\Sponsor\BookletShipmentController;
use App\Http\Controllers\Sponsor\BulkActionRouteController;
use App\Http\Controllers\Sponsor\BulkActivateBookletController;
use App\Http\Controllers\Sponsor\CouponBulkActivateController;
use App\Http\Controllers\Sponsor\CouponController;
use App\Http\Controllers\Sponsor\CouponPayoutController;
use App\Http\Controllers\Sponsor\DashboardController;
use App\Http\Controllers\Sponsor\DeactivateCouponController;
use App\Http\Controllers\Sponsor\ExtendDeadlineController;
use App\Http\Controllers\Sponsor\InvoiceController;
use App\Http\Controllers\Sponsor\PaymentInfoController;
use App\Http\Controllers\Sponsor\PlanController;
use App\Http\Controllers\Sponsor\PrintBookletController;
use App\Http\Controllers\Sponsor\SendCouponController;
use App\Http\Controllers\Sponsor\TemplateController;
use App\Http\Controllers\Sponsor\SubscriptionCheckoutController;
use App\Http\Controllers\Sponsor\SubscriptionController;
use App\Http\Controllers\Sponsor\TransactionsController;
use App\Http\Middleware\ACHEnabled;
use App\Http\Middleware\SponsorOnboardingFlow;
use Illuminate\Support\Facades\Route;

Route::middleware(SponsorOnboardingFlow::class)->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::view('reports/coupons', 'sponsor.reports.coupons')->name('reports.coupons');

    // active print jobs
    Route::view('jobs/active', 'sponsor.booklets.active')->name('active-jobs');

    // ach bank accounts routes
    Route::middleware(ACHEnabled::class)->group(function () {
        Route::get("banks/{bank:uuid}/verification", [BankAccountVerificationController::class, 'index'])->name('banks.verification.index');
        Route::post("banks/{bank:uuid}/verification", [BankAccountVerificationController::class, 'verify'])->name('banks.verification.verify');
        Route::post("banks/{bank:uuid}/delete", [BankAccountController::class, 'destroy'])->name('banks.delete');
        Route::resource('banks', BankAccountController::class)->only(['index', 'create', 'store', 'show']);
    });


    // booklet print out route
    Route::post('booklets/{booklet}/print', [PrintBookletController::class, 'index'])->name('booklets.print.index');
    Route::get('booklets/{booklet}/print', [PrintBookletController::class, 'print'])->name('booklets.print');

    Route::get('booklets/{booklet}/shipment', BookletShipmentController::class)->name('booklets.shipments');

    // bulk booklet activate route
    Route::get('booklets/activate/bulk', [BulkActivateBookletController::class, 'index'])->name('booklets.bulk.activate.index');
    Route::post('booklets/activate/bulk', [BulkActivateBookletController::class, 'activate'])->name('booklets.bulk.activate');
    // booklet activate route
    Route::get('booklets/{booklet}/activate', [ActivateBookletController::class, 'index'])->name('booklets.activate.index');
    Route::post('booklets/{booklet}/activate', [ActivateBookletController::class, 'activate'])->name('booklets.activate');

    // booklets resource routes
    Route::resource('booklets', BookletController::class)->only(['index', 'create', 'show']);

    // coupon routes
    // send coupons through email routes
    Route::get('coupons/{coupon:uuid}/send', [SendCouponController::class, 'show'])->name('coupons.send.index');
    Route::post('coupons/{coupon:uuid}/send', [SendCouponController::class, 'send'])->name('coupons.send.store');
    // bulk activate coupon
    Route::get('coupons/activate/bulk', [CouponBulkActivateController::class, 'show'])->name('coupons.activate.bulk.index');
    Route::post('coupons/activate/bulk', [CouponBulkActivateController::class, 'activate'])->name('coupons.activate.bulk.store');
    // activate coupons routes
    Route::get('coupons/{coupon:uuid}/activate', [ActivateCouponController::class, 'show'])->name('coupons.activate.index');
    Route::post('coupons/{coupon:uuid}/activate', [ActivateCouponController::class, 'activate'])->name('coupons.activate');

    // deactivate coupons routes
    Route::get('coupons/{coupon:uuid}/deactivate', [DeactivateCouponController::class, 'show'])->name('coupons.deactivate.index');
    Route::post('coupons/{coupon:uuid}/deactivate', [DeactivateCouponController::class, 'deactivate'])->name('coupons.deactivate.store');
    // payout coupons routes
    Route::get('coupons/{coupon:uuid}/payout', [CouponPayoutController::class, 'index'])->name('coupons.payout.index');
    Route::post('coupons/{coupon:uuid}/payout', [CouponPayoutController::class, 'payout'])->name('coupons.payout.send');
    Route::get('coupons/payout/bulk', [CouponPayoutController::class, 'bulk'])->name('coupons.payout.bulk');
    Route::post('coupons/payout/bulk', [CouponPayoutController::class, 'bulkPayout'])->name('coupons.payout.bulk.send');
    // extend coupons payout deadline  routes
    Route::get('coupons/{coupon:uuid}/deadline/extend', [ExtendDeadlineController::class, 'index'])->name('coupons.payout.extend.index');
    Route::post('coupons/{coupon:uuid}/deadline/extend', [ExtendDeadlineController::class, 'extend'])->name('coupons.payout.extend');

    // coupon resource routes
    Route::resource('coupons', CouponController::class)->except(['store', 'update']);

    // payments controller
    Route::view('transactions', 'sponsor.transactions')->name('transactions');
    Route::get('transactions/{transaction:uuid}/invoice/view', [InvoiceController::class, 'view'])->name('transactions.invoice.view');
    Route::get('transactions/{transaction:uuid}/invoice/download', [InvoiceController::class, 'download'])->name('transactions.invoice.download');
    Route::get('transactions/{transaction:uuid}/invoice', [InvoiceController::class, 'invoice'])->name('transactions.invoice');

    Route::get('bulk/url', BulkActionRouteController::class)->name('bulk-url');

});

// sponsor flow routes after registration start
// choose plan
Route::get('choose-plan', PlanController::class)->name('plans.index');
Route::post('subscription/checkout', [SubscriptionCheckoutController::class, 'checkout'])->name('subscription-checkout');
Route::get('checkout/success', [SubscriptionCheckoutController::class, 'success'])->name('checkout-success');
Route::get('checkout/cancel', [SubscriptionCheckoutController::class, 'cancel'])->name('checkout-cancel');

// basic settings
Route::get('basic-settings', [BasicSettingController::class, 'index'])->name('basic-settings');
Route::post('basic-settings', [BasicSettingController::class, 'store'])->name('basic-settings.store');
Route::get('basic-settings/verify-ein', [BasicSettingController::class, 'showVerifyEIN'])->name('basic-settings.ein');
Route::post('basic-settings/verify-ein', [BasicSettingController::class, 'verifyEIN'])->name('basic-settings.ein.verify');
Route::get('basic-settings/shipping-address', [BasicSettingController::class, 'showAddress'])->name('basic-settings.address');
Route::post('basic-settings/shipping-address', [BasicSettingController::class, 'saveAddress'])->name('basic-settings.address.store');
Route::get('basic-settings/payment-information', PaymentInfoController::class)->name('basic-settings.payment');
Route::get('basic-settings/templates', TemplateController::class)->name('basic-settings.templates');
// sponsor flow routes after registration end

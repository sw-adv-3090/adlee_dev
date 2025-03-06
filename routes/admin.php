<?php

use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PrintBookletEmailController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponTemplateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignerController;
use App\Http\Controllers\Admin\DesignerTemplateController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ShipFromSettingController;
use App\Http\Controllers\Admin\ShipmentCarrierController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\SponsorTemplateController;
use App\Http\Controllers\Admin\TemplateOverviewController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::view('reports', 'admin.reports')->name('reports');
Route::view('reports/coupons', 'admin.reports.coupons')->name('reports.coupons');
Route::view('reports/accounts', 'admin.reports.accounts')->name('reports.accounts');
Route::resource('coupons', CouponController::class)->only(['index', 'show']);

// plans routes
Route::resource('plans', PlanController::class);

// templates routes
Route::prefix('templates')->name('templates.')->group(function () {
    Route::get('/', TemplateOverviewController::class)->name('index');
    Route::resource('coupons', CouponTemplateController::class)->except(['show']);
    Route::resource('sponsors', SponsorTemplateController::class)->except(['show']);
    Route::resource('categories', CategoryController::class);
});

Route::prefix('designers')->name('designers.')->group(function () {
    Route::get('/', [DesignerController::class, 'index'])->name('index');
    Route::get('/approve-designer/{id}/{value}', [DesignerController::class, 'approve_designer'])->name('approve-designer');
    
});

Route::prefix('designer-templates')->name('designer-templates.')->group(function () {
    Route::get('/', [DesignerTemplateController::class, 'index'])->name('index');
    Route::post('/approve-template', [DesignerTemplateController::class, 'approve_template'])->name('approve-template');
    Route::get('/unapprove-template/{id}/{value}', [DesignerTemplateController::class, 'unapprove_template'])->name('approve-template');
    Route::get('delete/{id}', [DesignerTemplateController::class, 'delete_template'])->name('delete');
    // Route::resource('coupons', CouponTemplateController::class)->except(['show']);
    // Route::resource('sponsors', SponsorTemplateController::class)->except(['show']);
    // Route::resource('categories', CategoryController::class);
});


// jobs routes
Route::prefix('jobs')->name('jobs.')->group(function () {
    Route::get('/booklets/print/{job}/shipment', [ShipmentController::class, 'index'])->name('booklet-prints.shipment.index');
    Route::post('/booklets/print/{job}/shipment', [ShipmentController::class, 'store'])->name('booklet-prints.shipment');
    Route::view('/booklets/print', 'admin.jobs.booklet-print')->name('booklet-prints');
});

// users route
Route::prefix('users')->name('users.')->group(function () {
    Route::view('/sponsors', 'admin.users.sponsors')->name('sponsors');
    Route::view('/ad-space-owners', 'admin.users.ad-space-owners')->name('ad-space-owners');
});

// settings routes
Route::prefix('settings')->name('settings.')->group(function () {
    Route::view('/booklet/print-emails', 'admin.settings.print-emails')->name('print-booklet-emails');
    Route::get('shipment/carrier', [ShipmentCarrierController::class, 'index'])->name('shipment.carrier');
    Route::post('shipment/carrier', [ShipmentCarrierController::class, 'update'])->name('shipment.carrier.update');
    Route::get('ship-from-address', [ShipFromSettingController::class, 'index'])->name('ship-from-address');
    Route::post('ship-from-address', [ShipFromSettingController::class, 'update'])->name('ship-from-address.update');
});

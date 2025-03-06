<?php

use App\Http\Controllers\Auth\FacebookLoginController;
use App\Http\Controllers\Auth\TwitterLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorController;

Route::post('login', LoginController::class)->name('login');
Route::controller(GoogleLoginController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});
Route::controller(FacebookLoginController::class)->group(function () {
    Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'handleFacebookCallback');
});
Route::controller(TwitterLoginController::class)->group(function () {
    Route::get('auth/twitter', 'redirectToTwitter')->name('auth.twitter');
    Route::get('auth/twitter/callback', 'handleTwitterCallback');
});

Route::post('reset-password', ResetPasswordController::class)->name('password.resets');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // 2fa routes
    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);
});

<?php
use App\Http\Controllers\Designer\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', DashboardController::class)->name('dashboard');
Route::get('upload-template', [DashboardController::class, 'upload_template_view'])->name('upload-template');

Route::get('delete-template/{id}', [DashboardController::class, 'delete_template'])->name('delete-template');
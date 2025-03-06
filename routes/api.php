<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilePreviewController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/edit_image_preview', [FilePreviewController::class, 'editImage']);
Route::post('/save_file_data', [FilePreviewController::class, 'saveFileData']);
Route::post('/editPdf', [FilePreviewController::class, 'editPdf']);

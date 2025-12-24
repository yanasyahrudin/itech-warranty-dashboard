<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WarrantyController;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
});

Route::prefix('warranty')->group(function () {
    Route::post('/register', [WarrantyController::class, 'register']);
    Route::get('/status/{serial}', [WarrantyController::class, 'status']);
    Route::post('/resubmit/{id}', [WarrantyController::class, 'resubmit']); // pakai POST utk multipart
});
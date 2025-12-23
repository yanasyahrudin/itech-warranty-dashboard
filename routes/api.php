<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WarrantyController;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::post('warranty/register', [WarrantyController::class, 'register']);
    Route::get('warranty/status/{serial}', [WarrantyController::class, 'status']);
    Route::put('warranty/resubmit/{id}', [WarrantyController::class, 'resubmit']);
});
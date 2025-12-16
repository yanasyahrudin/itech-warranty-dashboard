<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WarrantyVerificationController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\ProductLabelController;
use App\Http\Controllers\WarrantyRegistrationController;
use App\Http\Controllers\WarrantyCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Public warranty routes
Route::prefix('warranty')->name('warranty.')->group(function () {
    Route::get('/register', [WarrantyRegistrationController::class, 'create'])->name('register');
    Route::post('/register', [WarrantyRegistrationController::class, 'store'])->name('store');
    
    // Warranty Check Routes (NEW)
    Route::get('/check', [WarrantyCheckController::class, 'index'])->name('check');
    Route::post('/search', [WarrantyCheckController::class, 'search'])->name('search');
    Route::get('/detail/{warranty}', [WarrantyCheckController::class, 'detail'])->name('detail');
    
    // Resubmission Routes
    Route::get('/resubmit/{warranty}', [WarrantyRegistrationController::class, 'edit'])->name('resubmit');
    Route::post('/resubmit/{warranty}', [WarrantyRegistrationController::class, 'update'])->name('resubmit.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', ProductController::class);
    
    // Warehouse Management
    Route::prefix('warehouse')->name('warehouse.')->group(function () {
        // Product Received
        Route::get('/received', [WarehouseController::class, 'receivedIndex'])->name('received.index');
        Route::get('/received/create', [WarehouseController::class, 'receivedCreate'])->name('received.create');
        Route::post('/received', [WarehouseController::class, 'receivedStore'])->name('received.store');
        Route::get('/received/{transaction}/print', [WarehouseController::class, 'receivedPrint'])->name('received.print');
        Route::get('/received/{transaction}/download', [WarehouseController::class, 'receivedDownload'])->name('received.download');
        
        // Product Issued
        Route::get('/issued', [WarehouseController::class, 'issuedIndex'])->name('issued.index');
        Route::get('/issued/create', [WarehouseController::class, 'issuedCreate'])->name('issued.create');
        Route::post('/issued', [WarehouseController::class, 'issuedStore'])->name('issued.store');
    });
    
    // Warranty Verification
    Route::prefix('warranty')->name('warranty.')->group(function () {
        Route::get('/', [WarrantyVerificationController::class, 'index'])->name('index');
        Route::get('/{registration}', [WarrantyVerificationController::class, 'show'])->name('show');
        Route::post('/{registration}/approve', [WarrantyVerificationController::class, 'approve'])->name('approve');
        Route::post('/{registration}/reject', [WarrantyVerificationController::class, 'reject'])->name('reject');
    });
    
    // QR Code Management
    Route::prefix('qr-code')->name('qr-code.')->group(function () {
        Route::get('/', [QrCodeController::class, 'index'])->name('index');
        Route::get('/preview', [QrCodeController::class, 'preview'])->name('preview');
        Route::get('/download', [QrCodeController::class, 'download'])->name('download');
    });
    
    // Product Label Generator
    Route::prefix('labels')->name('labels.')->group(function () {
        Route::get('/', [ProductLabelController::class, 'index'])->name('index');
        
        // Old routes (product-based)
        Route::get('/generate/{product}', [ProductLabelController::class, 'generate'])->name('generate');
        Route::get('/download/{product}', [ProductLabelController::class, 'download'])->name('download');
        
        // New routes (serial number-based)
        Route::get('/serial/{serialNumber}', [ProductLabelController::class, 'generateWithSerial'])->name('serial.generate');
        Route::get('/serial/{serialNumber}/download', [ProductLabelController::class, 'downloadWithSerial'])->name('serial.download');
        
        // Bulk operations
        Route::post('/bulk-generate', [ProductLabelController::class, 'bulkGenerate'])->name('bulk-generate');
        Route::post('/bulk-generate-serials', [ProductLabelController::class, 'bulkGenerateWithSerials'])->name('bulk-generate-serials');
    });
    
    // Admin routes (labels)
    Route::get('labels', [ProductLabelController::class, 'index'])->name('labels.index');
    // Serial-based label generation
    Route::get('labels/serial/{serial}/generate', [ProductLabelController::class, 'serialGenerate'])->name('labels.serial.generate');
    Route::get('labels/serial/{serial}/download', [ProductLabelController::class, 'serialDownload'])->name('labels.serial.download');
    // Bulk by serials
    Route::post('labels/bulk-serials', [ProductLabelController::class, 'bulkGenerateBySerials'])->name('labels.bulk-serials');
});

require __DIR__.'/auth.php';
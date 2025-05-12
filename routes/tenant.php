<?php

declare(strict_types=1);

use App\Http\Controllers\App\{
    ProfileController,
    ProductController,
    CategoryController,
    BackendController,
    ReportController,
    SaleController
};
use App\Http\Controllers\App\SupplierManagement\PurchaseOrderController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;



Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return view('app.welcome');
    });

    Route::get('dashboard', [BackendController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('products', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('products.index');
    Route::get('add_products', [ProductController::class, 'create'])->middleware(['auth', 'verified'])->name('products.create');
    
    
    Route::get('categoryes', [CategoryController::class, 'index'])->middleware(['auth', 'verified'])->name('categoryes.index');
    Route::get('add_categoryes', [CategoryController::class, 'create'])->middleware(['auth', 'verified'])->name('categoryes.create');
    
    
    
    Route::get('purchases', [PurchaseOrderController::class, 'index'])->middleware(['auth', 'verified'])->name('purchases.index');
    Route::get('add_purchases', [PurchaseOrderController::class, 'create'])->middleware(['auth', 'verified'])->name('purchases.create');
    
    Route::get('reports', [ReportController::class, 'index'])->middleware(['auth', 'verified'])->name('reports.index');
    Route::get('add_reports', [ReportController::class, 'create'])->middleware(['auth', 'verified'])->name('reports.create');

    Route::get('sales', [SaleController::class, 'index'])->middleware(['auth', 'verified'])->name('sales.index');
    Route::get('add_sales', [SaleController::class, 'create'])->middleware(['auth', 'verified'])->name('sales.create');

    Route::middleware('auth')->group(function () {
        
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    require __DIR__ . '/tenant-auth.php';
});

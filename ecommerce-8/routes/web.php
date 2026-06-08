<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('contoh', [App\Http\Controllers\ContohController::class, 'index']
// );

// Route::resource('crud', App\Http\Controllers\CRUDController::class);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('detail-product/{id}', [ProductController::class, 'show'])->name('detail-product');

Route::get('cart', [CartController::class, 'index'])->name('cart');

Route::get('checkout', function () {
    return "Ini adalah halaman checkout ecommerce-8.";
})->name('checkout');

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/products', ProductController::class)->names('dashboard.products');
        Route::resource('/product-categories', ProductCategoryController::class)->names('dashboard.product-categories');
        Route::resource('/orders', OrderController::class)->names('dashboard.orders');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('contoh', [App\Http\Controllers\ContohController::class, 'index']
// );

// Route::resource('crud', App\Http\Controllers\CRUDController::class);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('detail-product/{id}', [ProductController::class, 'show'])->name('detail-product');

Route::resource('product', ProductController::class);

Route::get('cart', [CartController::class, 'index'])->name('cart');

Route::get('checkout', function () {
    return "Ini adalah halaman checkout ecommerce-8.";
})->name('checkout');
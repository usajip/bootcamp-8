<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Selamat datang di halaman utama ecommerce-8!";
});

Route::get('products', function () {
    return view('landing_page');
});

Route::get('cart', function () {
    return "Ini adalah halaman keranjang belanja ecommerce-8.";
});

Route::get('checkout', function () {
    return "Ini adalah halaman checkout ecommerce-8.";
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController as ProductController;

use App\Http\Controllers\OrderController as OrderController;
use App\Http\Controllers\OrderItemController as OrderItemController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Product Routes
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('orders-item', OrderItemController::class);

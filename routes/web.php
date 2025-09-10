<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController as ProductController;

use App\Http\Controllers\OrderController as OrderController;
use App\Http\Controllers\OrderItemController as OrderItemController;
use App\Http\Controllers\Frontend\FrontendHomeController as FHomeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Frontend Home Route
Route::get('/', [FHomeController::class, 'index'])->name('frontend.index');

// Product Routes
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('orders-item', OrderItemController::class);

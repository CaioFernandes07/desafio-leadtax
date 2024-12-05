<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::get('/scrape', [ProductController::class, 'scrape'])->name('products.scrape');

Route::get('/produtos', [ProductController::class, 'index']);

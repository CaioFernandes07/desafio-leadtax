<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/scrape', [ScrapingController::class, 'scrape'])->name('products.scrape');
Route::delete('/delete', [ScrapingController::class, 'deleteAllProducts'])->name('products.deleteAll');

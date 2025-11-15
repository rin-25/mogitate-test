<?php

use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'index'])->name('products.search'); // 検索もindexで処理
Route::get('/products/detail/{productId}', [ProductController::class, 'edit'])->name('products.show');
Route::post('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');
Route::post('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.delete');
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');
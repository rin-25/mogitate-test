<?php

use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'index'])->name('products.search'); // 検索もindexで処理
Route::get('/products/detail/{productId}', [ProductController::class, 'show'])->name('products.show');

// 「+商品を追加」用（今は画面だけ飛べればOKならこれ）
Route::get('/products/create', function () {
    return '商品登録画面（あとで実装）';
})->name('products.create');
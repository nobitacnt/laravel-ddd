<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Presentation\ProductController;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'get'])->name('products.get');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{id}', [ProductController::class, 'detail'])->name('products.detail');
        Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    });
});

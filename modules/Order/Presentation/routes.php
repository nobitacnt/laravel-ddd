<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Presentation\OrderController;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'get'])->name('orders.get');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/{id}', [OrderController::class, 'detail'])->name('orders.detail');
        Route::put('/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('orders.delete');
    });
});

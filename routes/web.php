<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware('api')->group(function () {

    Route::apiResource('products', ProductController::class);
    
    Route::apiResource('categories', CategoryController::class);

    Route::apiResource('orders', OrderController::class);

    Route::apiResource('order-items', OrderItemController::class);
});

<?php

use App\Http\Controllers\CostumerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;



Route::apiResource('categories', CategoryController::class);
Route::apiResource('costumers', CostumerController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);

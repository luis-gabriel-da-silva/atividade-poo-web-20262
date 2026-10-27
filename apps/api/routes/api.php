<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UploadController;


//Registrar rota de login
Route::post('auth/login', [AuthController::class, 'login']);

// Mover rotas da aplicação (CRUD) para um grupo protegido.
Route::group([
    'middleware' => [
        'auth:sanctum',
    ]
], function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
});

    Route::post('/upload', [UploadController::class, 'upload']);



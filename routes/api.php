<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::post(uri: '/login', action: 'login');
        Route::post(uri: 'refresh-token', action: 'refreshToken');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('products')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get(uri: '/', action: 'index');
            Route::get(uri: '/{id}', action: 'show');
            Route::post(uri: '/create', action: 'create');
            Route::patch(uri: '/update/{id}', action: 'update');
            Route::delete(uri: '/delete/{id}', action: 'destroy');
        });
    });
});



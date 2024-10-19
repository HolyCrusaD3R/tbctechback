<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::post(uri: '/login', action: 'login');
        Route::post(uri: 'refresh-token', action: 'refreshToken');
    });
});

Route::prefix('products')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get(uri: '/', action: 'index');
        Route::get(uri: '/{id}', action: 'show');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('products')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::post(uri: '/create', action: 'create');
            Route::patch(uri: '/update/{id}', action: 'update');
            Route::delete(uri: '/delete/{id}', action: 'destroy');
        });
    });

    Route::prefix('contracts')->group(function () {
        Route::controller(ContractController::class)->group(function () {
            Route::get(uri: '/{id}', action: 'show');
            Route::post(uri: '/create', action: 'create');
            Route::post(uri: '/complete/{id}', action: 'complete');
            Route::post(uri: '/accept/{id}', action: 'accept');
            Route::post(uri: '/reject/{id}', action: 'reject');
            Route::post(uri: '/dispute/{id}', action: 'dispute');
            Route::post(uri: '/delete/{id}', action: 'destroy');
        });
    });

    Route::prefix('users')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get(uri: '/whoami', action: 'whoami');
            Route::get(uri: '/dashboard', action: 'dashboard');
        });
    });
});



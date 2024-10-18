<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::prefix('v1/auth')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::post(uri: '/login', action: 'login');
        Route::post(uri: 'refresh-token', action: 'refreshToken');
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', function () {
        return response()->json([
            'success' => false,
            'message' => 'Please Login [POST] /api/auth/login'
        ], 401);
    })->name('login');
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');
    Route::get('/verify-email', function () {
        return response()->json([
            'success' => false,
            'message' => 'Please Verify Email [POST] /api/auth/verify-email'
        ], 401);
    })->name('verification.notice');


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
    });
});

Route::prefix('v1')->as('api.')->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
    });
});

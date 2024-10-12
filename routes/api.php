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
    Route::post('/forgot-password', [App\Http\Controllers\Api\AuthController::class, 'passwordResetLink'])->middleware(['throttle:6,1'])->name('password.email');
    Route::get('reset-password/{token}', fn() => [
        'success' => true,
        'message' => 'Please Reset Password [GET] /api/auth/reset-password/{token}'
    ])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Api\AuthController::class, 'newPassword'])->name('password.store');
    Route::get('/verify-email', function () {
        return response()->json([
            'success' => false,
            'message' => 'Please Verify Email [POST] /api/auth/verify-email'
        ], 401);
    })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.notice');
    Route::post('/email/verification-notification', [App\Http\Controllers\Api\AuthController::class, 'emailVerificationNotification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
    Route::get('/verify-email/{id}/{hash}', [App\Http\Controllers\Api\AuthController::class, 'verifyEmail'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.verify');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
    });
});

Route::prefix('v1')->as('api.')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        //
    });
});

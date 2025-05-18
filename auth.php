<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/choose-role', [AuthController::class, 'chooseRole']);
Route::post('/seller-info', [SellerController::class, 'store']);
Route::post('admin/login', [AuthController::class, 'adminLogin']);

// Password reset routes
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Routes protected by sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Email verification
    Route::get('/email/verify', [AuthController::class, 'verifyEmail']);
    Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail']);
    
    // 2FA
    Route::post('/2fa/enable', [AuthController::class, 'enableTwoFactor']);
    Route::post('/2fa/disable', [AuthController::class, 'disableTwoFactor']);
    Route::post('/2fa/verify', [AuthController::class, 'verifyTwoFactor']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VerificationController;

// Public Routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/choose-role', [AuthController::class, 'chooseRole']);
Route::post('/seller-info', [SellerController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('admin/login', [AuthController::class, 'adminLogin']);

// Public User Routes (for testing or open access)
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);

// Authenticated Routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('/profile', [UserController::class, 'show']);
    Route::put('/profile', [UserController::class, 'update']);

    // Product Management
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::get('/products', [ProductController::class, 'index']);

    // Cart & Orders
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::delete('/cart/{id}', [CartController::class, 'removeItem']);
    Route::post('/checkout', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'orderHistory']);

    // Image Uploads
    Route::post('/upload/product-image', [ImageUploadController::class, 'uploadProductImage']);
    Route::post('/upload/profile-picture', [ImageUploadController::class, 'uploadProfilePicture']);

    // Services
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
    Route::get('/services', [ServiceController::class, 'index']);

    // Notifications
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAllAsRead']);
    Route::get('/notification', [NotificationController::class, 'index']);

    // Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/account', [SettingsController::class, 'accountInfo']);
        Route::get('/purchases', [SettingsController::class, 'myPurchases']);
        Route::get('/themes', [SettingsController::class, 'getThemes']);
        Route::post('/themes', [SettingsController::class, 'updateTheme']);
        Route::get('/badges', [SettingsController::class, 'getBadges']);
    });

    // Payment & Verification
    Route::post('/payment/checkout', [PaymentController::class, 'checkout']);
    Route::post('/verify/student', [VerificationController::class, 'upload']);

    // Admin Routes
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        Route::get('/analytics', [AdminController::class, 'analytics']);
        Route::get('/reports', [AdminController::class, 'viewReports']);
        Route::post('/lssogout', [AuthController::class, 'logout']);
    });

    // General logout
    Route::post('/logout', [AuthController::class, 'logout']);
});


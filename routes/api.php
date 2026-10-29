<?php

use App\Http\Controllers\PhoneChangeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CoreCategoryController;
use App\Http\Controllers\ItemReviewController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * TODO: Route::get('/category/{category:slug}/item')
 */
Route::prefix('v1')->group(function () {
    Route::prefix('/cities')->group(function () {
        Route::get('/', [CityController::class, 'index']);
        Route::get('/{city}', [CityController::class, 'show']);
        Route::get('/{city}/locations', [LocationController::class, 'index']);
    });
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CoreCategoryController::class, 'index']);
        Route::prefix('/{category:slug}/items')->group(function () {
            Route::get('/', [LandingController::class, 'getItems']);
            Route::get('/fields-to-filter', [LandingController::class, 'getFieldsToFilterItems']);
        });
    });
    Route::prefix('/items')->group(function () {
        Route::get('/{item}', [LandingController::class, 'getSingleItem']);
        Route::get('/{item}/reviews', [ItemReviewController::class, 'index']);
        Route::post('/{item}/reviews', [ItemReviewController::class, 'store']);
        Route::get('/{item}/reviews/{review}', [ItemReviewController::class, 'show']);
    });
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::prefix('/profile')->group(function () {
            Route::controller(ProfileController::class)->group(function () {
                Route::get('/', 'show');
                Route::patch('/', 'update');
            });
            Route::prefix('/phone')->group(function () {
                Route::controller(PhoneChangeController::class)->group(function () {
                    Route::post('/request-change', 'request');
                    Route::post('/verify-change', 'verify');
                });
            });
        });

    });
});


Route::get('/test', [\App\Http\Controllers\CityController::class, 'index']);

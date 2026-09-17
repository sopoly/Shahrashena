<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CoreCategoryController;
use App\Http\Controllers\ItemReviewController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
 * TODO: Route::get('/category/{category:slug}/item')
 */
Route::prefix('v1')->group(function () {
    Route::prefix('/cities')->group(function () {
        Route::get('', [CityController::class, 'index']);
        Route::get('{city}', [CityController::class, 'show']);
        Route::get('/{city}/locations', [LocationController::class, 'index']);
    });
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CoreCategoryController::class, 'index']);
        Route::prefix('/{category}/items')->group(function () {
            Route::get('', [LandingController::class, 'getItems']);
            Route::get('/fields-to-filter', [LandingController::class, 'getFieldsToFilterItems']);
        });
    });
    Route::prefix('/items')->group(function () {
        Route::get('/{item}', [LandingController::class, 'getSingleItem']);
        Route::get('{item}/reviews', [ItemReviewController::class, 'index']);
        Route::post('{item}/reviews', [ItemReviewController::class, 'store']);
        Route::get('{item}/reviews/{review}', [ItemReviewController::class, 'show']);
    });
    Route::get('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});


Route::get('/test', [\App\Http\Controllers\CityController::class, 'index']);

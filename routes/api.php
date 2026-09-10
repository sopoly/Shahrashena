<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\LandingController;
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
    });

    Route::prefix('/category/items')->group(function () {
        Route::get('', [LandingController::class, 'getItems']);
        Route::get('/fields-to-filter', [LandingController::class, 'getFieldsToFilterItems']);
        Route::get('/{item}', [LandingController::class, 'getSingleItem']);
    });
});


Route::get('/test', [\App\Http\Controllers\CityController::class, 'index']);

<?php

use App\Classes\Item\ItemList;
use App\Http\Controllers\LandingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/category/items', [LandingController::class, 'getItems']);
Route::get('/category/items/{item}', [LandingController::class, 'getSingleItem']);
Route::get('/category/items/fields-to-filter', [LandingController::class, 'getFieldsToFilterItems']);

Route::get('/test', [ItemList::class, 'getItems']);

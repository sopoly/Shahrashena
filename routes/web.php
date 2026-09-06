<?php

use App\Models\Item;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hi', function () {
    $item = Item::find(1);
    dd($item->itemFeatures()->with('feature')->get('feature_value'));
});

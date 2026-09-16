<?php

use App\Models\Item;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hi', function () {
    $itemInformation = \App\Models\ItemInformation::find(1);
    dd($itemInformation->item()->pluck('title')->first());
});

// Route::get('/test', [ItemList::class, 'getItems']);

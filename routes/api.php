<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;

Route::post('signup', [UserController::class, 'storeUser']);

Route::group([
    'controller' => PlaceController::class,
    'prefix' => 'places'
], function () {
    Route::get('', 'list');
    Route::post('', 'store');
});

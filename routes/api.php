<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;

Route::group([
    'controller' => UserController::class
], function () {
    Route::post('signup', 'storeUser');
    Route::get('users', 'list');
});

Route::group([
    'controller' => PlaceController::class,
    'prefix' => 'places'
], function () {
    Route::get('', 'list');
    Route::post('', 'store');
});

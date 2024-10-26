<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;

Route::group([
    'controller' => UserController::class
], function () {
    Route::get('users', 'list')
        ->middleware('auth.api');
    Route::post('signup', 'storeUser');
});

Route::group([
    'middleware' => 'auth.api',
    'controller' => PlaceController::class,
    'prefix' => 'places'
], function () {
    Route::get('', 'list');
    Route::post('', 'store');
});

Route::group([
    'middleware' => 'api',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

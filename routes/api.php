<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;

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

Route::group([
    'controller' => FavoriteController::class
], function () {
    Route::post('/users/{user_id}/favorites', 'store');
    Route::get('/users/{user_id}/favorites', 'getFavorites');
});

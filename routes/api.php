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
    Route::post('', 'store')
        ->middleware('admin');
});

Route::group([
    'middleware' => 'api',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'auth.api',
    'controller' => FavoriteController::class
], function () {
    Route::post('/users/favorites', 'store');
    Route::get('/users/favorites', 'getFavorites');
});

Route::any('{any}', function () {
    return response()->json([
        'error' => [
            'status_code' => 404,
            'message' => 'Ресурс не найден'
        ]
    ], 404);
})->where('any', '.*');

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    public function store(StoreFavoriteRequest $request, $user_id)
    {
        if (!$user = User::find($user_id)) {
            return response()->json([
                "error" => [
                    "status_code" => 404,
                    "message" => "Данного пользователя несуществует"
                ]
            ], 404);
        }

        $place_id = $request->input('place_id');

        if (DB::table('favorites')
            ->where('user_id', $user_id)
            ->where('place_id', $place_id)->exists()) {
            return response()->json([
                'error' => [
                    'status_code' => 422,
                    'message' => 'Данное место уже добавлено пользователем'
                ]
            ], 422);
        }

        if (DB::table('favorites')
            ->where('user_id', $user_id)->count() >= 3) {
            return response()->json([
                'error' => [
                    'status_code' => 422,
                    'message' => 'У пользователя не может быть боллее 3 мест в избранном'
                ]
            ], 422);
        }

        $user->favorites()->attach($place_id);

        return response()->json([
            "data" => [
                "message" => "Место ($place_id) добавленно в избранное",
                "pivot" => DB::table('favorites')
                    ->where('user_id', $user_id)
                    ->where('place_id', $place_id)->get()
            ]
        ], 201);
    }

    public function getFavorites(Request $request, $user_id)
    {
        $validated = Validator::make(['user_id' => $user_id], [
            'user_id' => 'uuid'
        ], [
            'user_id.uuid' => 'Идентификатор пользователя должен быть корректным',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'error' => [
                    'status_code' => 422,
                    'message' => 'Ошибка авторизации',
                    'details' => $validated->errors()
                ]
            ], 422);
        }

        if (!$user = User::find($user_id)) {
            return response()->json([
                "error" => [
                    "status_code" => 404,
                    "message" => "Данного пользователя несуществует"
                ]
            ], 404);
        }

        $favorites = $user->favorites()->get();

        return response()->json([
            'data' => $favorites
        ]);
    }
}

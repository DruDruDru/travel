<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public function storeUser(StoreUserRequest $request)
    {
        $user = User::create([
            'login' => $request->input('login'),
            'password' => bcrypt($request->input('password'))
        ]);

        return response()->json([
            'message' => 'Пользователь успешно создан',
            'user' => $user
        ], 201);
    }
}
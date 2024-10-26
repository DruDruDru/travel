<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function storeUser(StoreUserRequest $request)
    {
        $user = User::create([
            'login' => $request->input('login'),
            'password' => bcrypt($request->input('password'))
        ]);

        return response()->json([
            'data' => [
                'message' => 'Регистрация прошла успешно'
            ]
        ], 201);
    }
    public function list()
    {
        $user = Auth::user();
        if ($user->getRole() === 'admin') {
            return response()->json([
                'data' => User::all()
            ]);
        }
        return response()->json([
            'data' => $user
        ]);
    }
}

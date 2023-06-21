<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            abort(401, 'Invalid Credentials');
        }

        $token = auth()->user()->createToken('auth_token');

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete(); //Deleta todos os tokens do usuário

        return response()->json([], 204);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *      tags={"Auth"},
     *      summary="Gerar token",
     *      description="Gera um novo token de autenticação",
     *      path="/login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="test@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Novo token de autenticação"
     *      )
     * )
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
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

    /**
     * @OA\Delete(
     *      tags={"Auth"},
     *      summary="Apagar tokens",
     *      description="Apaga todos os tokens do usuário",
     *      path="/logout",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=204,
     *          description="Tokens apagados, autenticação encerrada"
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->user()->tokens()->delete(); //Deleta todos os tokens do usuário

        return response()->json([], 204);
    }
}

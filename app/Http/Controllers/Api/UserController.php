<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      tags={"Users"},
     *      summary="Listar usuários",
     *      description="Retorna uma lista de usuários com paginação.",
     *      path="/users",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response="200", description="Lista de usuários"
     *      )
     * )
     *
     * @return Users
     */
    public function index()
    {
        $users = User::paginate();
        return UserResource::collection($users);
    }

    /**
     * @OA\Post(
     *      tags={"Users"},
     *      summary="Novo usuário",
     *      description="Registra um novo usuário",
     *      path="/users",
     *      security={{ "bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"name","email","password"},
     *              @OA\Property(property="name", type="string", format="text", example="João da Silva"),
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Novo usuário"
     *      )
     * )
     *
     * @param StoreUpdateUserRequest $request
     *
     * @return UserResource
     */
    public function store(StoreUpdateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *      tags={"Users"},
     *      summary="Listar um usuário",
     *      description="Retorna os dados de um único usuário.",
     *      path="/users/{id}",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="User id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200", description="Dados de um usuário"
     *      )
     * )
     *
     * @return UserResource
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    /**
     * @OA\PUT(
     *      tags={"Users"},
     *      summary="Editar usuário",
     *      description="Edita um usuário existente",
     *      path="/users/{id}",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="User id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"name","email"},
     *              @OA\Property(property="name", type="string", format="text", example="João da Silva Peixoto"),
     *              @OA\Property(property="email", type="string", format="email", example="joao.silva@mail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password123"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Edição de usuário"
     *      )
     * )
     *
     * @param StoreUpdateUserRequest $request
     *
     * @return UserResource
     */
    public function update(StoreUpdateUserRequest $request, string $id)
    {
        $data = $request->all();

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);
        $user->update($data);
        return new UserResource($user);
    }

    /**
     * @OA\Delete(
     *      tags={"Users"},
     *      summary="Apagar usuário",
     *      description="Apaga um usuário existente",
     *      path="/users/{id}",
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="User id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Usuário apagado"
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id)->delete();
        return response()->json([], 204);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @OA\Get (path="/users",
     *     security={{"bearerAuth":{}}},
     *      tags={"Users"},
     *     @OA\Response(response="200",
     *     description="Users Collection"
     *      ),
     *     @OA\Parameter (
     *         name="page",
     *         description="Pagination Page",
     *         in="query",
     *         @OA\Schema (
     *             type="integer"
     *         )
     *     )
     *    )
     */
    public function index()
    {
        Gate::authorize('view', 'users');
        return UserResource::collection(User::with('role')->paginate());
    }

    /**
     * @OA\Post (path="/users",
     *     security={{"bearerAuth":{}}},
     *      tags={"Users"},
     *     @OA\Response(response="201",
     *     description="User Create "
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
     *     )
     *    )
     */
    public function store(UserCreateRequest $request)
    {
        Gate::authorize('edit', 'users');
        $user = User::create($request->only(
                'first_name',
                'last_name',
                'email',
                'role_id'
            ) + [
                'password' => Hash::make('password')
            ]);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get (path="/users/{id}",
     *     security={{"bearerAuth":{}}},
     *      tags={"Users"},
     *     @OA\Response(response="200",
     *     description="User Show"
     *      ),
     *     @OA\Parameter (
     *         name="id",
     *         description="Uesr ID",
     *         in="path",
     *         required=true,
     *         @OA\Schema (
     *             type="integer"
     *         )
     *     )
     *    )
     */
    public function show(string $id)
    {
        Gate::authorize('edit', 'users');
        return new UserResource(User::with('role')->find($id));
    }

    /**
     * @OA\Put (path="/users/{id}",
     *     security={{"bearerAuth":{}}},
     *      tags={"Users"},
     *     @OA\Response(response="202",
     *     description="User Update"
     *      ),
     *      @OA\Parameter (
     *          name="id",
     *          description="User Id",
     *          in="path",
     *          required=true,
     *          @OA\Schema (
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *           @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     *      )
     *    )
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        Gate::authorize('edit', 'users');
        $user = User::find($id);

        $user->update($request->only(
            'first_name',
            'last_name',
            'email',
            'role_id'
        ));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete (path="/users/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Users"},
     *     @OA\Response(response="204",
     *     description="User Delete"
     *      ),
     *     @OA\Parameter (
     *         name="id",
     *         description="Uesr ID",
     *         in="path",
     *         required=true,
     *         @OA\Schema (
     *             type="integer"
     *         )
     *     )
     *    )
     */
    public function destroy(string $id)
    {
        Gate::authorize('edit', 'users');
        $user = User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

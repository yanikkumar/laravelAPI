<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => 1
        ]);

        return response(new UserResource($user), status: Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'Invalid Credentials'
            ], status: Response::HTTP_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = Auth::user();
        $jwt = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $jwt, 5);

        $response = response([
            'jwt' => $jwt,
            'user' => $user
        ]);

        $response->header('Authorization', 'Bearer ' . $jwt);

        return $response->withCookie($cookie);
    }

    /**
     * @OA\Get (path="/user",
     *     security={{"bearerAuth":{}}},
     *       tags={"Profile"},
     *     @OA\Response(response="200",
     *     description="Authenticated User"
     *     )
     *    )
     */
    public function user(Request $request)
    {
        $user = $request->user();
        return new UserResource($user->load('role'));
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    /**
     * @OA\Put (path="/user/info",
     *     security={{"bearerAuth":{}}},
     *        tags={"Profile"},
     *     @OA\Response(response="202",
     *     description="User Info Update"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *           @OA\JsonContent(ref="#/components/schemas/UpdateInfoRequest")
     *      )
     *    )
     */
    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();
        $user->update($request->only(
            'first_name',
            'last_name',
            'email'
        ));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Put (path="/user/password",
     *     security={{"bearerAuth":{}}},
     *      tags={"Profile"},
     *     @OA\Response(response="202",
     *     description="User Password Update"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *           @OA\JsonContent(ref="#/components/schemas/UpdatePasswordRequest")
     *      )
     *    )
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update(['password' => Hash::make($request->input('password'))]);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}

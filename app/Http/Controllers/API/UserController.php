<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::with('role')->paginate());
    }

    public function store(UserCreateRequest $request)
    {
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

    public function show(string $id)
    {
        return new UserResource(User::with('role')->find($id));
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        $user->update($request->only(
            'first_name',
            'last_name',
            'email',
            'role_id'
        ));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id)
    {
        $user = User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

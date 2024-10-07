<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        return User::paginate();
    }

    public function store(Request $request)
    {
        $user = User::create($request->only(
            'first_name',
            'last_name',
            'email'
        ) + [
            'password' => Hash::make('password')
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        return User::find($id);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $user->update($request->only(
            'first_name',
            'last_name',
            'email'
        ));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id)
    {
        $user = User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

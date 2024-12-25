<?php


namespace App\Services\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\User\Http\Requests\UpdateUserRequest;
use App\Services\User\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(UpdateUserRequest $request): UserResource
    {
        $user = $request->user();
        $user->update($request->validated());

        return new UserResource($user);
    }
}

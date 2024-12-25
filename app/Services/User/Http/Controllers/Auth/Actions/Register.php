<?php


namespace App\Services\User\Http\Controllers\Auth\Actions;

use App\Services\User\Http\Requests\RegisterRequest;
use App\Services\User\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function registerUser(RegisterRequest $request): User
    {
        $userInput = $request->validated();

        $user = User::create(Arr::except($userInput, ['password']));

        $user->password = Hash::make($userInput['password']);

        return tap($user)->save();
    }
}

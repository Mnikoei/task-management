<?php


namespace App\Services\User\Http\Controllers\Auth\Actions;

use App\Services\User\Models\User;
use Illuminate\Support\Facades\Hash;

class Login
{
    public function loginUser(string $username, string $password): User | false
    {
        $user = $this->findUser($username);
        if (!$user) {
            return false;
        }

        if ($this->matchesPassword($password, $user->password)) {

            static::login($user);

            return $user;
        }

        return false;
    }

    public function findUser($mobile): User | null
    {
        return User::whereMobile($mobile)->first();
    }

    public static function login(User $user)
    {
        auth()->login($user);
    }

    public function matchesPassword(string $password, string $hash): bool
    {
//        return $password === $hash;
        return Hash::check($password, $hash);
    }
}

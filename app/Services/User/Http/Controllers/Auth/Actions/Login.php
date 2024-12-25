<?php


namespace App\Services\User\Http\Controllers\Auth\Actions;

use App\Services\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

class Login
{
    public function loginUser(string $username, string $password, $scopes = ['*']): ?NewAccessToken
    {
        $user = $this->findUser($username);

        if (!$user) {
            return null;
        }

        if ($this->matchesPassword($password, $user->password)) {

            return static::createToken($user, $scopes);
        }

        return null;
    }

    public function findUser($mobile): ?User
    {
        return User::whereUsername($mobile)->first();
    }

    public static function createToken(User $user, array $scopes)
    {
        return $user->createToken(
            name: $user->username . ':' . now()->toDateTimeString(),
            abilities: $scopes,
            expiresAt: now()->addMinutes(config('auth.token-expiration-in-minutes'))
        );
    }

    public function matchesPassword(string $password, string $hash): bool
    {
        return Hash::check($password, $hash);
    }
}

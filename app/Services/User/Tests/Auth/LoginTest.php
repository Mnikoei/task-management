<?php

namespace App\Services\User\Tests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginAndGetToken()
    {
        $user = $this->user();

        $password = Str::random();

        $user->password = Hash::make($password);
        $user->save();

        $response = $this->postJson('api/v1/auth/login', [
            'username' => $user->username,
            'password' => $password
        ]);

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'access_token',
            'scopes',
            'expires_at'
        ]);
    }

//    public function testInputValidation()
//    {
//        $this->assertTrue(false);
//    }
}

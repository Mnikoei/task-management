<?php

namespace App\Services\User\Tests\Auth;

use App\Models\Bet;
use App\Services\Crash\Events\Action;
use App\Services\Crash\Models\Crash;
use App\Services\Crash\Service;
use App\Services\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testUserCanRegister()
    {
        $this->postJson('api/v1/auth/register', [
            'username' => Str::random(),
            'password' => $password = Str::password(8, true, true, false, false),
            'password_confirmation' => $password,
            'email' => $this->faker->email
        ])->assertStatus(201, $password);
    }

    public function testInputValidation()
    {
//        $this->assertTrue(false);
    }
}

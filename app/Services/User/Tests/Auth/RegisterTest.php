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
use Illuminate\Testing\Fluent\Concerns\Has;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * This test is not reliable enough
     */
    public function user_can_register_with_correct_username()
    {
        $this->postJson('auth/register', [
            'username' => 'nader-kochike',
            'password' => $p = $this->faker->password,
            'password_confirmation' => $p,
            'email' => $this->faker->email,
            'mobile' => '09' . mt_rand(100000000, 999999999)
        ])->assertStatus(201);
    }

    /**
     * @test
     */
    public function user_can_login_with_email()
    {
        $user = $this->createUser();

        $password = Str::random();

        $user->password = Hash::make($password);
        $user->save();

        $this->post('auth/login', [
            'username' => $user->username,
            'password' => $password
        ])->assertOk();
    }
}

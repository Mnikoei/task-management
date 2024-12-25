<?php

namespace App\Services\User\Tests\Auth;

use App\Models\Bet;
use App\Services\Crash\Events\Action;
use App\Services\Crash\Models\Crash;
use App\Services\Crash\Service;
use App\Services\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_login()
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

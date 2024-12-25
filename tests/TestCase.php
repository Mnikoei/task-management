<?php

namespace Tests;

use App\Services\User\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function authenticatedUser(): User
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}

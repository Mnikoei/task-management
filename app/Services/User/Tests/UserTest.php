<?php

namespace App\Services\User\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;


    public function testGetUserData()
    {
        $this->authenticatedUser([
            'name' => 'john',
            'username' => 'doo',
            'balance' => 1000,
            'reserved' => 1255
        ]);

        $response = $this->get('user');

        $response->assertJson([
            'name' => 'john',
            'username' => 'doo',
            'balance' => 1000,
            'reserved' => 1255
        ]);
    }
}

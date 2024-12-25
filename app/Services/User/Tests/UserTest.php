<?php

namespace App\Services\User\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testGetUserData()
    {
        $this->authenticatedUser([
            'username' => 'John'
        ]);

        $response = $this->getJson('api/v1/user');

        $response->assertJson([
            'username' => 'John',
        ]);
    }
}

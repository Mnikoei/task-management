<?php

namespace App\Services\User\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testUserCanUpdateOwnInformation(): void
    {
        $user = $this->authenticatedUser();

        $response = $this->patch('api/v1/user', [
            'username' => $username = $this->faker->userName,
            'email' => $email = $this->faker->email,
        ]);

        $response->assertJson([
            'username' => $username,
        ]);

        $this->assertEquals($user->refresh()->email, $email);
    }
}

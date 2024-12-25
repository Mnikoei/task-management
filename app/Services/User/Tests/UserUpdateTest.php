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

    /**
     * @test
     */
    public function getUserData(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->patch('user', [
            'name' => $this->faker->name,
            'national_code' => '4240398363',
            'mobile' => '0901235000',
            'address_ir' => $this->faker->address,
            'address_out_of_ir' => $this->faker->address,
            'postal_code_ir' => (string) $this->faker->randomNumber(),
            'phone' => $this->faker->e164PhoneNumber,
            'national_card' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        dd($response->json());

        $response->assertOk();

        dd($user->refresh());
    }
}

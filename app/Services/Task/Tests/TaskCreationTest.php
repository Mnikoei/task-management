<?php

namespace App\Services\Task\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TaskCreationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testValidatesInput()
    {
        $this->assertTrue(false);
    }

    public function testCanCreateTask(): void
    {
        $user = $this->authenticatedUser();

        $response = $this->postJson('/api/v1/task', [
            'title' => fake()->title,
            'description' => fake()->text,
            'due_date' => now()->addHours(2)
        ]);

        dd($response->json());
    }
}

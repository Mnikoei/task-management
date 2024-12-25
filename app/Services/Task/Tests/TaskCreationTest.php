<?php

namespace App\Services\Task\Tests;

use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TaskCreationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

//    public function testValidatesInput()
//    {
//        $this->assertTrue(false);
//    }

    public function testCanCreateTask(): void
    {
        $user = $this->authenticatedUser();

        $this->assertDatabaseCount('tasks', 0);

        $response = $this->postJson('/api/v1/task', [
            'title' => $title = fake()->title,
            'description' => $desc = fake()->text,
            'due_date' => $dueDate = now()->addHours(2)
        ]);

        $response->assertJson([
            'title' => $title,
            'description' => $desc,
            'creator' => [
                'username' => $user->username,
            ],
//            'due_date' => $dueDate->toDateTimeString(),
//            'due_date_for_humans' => $dueDate->diffForHumans(),
            'status' => TaskStatus::PENDING->value
        ]);

        $this->assertDatabaseCount('tasks', 1);
    }

    public function testCanNotCreateTaskWithoutPermission(): void
    {
        $user = $this->user();
        $this->authenticate($user);

        $this->assertFalse($user->hasPermission('creates-task'));

        $response = $this->postJson('/api/v1/task', [
            'title' => fake()->title,
            'description' => fake()->text,
            'due_date' => now()->addHours(2)
        ]);

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'access denied!'
        ]);
    }

    public function testMustHavePermissionToCreateTask(): void
    {
        $user = $this->user(data: [], adminAccess: true);
        $this->authenticate($user);

        $this->assertTrue($user->hasPermission('creates-task'));

        $response = $this->postJson('/api/v1/task', [
            'title' => $title = fake()->title,
            'description' => $desc = fake()->text,
            'due_date' => now()->addHours(2)
        ]);

        $response->assertSuccessful();
    }
}

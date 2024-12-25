<?php

namespace App\Services\Task\Tests;

use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TaskDeleteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testCanDeleteTask(): void
    {
        Carbon::setTestNow(now());

        $user = $this->authenticatedUser();

        $task = Task::factory()->for($user)->create();

        $this->assertDatabaseCount('tasks', 1);
        $this->assertDatabaseHas('tasks', [
            'deleted_at' => null
        ]);

        $response = $this->deleteJson("/api/v1/task/{$task->id}");

        $response->assertSuccessful();

        $response->assertJson([
            'title' => $task->title,
            'description' => $task->description,
            'creator' => [
                'username' => $user->username,
            ],
            'due_date' => $task->due_date->toDateTimeString(),
            'due_date_for_humans' => $task->due_date->diffForHumans(),
            'status' => $task->status->value
        ]);


        $this->assertDatabaseCount('tasks', 1);
        $this->assertDatabaseHas('tasks', [
            'deleted_at' => now()->toDateTimeString()
        ]);

        $this->assertTrue($task->refresh()->trashed());
    }

    public function testCanNotDeleteTaskIfBelongsToSomeOneElse(): void
    {
        $this->authenticatedUser();

        $anotherUser = $this->user();

        $task = Task::factory()->for($anotherUser)->create();

        $response = $this->deleteJson("/api/v1/task/{$task->id}");

        $response->assertForbidden();
    }

    public function testCanNotDeleteTaskWithoutPermission(): void
    {
        $user = $this->user();
        $this->authenticate($user);

        $this->assertFalse($user->hasPermission('deletes-task'));

        $task = Task::factory()->for($user)->create();

        $response = $this->deleteJson("/api/v1/task/{$task->id}", [
            'title' => fake()->title,
            'description' => fake()->text,
            'due_date' => now()->addHours(2)
        ]);

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'access denied!'
        ]);
    }

    public function testMustHavePermissionToDeleteTask(): void
    {
        $user = $this->user(data: [], adminAccess: true);
        $this->authenticate($user);

        $task = Task::factory()->for($user)->create();

        $response = $this->deleteJson("/api/v1/task/{$task->id}");

        $response->assertSuccessful();

        $this->assertTrue($task->refresh()->trashed());
    }
}

<?php

namespace App\Services\Task\Tests;

use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\Task\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TaskUpdateTest extends TestCase
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

    public function testCanUpdateTask(): void
    {
        Carbon::setTestNow(now());

        $user = $this->authenticatedUser();

        $task = Task::factory()->for($user)->create([
            'title' => 'whatever',
            'description' => 'whatever',
            'due_date' => now()->subHour(),
            'status' => TaskStatus::PENDING->value
        ]);

        $response = $this->patchJson("/api/v1/task/{$task->id}", [
            'title' => $title = fake()->title,
            'description' => $desc = fake()->text,
            'due_date' => $dueDate = now()->addHours(2),
            'status' => TaskStatus::COMPLETED->value
        ]);

        $response->assertJson([
            'title' => $title,
            'description' => $desc,
            'creator' => [
                'username' => $user->username,
            ],
//            'due_date' => $dueDate->toDateTimeString(),
//            'due_date_for_humans' => $dueDate->diffForHumans(),
            'status' => TaskStatus::COMPLETED->value
        ]);
    }

    public function testCanNotUpdateTaskIfBelongsToSomeOneElse(): void
    {
        $this->authenticatedUser();

        $anotherUser = $this->user();

        $task = Task::factory()->for($anotherUser)->create();

        $response = $this->patchJson("/api/v1/task/{$task->id}", [
            'title' => fake()->title
        ]);

        $response->assertForbidden();
    }

    public function testCanNotUpdateTaskWithoutPermission()
    {
        $user = $this->user();
        $this->authenticate($user);

        $this->assertFalse($user->hasPermission('updates-task'));

        $task = Task::factory()->for($user)->create();

        $response = $this->patchJson("/api/v1/task/{$task->id}", [
            'title' => fake()->title
        ]);

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'access denied!'
        ]);
    }

    public function testMustHavePermissionToUpdateTask()
    {
        $user = $this->user(data: [], adminAccess: true);
        $this->authenticate($user);

        $this->assertTrue($user->hasPermission('updates-task'));

        $task = Task::factory()->for($user)->create();

        $response = $this->patchJson("/api/v1/task/{$task->id}", [
            'title' => fake()->title
        ]);

        $response->assertSuccessful();
    }
}

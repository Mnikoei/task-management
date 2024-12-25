<?php


use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TaskSatateChangeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testCanChangeTaskToNextStatus(): void
    {
        $user = $this->authenticatedUser();

        $task = Task::factory()->for($user)->create([
            'status' => TaskStatus::PENDING->value
        ]);

        $response = $this->postJson("/api/v1/task/{$task->id}/state/next");
        $response->assertSuccessful();

        $task->refresh();

        $this->assertSame($task->status, TaskStatus::COMPLETED);
    }

    public function testCanChangeTaskToPreviousStatus(): void
    {
        $user = $this->authenticatedUser();

        $task = Task::factory()->for($user)->create([
            'status' => TaskStatus::COMPLETED->value
        ]);

        $response = $this->postJson("/api/v1/task/{$task->id}/state/previous");
        $response->assertSuccessful();

        $task->refresh();
        $this->assertSame($task->status, TaskStatus::PENDING);
    }

    public function testCanNotChangeTaskStateIfBelongsToAnotherUser(): void
    {
        $this->authenticatedUser();
        $anotherUser = $this->user();

        $task = Task::factory()->for($anotherUser)->create([
            'status' => TaskStatus::COMPLETED->value
        ]);

        $response = $this->postJson("/api/v1/task/{$task->id}/state/next");
        $response->assertForbidden();

        $response = $this->postJson("/api/v1/task/{$task->id}/state/previous");
        $response->assertForbidden();
    }

    public function testCanNotChangeTaskStateWithoutPermission(): void
    {
        $user = $this->user();
        $this->authenticate($user);

        $this->assertFalse($user->hasPermission('changes-task-status'));

        $task = Task::factory()->for($user)->create([
            'status' => TaskStatus::COMPLETED->value
        ]);

        $response = $this->postJson("/api/v1/task/{$task->id}/state/next");
        $response->assertForbidden();

        $response = $this->postJson("/api/v1/task/{$task->id}/state/previous");
        $response->assertForbidden();
    }
}

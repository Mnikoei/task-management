<?php

namespace App\Services\Task\Http\Controllers\V1\Actions;

use App\Services\Task\Http\Requests\V1\CreateTaskRequest;
use App\Services\Task\Http\Requests\V1\UpdateTaskRequest;
use App\Services\Task\Models\Task;

readonly class UpdateTaskAction
{
    public function __construct(private Task $task)
    {
    }

    public function updateBy(UpdateTaskRequest $request): Task
    {
        $this->validateTaskOwnership($request);

        return tap($this->task)->update($request->validated());
    }

    public function validateTaskOwnership($request): void
    {
        abort_if(
            !$this->task->creator()->is($request->user()),
            403
        );
    }
}

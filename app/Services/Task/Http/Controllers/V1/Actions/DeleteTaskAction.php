<?php

namespace App\Services\Task\Http\Controllers\V1\Actions;

use App\Services\Task\Http\Requests\V1\DeleteTaskRequest;
use App\Services\Task\Models\Task;

readonly class DeleteTaskAction
{
    public function __construct(private Task $task)
    {
    }

    public function deleteBy(DeleteTaskRequest $request): Task
    {
        $this->validateTaskOwnership($request);

        return tap($this->task)->delete();
    }

    public function validateTaskOwnership($request): void
    {
        abort_if(
            !$this->task->creator()->is($request->user()),
            403
        );
    }
}

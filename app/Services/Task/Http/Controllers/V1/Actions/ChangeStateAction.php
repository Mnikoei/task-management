<?php

namespace App\Services\Task\Http\Controllers\V1\Actions;

use App\Services\Task\Models\Task;
use Illuminate\Http\Request;

readonly class ChangeStateAction
{
    public function __construct(private Request $request, private Task $task)
    {
        $this->validateTaskOwnership();
    }

    public function next(): Task
    {
        return $this->task->goToNextState();
    }

    public function previous(): Task
    {
        return $this->task->goToPrevState();
    }

    public function validateTaskOwnership(): void
    {
        abort_if(
            !$this->task->creator()->is($this->request->user()),
            403
        );
    }
}

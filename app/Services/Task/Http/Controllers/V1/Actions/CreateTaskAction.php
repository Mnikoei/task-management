<?php

namespace App\Services\Task\Http\Controllers\V1\Actions;

use App\Services\Task\Http\Requests\V1\CreateTaskRequest;
use App\Services\Task\Models\Task;

class CreateTaskAction
{
    public function createBy(CreateTaskRequest $request): Task
    {
        return Task::create([
            'creator_id' => $request->user()->id,
            ...$request->validated()
        ]);
    }
}

<?php

namespace App\Services\Task\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\Task\Http\Controllers\V1\Actions\CheckUserAccess;
use App\Services\Task\Http\Controllers\V1\Actions\CreateTaskAction;
use App\Services\Task\Http\Controllers\V1\Actions\DeleteTaskAction;
use App\Services\Task\Http\Controllers\V1\Actions\TaskListAction;
use App\Services\Task\Http\Controllers\V1\Actions\UpdateTaskAction;
use App\Services\Task\Http\Controllers\V1\Actions\UserAccessMiddlewaresAction;
use App\Services\Task\Http\Filters\TaskFilter;
use App\Services\Task\Http\Requests\V1\CreateTaskRequest;
use App\Services\Task\Http\Requests\V1\DeleteTaskRequest;
use App\Services\Task\Http\Requests\V1\TaskListRequest;
use App\Services\Task\Http\Requests\V1\UpdateTaskRequest;
use App\Services\Task\Http\Resources\V1\TaskResource;
use App\Services\Task\Models\Task;
use Illuminate\Routing\Controllers\HasMiddleware;

class TaskController extends Controller implements HasMiddleware
{
    public function store(CreateTaskRequest $request)
    {
        $task = (new CreateTaskAction)->createBy($request);

        // @todo remove refresh requirement problem when using sqlite
        return new TaskResource($task->refresh());
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = (new UpdateTaskAction($task))->updateBy($request);

        return new TaskResource($task->refresh());
    }

    public function destroy(DeleteTaskRequest $request, Task $task)
    {
        $task = (new DeleteTaskAction($task))->deleteBy($request);

        return new TaskResource($task->refresh());
    }

    public function index(TaskListRequest $request, TaskFilter $filters)
    {
        return (new TaskListAction($request))->fetch($filters);
    }

    public static function middleware()
    {
        return (new UserAccessMiddlewaresAction)->register();
    }
}

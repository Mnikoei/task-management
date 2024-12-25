<?php

namespace App\Services\Task\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\AccessLevel\Http\MiddleWares\EnsureHasPermission;
use App\Services\Task\Http\Controllers\V1\Actions\ChangeStateAction;
use App\Services\Task\Http\Requests\V1\UpdateTaskRequest;
use App\Services\Task\Http\Resources\V1\TaskResource;
use App\Services\Task\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StateController extends Controller implements HasMiddleware
{
    public function next(Request $request, Task $task)
    {
        $task = (new ChangeStateAction($request, $task))->next();

        return new TaskResource($task->refresh());
    }

    public function previous(UpdateTaskRequest $request, Task $task)
    {
        $task = (new ChangeStateAction($request, $task))->previous();

        return new TaskResource($task->refresh());
    }

    public static function middleware()
    {
       return [
            new Middleware(EnsureHasPermission::class.':changes-task-status'),
        ];
    }
}

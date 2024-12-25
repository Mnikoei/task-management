<?php

namespace App\Services\Task\Http\Controllers\V1\Actions;

use App\Http\Filters\BaseQueryFilter;
use App\Services\Task\Http\Requests\V1\TaskListRequest;
use App\Services\Task\Models\Task;

readonly class TaskListAction
{
    public function __construct(private TaskListRequest $request)
    {
    }

    public function fetch(BaseQueryFilter $filters = null)
    {
        return Task::cacheRepo(["user-{$this->request->user()->id}"])->remember(
            key: $this->getCacheKey(),
            ttl: now()->addHours(6),
            callback: fn() => Task::query()
                ->whereBelongsTo($this->request->user())
                ->filter($filters)
                ->get()
        );
    }

    /**
     * A unique key for same requests
     */
    public function getCacheKey(): string
    {
        return md5(implode(',', $this->request->all()));
    }
}

<?php

namespace App\Services\Task\Models\Observers;

use App\Services\Task\Events\TaskResourceModified;
use App\Services\Task\Models\Task;

class TaskHistoryRecorder
{
    public function created(Task $task): void
    {
        event(new TaskResourceModified([
            'action' => __METHOD__,
            'ref' => $task->id,
            'performer_id' => auth()->id()
        ]));
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        event(new TaskResourceModified([
            'action' => __METHOD__,
            'ref' => $task->id,
            'changes' => [
                $task->getDirty()
            ],
            'performer_id' => auth()->id()
        ]));
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        event(new TaskResourceModified([
            'action' => __METHOD__,
            'ref' => $task->id,
            'performer_id' => auth()->id()
        ]));
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {

    }

    /**
     * Handle the Task "forceDeleted" event.
     */
    public function forceDeleted(Task $task): void
    {

    }
}

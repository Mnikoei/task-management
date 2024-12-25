<?php

namespace App\Services\Task\Actions\StateManagement\States;

use App\Services\Task\Models\Enums\TaskStatus;

class Pending implements TaskStateContract
{

    public function nextState(): TaskStateContract
    {
        return new Completed();
    }

    public function prevState(): TaskStateContract
    {
        return new Pending();
    }

    public function stateValue(): TaskStatus
    {
        return TaskStatus::PENDING;
    }
}

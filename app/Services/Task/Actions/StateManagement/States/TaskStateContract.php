<?php

namespace App\Services\Task\Actions\StateManagement\States;

use App\Services\Task\Models\Enums\TaskStatus;

interface TaskStateContract
{
    public function nextState(): TaskStateContract;
    public function prevState(): TaskStateContract;
    public function stateValue(): TaskStatus;
}

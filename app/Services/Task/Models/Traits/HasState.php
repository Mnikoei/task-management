<?php

namespace App\Services\Task\Models\Traits;

use App\Services\Task\Actions\StateManagement\StateFactory;
use App\Services\Task\Actions\StateManagement\States\TaskStateContract;

trait HasState
{
    public function goToNextState(): static
    {
        $currentState = $this->getCurrentState();

        $nextState = $currentState->nextState();

        return tap($this)->update(['status' => $nextState->stateValue()->value]);
    }

    public function goToPrevState(): static
    {
        $currentState = $this->getCurrentState();

        $nextState = $currentState->prevState();

        return tap($this)->update(['status' => $nextState->stateValue()->value]);
    }

    public function getCurrentState(): TaskStateContract
    {
        return StateFactory::make($this->status->value);
    }
}

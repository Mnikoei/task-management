<?php

namespace App\Services\Task\Actions\StateManagement;

use App\Services\Task\Actions\StateManagement\States\Completed;
use App\Services\Task\Actions\StateManagement\States\Pending;
use function PHPUnit\Framework\matches;

class StateFactory
{
    public static function make(string $state)
    {
        return match($state) {
            'pending' => new Pending(),
            'completed' => new Completed(),
            default => new \Exception("$state state is not defined!")
        };
    }
}

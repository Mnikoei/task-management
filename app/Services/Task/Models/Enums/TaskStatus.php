<?php

namespace App\Services\Task\Models\Enums;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
}

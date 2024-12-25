<?php

namespace App\Services\Task\Events;

use App\Services\Support\LoggerService\Contracts\HasSensitiveLog;
use App\Services\Task\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskResourceModified implements HasSensitiveLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(private array $logData)
    {
    }

    public function getLogs(): array
    {
        return $this->logData;
    }
}

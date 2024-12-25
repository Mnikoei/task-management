<?php

namespace App\Services\Support\LoggerService\Contracts;

interface HasSensitiveLog
{
    public function getLogs(): array;
}

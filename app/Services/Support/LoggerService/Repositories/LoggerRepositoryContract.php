<?php

namespace App\Services\Support\LoggerService\Repositories;

interface LoggerRepositoryContract
{
    public function push(array $items);
}

<?php

namespace App\Services\Support\LoggerService\Repositories;

use App\Services\Support\LoggerService\Models\UserLogs;
use Illuminate\Database\Eloquent\Model;

class LoggerRepository implements LoggerRepositoryContract
{
    public function push(array $items)
    {
        // It can be buffered or stored in different ways
        $model = static::getModel();

        $model->create([
            'data' => $items
        ]);
    }

    public static function getModel(): Model
    {
        return new UserLogs();
    }
}

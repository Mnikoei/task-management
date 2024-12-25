<?php

namespace App\Services\Support\LoggerService\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    protected $fillable = [
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
}

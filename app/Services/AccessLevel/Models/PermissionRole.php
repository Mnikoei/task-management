<?php

namespace App\Services\AccessLevel\Models;

use App\Services\User\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Cache;

class PermissionRole extends Pivot
{
    protected static function boot()
    {
        parent::boot();

        $roleFlushCallback = fn() => User::cacheRepo()->flush();

        static::created($roleFlushCallback);
        static::deleted($roleFlushCallback);
        static::updated($roleFlushCallback);
    }
}

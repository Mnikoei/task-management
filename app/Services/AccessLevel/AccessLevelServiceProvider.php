<?php

namespace App\Services\AccessLevel;

use Illuminate\Support\ServiceProvider;

class AccessLevelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}

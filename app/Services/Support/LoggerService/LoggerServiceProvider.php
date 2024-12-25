<?php

namespace App\Services\Support\LoggerService;

use App\Services\Support\LoggerService\Contracts\HasSensitiveLog;
use App\Services\Support\LoggerService\Repositories\LoggerRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('loggerRepository', fn() => new LoggerRepository());
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    public function boot()
    {
        Event::listen(function (HasSensitiveLog $event) {
            $this->app->get('loggerRepository')->push($event->getLogs());
        });
    }
}

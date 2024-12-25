<?php


namespace App\Services\Task;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Route::middleware('web')
            ->prefix('api/v1')
            ->group(base_path('app/Services/Task/Routes/V1/routes.php'));

        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

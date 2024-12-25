<?php


namespace App\Services\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Route::middleware('web')
            ->group(base_path('app/Services/User/Routes/routes.php'));

        $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'user');

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

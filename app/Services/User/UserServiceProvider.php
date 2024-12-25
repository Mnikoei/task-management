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
        Route::middleware(['web'])
            ->prefix('api/v1')
            ->group(base_path('app/Services/User/Routes/V1/routes.php'));

        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        $this->mergeConfigFrom(__DIR__.'/Config/auth.php', 'auth');
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

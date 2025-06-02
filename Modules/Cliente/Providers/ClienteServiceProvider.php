<?php

namespace Modules\Cliente\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Cliente\Providers\RouteServiceProvider;

class ClienteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'cliente');

        $this->app->register(RouteServiceProvider::class);
    }
}

<?php

declare(strict_types = 1);

namespace Modules\Product\Providers;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'product');

        $this->app->register(RouteServiceProvider::class);

        $this->commands([
            //
        ]);
    }
}

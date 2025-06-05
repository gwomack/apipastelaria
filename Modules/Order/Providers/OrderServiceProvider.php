<?php

declare(strict_types = 1);

namespace Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Customer\Console\Commands\GenerateApiKeyCustomer;

class OrderServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'order');

        $this->app->register(RouteServiceProvider::class);

        $this->commands([
            //
        ]);
    }
}

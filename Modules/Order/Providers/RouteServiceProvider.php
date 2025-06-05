<?php

declare(strict_types = 1);

namespace Modules\Order\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->as('api.')
                ->namespace('Modules\Order\Http\Controllers\Api')
                ->group(__DIR__ . '/../api.php');
        });
    }
}

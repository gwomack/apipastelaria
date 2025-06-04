<?php

declare(strict_types = 1);

namespace Modules\Product\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->as('api.')
                ->namespace('Modules\Product\Http\Controllers\Api\V1')
                ->group(__DIR__ . '/../api.php');
        });
    }
}

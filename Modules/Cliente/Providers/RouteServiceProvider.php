<?php

namespace Modules\Cliente\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->namespace('Modules\Cliente\Http\Controllers\Api\V1')
                ->as('api.v1.')
                ->group(__DIR__.'/../api.php');
        });
    }
}

<?php

declare(strict_types = 1);

use Modules\Order\Http\Controllers\Api\V1\OrderController;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('orders', OrderController::class);
});
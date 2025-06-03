<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\Api\V1\CustomerController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
});

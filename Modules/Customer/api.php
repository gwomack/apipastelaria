<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\Api\V1\CustomerController;

Route::apiResource('customers', CustomerController::class);

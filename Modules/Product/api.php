<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;

Route::apiResource('products', Modules\Product\Http\Controllers\Api\V1\ProductController::class);

<?php

declare(strict_types = 1);

use Modules\Product\Http\Controllers\Api\V1\ProductController;
use Modules\Product\Http\Controllers\Api\V1\ProductCategoryController;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('product-categories', ProductCategoryController::class);
});

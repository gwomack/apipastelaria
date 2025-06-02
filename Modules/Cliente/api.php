<?php

use Illuminate\Support\Facades\Route;
use Modules\Cliente\Http\Controllers\Api\V1\ClienteController;

Route::apiResource('clientes', ClienteController::class);

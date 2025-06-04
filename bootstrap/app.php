<?php

declare(strict_types = 1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e) {
            if (request()->expectsJson()) {
                match ($e) {
                    NotFoundHttpException::class => response()->json([
                        'message' => 'Resource not found',
                    ], 404),
                    Throwable::class => response()->json([
                        'message' => 'Internal server error',
                    ], 500),
                };
            }
        });
    })->create();

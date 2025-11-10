<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Exceptions\AppException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($e instanceof AppException) {
                return response()->json([
                    'success' => false,
                    'code' => $e->getDomainCode(),
                    'message' => $e->getMessage(),
                    'data' => $e->getData(),
                ], $e->getHttpStatusCode());
            }

            return response()->json([
                'success' => false,
                'code' => 'unknown',
                'message' => 'Неизвестная ошибка',
                'data' => $e->__toString(),
            ], 599);
        });
    })->create();

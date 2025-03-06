<?php

use App\Http\Middleware\HandleTokenMismatch;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'boldsign/webhook',
            'shipengine/webhook',
        ]);
        $middleware->web(replace: [
            'Illuminate\Foundation\Http\Middleware\ValidateCsrfToken' => 'App\Http\Middleware\HandleTokenMismatch'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();

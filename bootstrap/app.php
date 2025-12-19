<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php', // ⬅️ INI YANG HILANG

        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin' => App\Http\Middleware\IsAdmin::class,
            'check_pin' => App\Http\Middleware\CheckTransactionPin::class, // ⬅️
        ]);
        $middleware->web(append: [
            VerifyCsrfToken::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'midtrans/webhook',
        ]);


    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

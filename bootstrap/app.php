<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'solicitante' => \App\Http\Middleware\Solicitante::class,
            'admin' => \App\Http\Middleware\Admin::class,
            'aprovador' => \App\Http\Middleware\Aprovador::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

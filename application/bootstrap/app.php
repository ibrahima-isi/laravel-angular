<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware pour les sessions
        $middleware->alias([
            'startSession' => \Illuminate\Session\Middleware\StartSession::class,
            'shareErrorsFromSession' => \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            'checkRole' => \App\Http\Middleware\CheckRole::class,
            'auth.custom' => \App\Http\Middleware\RedirectIfUnauthenticated::class,
        ]);
        // Assurez-vous que les middleware de session sont appliqués à vos routes API
        $middleware->group('api', ['startSession', 'shareErrorsFromSession']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

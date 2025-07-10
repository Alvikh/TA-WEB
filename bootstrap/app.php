<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckSuperAdmin;
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
        // 'auth' => Authenticate::class,
        // 'admin' => CheckAdmin::class,
        // 'superadmin' => CheckSuperAdmin::class,
        // 'user' => CheckUser::class,
        // 'role' => CheckRole::class,
    ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

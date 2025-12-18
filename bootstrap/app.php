<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            // ===== WEB =====
            'admin.web' => \App\Http\Middleware\Web\AdminMiddleware::class,
            'penyelenggara.web' => \App\Http\Middleware\Web\PenyelenggaraMiddleware::class,
            'pengunjung.web' => \App\Http\Middleware\Web\PengunjungMiddleware::class,

            // ===== API =====
            'admin.api' => \App\Http\Middleware\Api\AdminMiddleware::class,
            'penyelenggara.api' => \App\Http\Middleware\Api\PenyelenggaraMiddleware::class,
            'pengunjung.api' => \App\Http\Middleware\Api\PengunjungMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

    })
    ->create();

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
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\AddLinkHeaders::class,
            \App\Http\Middleware\MarkdownNegotiation::class,
        ]);

        // Must be global (not web-group) so it runs AFTER StartSession and
        // EncryptCookies have already set the session cookie on the response.
        $middleware->append(\App\Http\Middleware\EmbedCookieFix::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

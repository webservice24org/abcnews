<?php
use App\Http\Middleware\TrackVisitors;
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
        // Append your middleware to the default 'web' stack
        $middleware->appendToGroup('web', TrackVisitors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

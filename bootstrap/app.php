<?php

use App\Http\Middleware\CheckSubscriptionStatus;
use App\Http\Middleware\EnsureTwoFactorPassed;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(SetLocale::class);
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'subscribed' => CheckSubscriptionStatus::class,
            'two-factor-auth' => EnsureTwoFactorPassed::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'lemon-squeezy/*',
        ]);
        $middleware->encryptCookies(except: [
            'admin_date_range',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

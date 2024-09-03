<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // api: __DIR__ . '/../routes/api.php',
        // web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $err, Request $request) {
            dd('EXCEPTION2');
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        'error' => [
                            'message' => $err->getMessage(),
                        ]
                    ],
                    401
                );
            }
        });
        $exceptions->render(function (UnauthorizedHttpException $err, Request $request) {
            if ($err instanceof UnauthorizedHttpException) {
                return response()->json(
                    [
                        'error' => [
                            'action' => 'resourse request',
                            'message' => 'Unauthorized'
                        ]
                    ],
                    401
                );
            }
        });
    })->create();

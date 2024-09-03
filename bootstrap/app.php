<?php

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
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
            return response()->json(
                [
                    'error' => [
                        'action' => 'resourse request',
                        'message' => 'Unauthorized'
                    ]
                ],
                401
            );
        });
        $exceptions->render(function (NotFoundHttpException $err, Request $request) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'resource request',
                        'message' => 'resource not found'
                    ]
                ],
                404
            );
        });
    })->create();

<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            HandleAppearance::class,
            TrackVisitor::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 404 errors with Inertia
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            
            $locale = app()->getLocale() ?: session('locale', 'ar');
            
            return Inertia::render('404', [
                'locale' => $locale,
            ])->toResponse($request)->setStatusCode(404);
        });

        // Handle 500 errors with Inertia (HTTP exceptions)
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 500) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Server Error'], 500);
                }
                
                $locale = app()->getLocale() ?: session('locale', 'ar');
                
                return Inertia::render('500', [
                    'locale' => $locale,
                ])->toResponse($request)->setStatusCode(500);
            }
        });
    })->create();

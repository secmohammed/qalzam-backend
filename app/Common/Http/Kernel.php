<?php

namespace App\Common\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Common\Http\Middleware\Cors::class,
        \App\Common\Http\Middleware\TrustProxies::class,
        \App\Common\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Common\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        /**GLOBAL MIDDLEWARE**/
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Common\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Common\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Common\Http\Middleware\OptimizeImages::class,
            \App\Common\Http\Middleware\Lang::class,
            //\App\Common\Http\Middleware\LangMiddleware::class,
            /**WEB MIDDLEWARE**/
        ],

        'api' => [
            \App\Common\Http\Middleware\JsonifyResponse::class,
            \App\Common\Http\Middleware\ParseJWTToken::class,
            \App\Common\Http\Middleware\Lang::class,

            \Fruitcake\Cors\HandleCors::class,
            \App\Common\Http\Middleware\HasRole::class,
            \App\Common\Http\Middleware\OptimizeImages::class,
            \App\Common\Http\Middleware\Branch\SetCurrentBranch::class,
            \App\Common\Http\Middleware\Branch\ResetCurrentBranch::class,
            'throttle:60,1',
            'bindings',

        ],
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Common\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,

    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Common\Http\Middleware\Authenticate::class,
        'auth.api' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Common\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'guest.api' => \App\Common\Http\Middleware\GuestJWTMiddleware::class,
        'cart.sync' => \App\Common\Http\Middleware\Cart\Sync::class,
        'cart.isnotempty' => \App\Common\Http\Middleware\Cart\RespondIfEmpty::class,
        'cart.notempty' => \App\Common\Http\Middleware\Cart\CheckIfEmpty::class
        /**ROUTE MIDDLEWARE**/
    ];
}

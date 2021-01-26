<?php

namespace App\Common\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Common\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(app_path("Common/Routes/api/public.php"));

        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(app_path("Common/Routes/api/guest.php"));

        Route::middleware('api')
            ->prefix('api/')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(app_path("Common/Routes/api/auth.php"));
    }
}

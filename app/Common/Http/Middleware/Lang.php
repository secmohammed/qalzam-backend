<?php

namespace App\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->query('lang')) {
            if (in_array($request->query('lang'), config('app.available_locales'))) {
                config(['app.locale' => $request->query('lang')]);
                session(['lang' => $request->query('lang')]);
                app()->setLocale(session('lang'));
            }
        }
        app()->setLocale(session('lang'));

        config(['qalzam.currency' => session('lang') . '_SA']);

        return $next($request);
    }
}

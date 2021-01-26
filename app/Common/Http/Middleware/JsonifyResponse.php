<?php

namespace App\Common\Http\Middleware;

use Closure;

class JsonifyResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        config(['auth.defaults.guard' => 'api']);

        return $next($request);
    }
}

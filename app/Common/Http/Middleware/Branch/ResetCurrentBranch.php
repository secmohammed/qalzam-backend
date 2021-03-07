<?php

namespace App\Common\Http\Middleware\Branch;

use Closure;

class ResetCurrentBranch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('branch') || $request->has('branch_id') || $request->has('accommodation') || $request->route()->parameter('branch') !== null) {

            return $next($request);
        }
        session()->forget('current_branch');

        return $next($request);
    }
}

<?php

namespace App\Common\Http\Middleware\Branch;

use Closure;

class SetCurrentBranch
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
        if (($request->has('branch') || $request->route()->parameter('branch') !== null) && !session()->has('current_branch')) {
            session(['current_branch' => $request->branch]);
        }
        if ($request->has('branch_id') && !session()->has('current_branch')) {
            session(['current_branch' => $request->branch_id]);

        }
        if ($request->has('accommodation') && !session()->has('current_branch')) {
            session(['current_branch' => $request->accommodation->branch_id]);
        }

        return $next($request);
    }
}

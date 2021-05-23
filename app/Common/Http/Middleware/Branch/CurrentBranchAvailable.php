<?php

namespace App\Common\Http\Middleware\Branch;

use App\Common\Facades\Branch;
use Closure;
use Illuminate\Http\Request;

class CurrentBranchAvailable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(! Branch::hasChangeableBranch()){
            toastr()->error('You Should Choose Branch First!', 'Oops');
            return redirect()->route('website.branches');
        }
        return $next($request);
    }
}

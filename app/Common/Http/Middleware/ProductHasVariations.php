<?php

namespace App\Common\Http\Middleware;

use App\Domain\Product\Entities\Product;
use Closure;
use Illuminate\Http\Request;

class ProductHasVariations
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
        // todo implement This Middleware
        return $next($request);
    }
}

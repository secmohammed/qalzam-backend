<?php

namespace App\Common\Http\Middleware\Cart;

use Closure;
use Illuminate\Http\Request;
use App\Common\Facades\Cart;
class ProductInTheSameBranch
{
    private $current_cart;
    public function __construct()
    {
        $this->current_cart = Cart::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(count($this->current_cart['branch']) != $request->branch_id){
            session()->flash('should-be-in-the-branch');
            return route(previousRouteName());
        }
        return $next($request);
    }
}

<?php

namespace App\Common\Http\Middleware\Cart;

use App\Common\Facades\Branch;
use Closure;
use Illuminate\Http\Request;
use App\Common\Facades\Cart;
class CheckIfEmpty
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
        if(count($this->current_cart['products']) <= 0){
            toastr()->warning("You Have not add any product to your cart,Lets start shopping!", 'No Items');
                if(previousRouteName() === 'website.my-cart')
                    return redirect(route('website.home'));
                return back();
        }
        else
            return $next($request);
    }
}

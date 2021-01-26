<?php

namespace App\Common\Http\Middleware\Cart;

use Closure;
use App\Common\Cart\Cart;

class Sync
{
    /**
     * @var mixed
     */
    private $cart;

    /**
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

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
        $this->cart->sync();
        if ($this->cart->hasChanged()) {
            return response()->json([
                'message' => 'Oh no, some items in your cart have changed, please review these changes before placing your order',
            ], 400);
        }

        return $next($request);
    }
}

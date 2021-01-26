<?php

namespace App\Common\Http\Middleware\Cart;

use Closure;
use App\Common\Cart\Cart;

class RespondIfEmpty
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
        if ($this->cart->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty',
            ], 400);
        }

        return $next($request);
    }
}

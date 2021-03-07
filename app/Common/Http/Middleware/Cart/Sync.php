<?php

namespace App\Common\Http\Middleware\Cart;

use Closure;
use App\Common\Cart\Cart;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;

class Sync
{
    /**
     * @var mixed
     */
    private $cart;

    /**
     * @param Cart $cart
     */
    public function __construct(Cart $cart, BranchRepository $branchRepository)
    {

        $this->cart = $cart;
        $this->branchRepository = $branchRepository;
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
        if (!session()->has('current_branch')) {
            return response()->json([
                'message' => 'You have to select a branch in order to display its cart.',
            ], 422);
        }
        $this->cart->setCartType('cart')->withBranch(
            $this->branchRepository->find(
                session('current_branch')
            )
        )->sync();
        if ($this->cart->hasChanged()) {
            return response()->json([
                'message' => 'Oh no, some items in your cart have changed, please review these changes before placing your order',
            ], 400);
        }

        return $next($request);
    }
}

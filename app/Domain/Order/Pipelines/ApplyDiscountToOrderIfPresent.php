<?php

namespace App\Domain\Order\Pipelines;

use App\Common\Cart\Cart;
use App\Infrastructure\Pipelines\Pipeline;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Domain\Discount\Http\Exceptions\DiscountExpiredException;
use App\Domain\Discount\Http\Exceptions\DiscountIsAlreadyUsedException;

class ApplyDiscountToOrderIfPresent implements Pipeline
{
    /**
     * @var mixed
     */
    private $cart;

    /**
     * @param Cart $cart
     */
    public function __construct(Cart $cart, UserRepository $userRepository)
    {
        $this->cart = $cart;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {
        if (!$request->discount_id) {
            return $next($request);
        }
        try {
            $discount = ($user = $this->userRepository->whereId($request->user_id ?? auth()->id())->firstOrFail())->discounts()->where('discount_id', $request->discount_id)->firstOrFail();
            throw_if($discount->pivot->used_at, DiscountIsAlreadyUsedException::class);
            $user->discounts()->sync($discount, ['used_at' => now()]);
            if ($request->is('api/orders')) {
                $request->merge(compact('discount'));
            } else {
                $this->cart->withDiscount($discount);
            }
        } catch (ModelNotFoundException $e) {
            throw new DiscountExpiredException;
        }

        return $next($request);
    }
}

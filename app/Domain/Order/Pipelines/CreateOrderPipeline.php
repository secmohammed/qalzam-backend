<?php

namespace App\Domain\Order\Pipelines;

use App\Common\Cart\Cart;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Discount\Traits\PriceCalculator;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Pipelines\Pipeline;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;

class CreateOrderPipeline implements Pipeline
{
    /**
     * @var mixed
     */
    private $cart, $orderRepository;

    /**
     * @param Cart $cart
     */
    public function __construct(OrderRepository $orderRepository, ProductVariationRepository $productVariationRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    /**
     * @param $request
     * @param \Closure   $next
     */
    public function handle($request, \Closure $next)
    {
        $products = $this->productVariationRepository->whereIn('id', $request->products ?? $request->order->products->pluck('id'))->with(['branches' => function ($query) use ($request) {
            $query->where('id', $request->branch_id);
        },
        ])->get()->map(function ($product) use ($request) {
            $quantity = array_key_exists($product->id, $request->validated()['products']) ? $request->validated()['products'][$product->id]['quantity'] : $request->order->products->where('id', $product->id)->first()->pivot->quantity;

            $product->pivot = new Pivot([
                'quantity' => $quantity,
            ]);

            return $product;
        });
        $subtotal = app(PriceCalculator::class)->calculcateDiscountedPrice($request->discount ?? new Discount, $products);
        $attributes = Arr::except($request->validated(), ['products', 'discount_id']) + compact('subtotal');

        if ($request->order) {
            $order = $request->order->update($attributes);
        } else {
            $order = $this->orderRepository->create($attributes);
        }

        $order->products()->sync($request->validated()['products']);
        return $next($order);
    }

}

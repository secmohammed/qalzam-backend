<?php

namespace App\Domain\Order\Pipelines;

use App\Common\Cart\Cart;
use Illuminate\Support\Arr;
use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Order\Http\Events\OrderCreated;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;

class CreateOrderPipeline implements Pipeline
{
    /**
     * @var mixed
     */
    private $cart, $orderRepository;

    /**
     * @param Cart $cart
     */
    public function __construct(Cart $cart, OrderRepository $orderRepository, ProductVariationRepository $productVariationRepository)
    {
        $this->cart = $cart;
        $this->orderRepository = $orderRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {
        if ($request->is('api/orders')) {
            $subtotal = $this->productVariationRepository->find($request->products)->reduce(function ($carry, $product) {
                return $carry + $product->price->amount();
            }, 0);
            if ($request->discount) {
                $subtotal = $subtotal - ($subtotal * $request->discount->percentage / 100);
            }
            $order = $this->orderRepository->firstOrCreate(
                Arr::except($request->validated(), ['products', 'discount_id']) + compact('subtotal')
            );
        } else {
            $order = auth()->user()->orders()->firstOrCreate(
                $this->prepareOrder($request->validated())
            );
            $order->products()->sync($this->cart->products()->forSyncing());

        }
        $request->merge(compact('order'));
        event(new OrderCreated($order));

        return $next($request);
    }

    /**
     * @param $data
     */
    protected function prepareOrder($data)
    {
        return array_merge($data, [
            'subtotal' => $this->cart->subtotal()->amount(),
        ]);
    }
}

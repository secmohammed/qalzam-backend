<?php

namespace App\Domain\Order\Pipelines;

use App\Common\Cart\Cart;
use Illuminate\Support\Arr;
use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Order\Http\Events\OrderCreated;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
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
    public function __construct(Cart $cart, OrderRepository $orderRepository, ProductVariationRepository $productVariationRepository, BranchRepository $branchRepository)
    {
        $branch = $branchRepository->find(request('branch') ?? request('branch_id'));
        $this->cart = $cart->setCartType('cart')->withBranch($branch);
        $this->orderRepository = $orderRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {
        //orders for dashboard perspective.
        if ($request->is('api/orders')) {
            $products = $this->productVariationRepository->branches()->wherePivot('branch_id', $request->branch_id)->wherePivotIn('product_variation_id', $request->products)->get();
            $subtotal = $products->reduce(function ($carry, $product) {
                return $carry + $product->pivot->price;
            }, 0);
            if ($request->discount) {
                $subtotal = $subtotal - ($subtotal * $request->discount->percentage / 100);
            }

            $order = $this->orderRepository->firstOrCreate(
                Arr::except($request->validated(), ['products', 'discount_id']) + compact('subtotal')
            );
            $order->products()->sync($products);
        } else {
            //user_orders
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

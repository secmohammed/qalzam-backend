<?php

namespace App\Domain\Order\Pipelines;

use App\Common\Cart\Cart;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Order\Http\Events\OrderCreated;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Pipelines\Pipeline;
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
            $products = $this->productVariationRepository->whereHas('branches', function ($query) use ($request) {
                $query->where('branches.id', $request->branch_id);
                $query->whereIn('branch_product.product_variation_id', array_column($request->products, 'id'));
            })->with('branches')->get();
            $subtotal = $products->reduce(function ($carry, $product) use ($request) {
<<<<<<< HEAD
                dd($product->pivot->price, "price");
                return $carry + ($product->pivot->price * $request->validated()['products'][$product->id]['quantity']);
=======
                $price = $product->branches->where('id', $request->branch_id)->first()->pivot->price ?? $product->price->amount();
                return $carry + $price * $request->validated()['products'][$product->id]['quantity'];
>>>>>>> 3bd68365ee6c3abf38009d5602584e644a827c1e
            }, 0);
            // dd($subtotal);

            if ($request->discount) {
                $subtotal = $subtotal - ($subtotal * $request->discount->percentage / 100);
            }

            $order = $this->orderRepository->firstOrCreate(
                Arr::except($request->validated(), ['products', 'discount_id']) + compact('subtotal')
            );
            $order->products()->sync($request->validated()['products']);
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

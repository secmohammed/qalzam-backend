<?php

namespace App\Domain\Order\Pipelines;

use App\Common\Cart\Cart;
use App\Domain\User\Entities\User;
use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Order\Http\Events\OrderCreated;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;

class CreateUserOrderPipeline implements Pipeline
{
    /**
     * @var mixed
     */
    private $cart, $orderRepository;

    /**
     * @param Cart $cart
     */
    public function __construct(Cart $cart, BranchRepository $branchRepository)
    {
        $branch = $branchRepository->find(request('branch') ?? request('branch_id'));
        $this->cart = $cart->setCartType('cart')->withBranch($branch);
    }

    /**
     * @param $request
     * @param \Closure   $next
     */
    public function handle($request, \Closure $next)
    {

        $order = auth()->user()->orders()->firstOrCreate(
            $this->prepareOrder($request->validated())
        );
        $order->products()->sync($this->cart->products()->forSyncing());

        $request->merge(compact('order'));

        event(new OrderCreated($order));

        return $next($order);
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

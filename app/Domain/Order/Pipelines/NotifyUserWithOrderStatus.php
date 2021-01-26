<?php

namespace App\Domain\Order\Pipelines;

use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Order\Notifications\OrderStatusChanged;

class NotifyUserWithOrderStatus implements Pipeline
{
    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($order, \Closure $next)
    {
        if ($order->isDirty('status')) {
            $order->user->notify(new OrderStatusChanged($order));

        }

        return $next($order);
    }
}

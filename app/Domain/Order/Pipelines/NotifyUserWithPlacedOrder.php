<?php

namespace App\Domain\Order\Pipelines;

use App\Domain\Order\Notifications\OrderPlaced;
use App\Infrastructure\Pipelines\Pipeline;

class NotifyUserWithPlacedOrder implements Pipeline
{
    /**
     * @param $request
     * @param \Closure   $next
     */
    public function handle($order, \Closure $next)
    {
        $order->user->notify(new OrderPlaced($order));

        return $next($order);
    }
}

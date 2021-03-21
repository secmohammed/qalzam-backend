<?php

namespace App\Domain\Order\Pipelines;

use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Order\Notifications\OrderPlaced;

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

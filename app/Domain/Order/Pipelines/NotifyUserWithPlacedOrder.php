<?php

namespace App\Domain\Order\Pipelines;

use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Order\Notifications\OrderPlaced;

class NotifyUserWithPlacedOrder implements Pipeline
{
    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {
        $request->order->user->notify(new OrderPlaced($request->order));

        return $next($request);
    }
}

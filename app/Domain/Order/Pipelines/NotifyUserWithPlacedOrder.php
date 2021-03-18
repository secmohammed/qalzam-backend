<?php

namespace App\Domain\Order\Pipelines;

use App\Domain\Order\Notifications\OrderPlaced;
use App\Infrastructure\Pipelines\Pipeline;

class NotifyUserWithPlacedOrder implements Pipeline
{
    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {
        dd($request->order);

        $request->order->user->notify(new OrderPlaced($request->order));

        return $next($request);
    }
}

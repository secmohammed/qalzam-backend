<?php

namespace App\Domain\Order\Http\Listeners;

use App\Domain\Order\Entities\Order;
use App\Domain\Order\Http\Events\OrderCreated;

class MarkOrderProcessing
{
    /**
     * Handle the event.
     *
     * @param  OrderPaymentFailed  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $event->order->update([
            'status' => Order::PROCESSING,
        ]);
    }
}

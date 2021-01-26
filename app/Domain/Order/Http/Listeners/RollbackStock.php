<?php

namespace App\Domain\Order\Http\Listeners;

use Illuminate\Bus\Queueable;
use App\Orders\Domain\Models\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domain\Order\Http\Events\OrderDestroyed;

class RollbackStock implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * Handle the event.
     *
     * @param  OrderPaymentFailed  $event
     * @return void
     */
    public function handle(OrderDestroyed $event)
    {
        $event->orders->each(function ($order) {
            $order->products->each(function ($product) use ($order) {
                $product->stocks()->create([
                    'quantity' => $product->pivot->quantity,
                    'product_variation_id' => $product->id,
                    'user_id' => $order->user_id,
                ]);
            });
        });
    }
}

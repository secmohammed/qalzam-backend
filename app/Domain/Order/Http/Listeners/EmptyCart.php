<?php

namespace App\Domain\Order\Http\Listeners;

use App\Common\Cart\Cart;
use App\Orders\Domain\Events\OrderCreated;

class EmptyCart
{
    /**
     * @var mixed
     */
    protected $cart;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle()
    {
        $this->cart->empty();
    }
}

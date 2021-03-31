<?php

namespace App\Domain\Order\Http\Events;

use App\Domain\Order\Entities\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GenerateOrderPdfInvoice
{
    use Dispatchable, SerializesModels;

    /**
     * @var mixed
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}

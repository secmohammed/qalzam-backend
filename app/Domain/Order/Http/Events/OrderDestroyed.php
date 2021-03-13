<?php

namespace App\Domain\Order\Http\Events;

use App\Domain\Order\Entities\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;

class OrderDestroyed
{
    use Dispatchable, SerializesModels;

    /**
     * @var mixed
     */
    public $orders;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $orders)
    {
        $this->orders = $orders;
    }
}

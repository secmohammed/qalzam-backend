<?php

namespace App\Domain\Reservation\Entities\Traits\CustomAttributes;

use App\Common\Transformers\Money;

trait ReservationAttributes
{
    /**
     * @return mixed
     */
    public function getFormattedTotalPriceAttribute()
    {
        return $this->total_price->formatted();
    }

    public function getTotalPriceAttribute()
    {

        return new Money($this->price + round($this->order->subtotal->amount()));
    }
}

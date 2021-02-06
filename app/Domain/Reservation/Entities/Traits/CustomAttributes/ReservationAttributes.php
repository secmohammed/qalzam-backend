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
        if ($this->order) {
            return new Money(round($this->price->amount()) + round($this->order->subtotal->amount()));

        }

        return new Money(round($this->price->amount()));
    }
}

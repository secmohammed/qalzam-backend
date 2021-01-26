<?php

namespace App\Domain\Order\Entities\Traits\CustomAttributes;

use App\Common\Transformers\Money;

trait OrderAttributes
{
    /**
     * @param $subtotal
     */
    public function getSubtotalAttribute($subtotal)
    {
        return new Money(round($subtotal));
    }

    /**
     * @return mixed
     */
    public function total()
    {
        return $this->subtotal;
    }
}

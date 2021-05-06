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
        return new Money($subtotal );
    }

    /**
     * @return mixed
     */
    public function total()
    {
        return $this->subtotal;
    }
    public function amount()
    {
        // dd($this->total()->amount());
        return (int) $this->total()->amount();
    }
}

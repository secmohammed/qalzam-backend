<?php

namespace App\Common\Traits;

use App\Common\Transformers\Money;

/**
 * Money Trait
 */
trait HasPrice
{
    public function getFormattedPriceAttribute()
    {

        return $this->price->formatted();
    }

    /**
     * @param $value
     */
    public function getPriceAttribute($value)
    {
        return new Money(round($value * 100));
    }
}

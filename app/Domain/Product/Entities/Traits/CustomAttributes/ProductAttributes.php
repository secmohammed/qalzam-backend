<?php

namespace App\Domain\Product\Entities\Traits\CustomAttributes;

trait ProductAttributes
{
    /**
     * @return mixed
     */
    public function getInStockAttribute()
    {
        return $this->stock_count > 0;
    }

    /**
     * @return mixed
     */
    public function getStockCountAttribute()
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stock_count;
        });
    }
}

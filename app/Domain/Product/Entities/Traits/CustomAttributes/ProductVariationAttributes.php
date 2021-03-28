<?php

namespace App\Domain\Product\Entities\Traits\CustomAttributes;

use App\Common\Transformers\Money;

trait ProductVariationAttributes
{
    /**
     * @return mixed
     */
    public function getInStockAttribute()
    {
        return $this->stock_count > 0;
    }

    /**
     * @param  $value
     * @return mixed
     */
    public function getPriceAttribute($value)
    {
        if (session()->has('current_branch')) {
            $value = $this->branches->where('id', session('current_branch'))->first()->pivot->price;
        }

        if (is_null($value)) {
            return $this->product->price;
        }

        return new Money($value * 100);
    }

    /**
     * @return mixed
     */
    public function getStockCountAttribute()
    {
        return $this->stock->sum('pivot.stock');
    }

    /**
     * @param $amount
     */
    public function minStock($amount)
    {
        return min($this->stock_count, $amount);
    }

    /**
     * @return mixed
     */
    public function priceVaries()
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

}

<?php

namespace App\Domain\Product\Entities\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait PriceOrderable
{
    /**
     * @param Builder $query
     * @param $direction
     * @return mixed
     */
    public function scopeSortPrice(Builder $query, $direction = 'DESC')
    {
        return $query->orderBy('price', $direction);
    }
}

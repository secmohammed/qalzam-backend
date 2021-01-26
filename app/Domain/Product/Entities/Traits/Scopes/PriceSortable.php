<?php

namespace App\Domain\Product\Entities\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;
trait PriceSortable
{
    /**
     * @param Builder $query
     * @param int $start
     * @param int $end
     * @return mixed
     */
    public function scopePriceBetween(Builder $query, int $start, int $end): Builder
    {

        return $query->whereBetween('price', [$start, $end]);
    }
}

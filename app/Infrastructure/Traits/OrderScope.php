<?php

namespace App\Infrastructure\Traits;

use App\Infrastructure\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class OrderScope implements Scope
{
    /**
     * @param Builder $builder
     * @param $order
     */
    public function apply(Builder $builder, $order)
    {

        return $builder->orderBy('created_at', $order);
    }
}

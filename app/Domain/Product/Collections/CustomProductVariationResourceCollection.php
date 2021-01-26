<?php

namespace App\Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;

class CustomProductVariationResourceCollection extends Collection
{
    /**
     * @return mixed
     */
    public function forSyncing()
    {
        return $this->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product->pivot->quantity,
            ];
        })->toArray();
    }
}

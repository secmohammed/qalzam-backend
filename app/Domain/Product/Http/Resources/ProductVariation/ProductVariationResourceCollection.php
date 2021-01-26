<?php

namespace App\Domain\Product\Http\Resources\ProductVariation;

use App\Infrastructure\Http\AbstractResources\BaseCollection as ResourceCollection;

class ProductVariationResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {
        // return $this->toArray($request);
        // don't use $this->collection, but $this->toArray($request)

        return parent::toArray($request);
    }
}

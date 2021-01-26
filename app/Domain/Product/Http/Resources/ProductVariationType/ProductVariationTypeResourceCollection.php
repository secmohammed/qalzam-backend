<?php

namespace App\Domain\Product\Http\Resources\ProductVariationType;

use App\Infrastructure\Http\AbstractResources\BaseCollection as ResourceCollection;

class ProductVariationTypeResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {
        // don't use $this->collection, but $this->toArray($request)

        return parent::toArray($request);
    }
}

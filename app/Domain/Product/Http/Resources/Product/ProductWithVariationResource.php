<?php

namespace App\Domain\Product\Http\Resources\Product;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Domain\Product\Http\Resources\Product\ProductResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResourceCollection;

class ProductWithVariationResource extends ProductResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {
        $variations = Arr::has($this->resource->getRelations(), 'variations') ? [
            'variations' => new ProductVariationResourceCollection(
                $this->variations->groupBy('type.name')
            ),
        ] : [];

        return array_merge(parent::toArray($request), $variations);
    }
}

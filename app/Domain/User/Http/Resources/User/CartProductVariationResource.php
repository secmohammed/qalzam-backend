<?php

namespace App\Domain\User\Http\Resources\User;

use Illuminate\Http\Request;
use App\Common\Transformers\Money;
use App\Domain\Product\Http\Resources\Product\ProductResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;

class CartProductVariationResource extends ProductVariationResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'product' => new ProductResource($this->whenLoaded('product')),
            'quantity' => $this->pivot->quantity,
            'total' => $this->getTotal()->formatted(),
        ]);
    }

    protected function getTotal()
    {
        return new Money($this->pivot->quantity * $this->price->amount());
    }
}

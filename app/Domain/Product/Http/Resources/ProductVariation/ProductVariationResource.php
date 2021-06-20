<?php

namespace App\Domain\Product\Http\Resources\ProductVariation;

use App\Domain\Product\Http\Resources\ProductVariationType\ProductVariationTypeResource;
use App\Domain\User\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource instanceof Collection) {
            return self::collection($this->resource)->toArray($request);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->formattedPrice,
            'price_varies' => $this->priceVaries(),
            'stock_count' => $this->stock_count,
            'status' => $this->status,
            'in_stock' => $this->in_stock,
            'pivot' => $this->pivot,
            'type' => new ProductVariationTypeResource($this->whenLoaded('type')),
            // 'product' => new ProductResource($this->whenLoaded('product')),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at_human' => $this->created_at->diffForHumans(),

        ];
    }
}

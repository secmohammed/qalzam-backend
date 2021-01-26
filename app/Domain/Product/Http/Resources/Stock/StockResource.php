<?php

namespace App\Domain\Product\Http\Resources\Stock;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'variation' => new ProductVariationResource($this->whenLoaded('variation')),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at_human' => $this->created_at->diffForHumans(),

        ];
    }
}

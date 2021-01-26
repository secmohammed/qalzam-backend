<?php

namespace App\Domain\Ingredient\Http\Resources\Ingredient;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Product\Http\Resources\Product\ProductResource;

class IngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'icon' => $this->getFirstMediaUrl('ingredient-icon'),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}

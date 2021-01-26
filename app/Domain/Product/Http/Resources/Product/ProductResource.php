<?php

namespace App\Domain\Product\Http\Resources\Product;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Category\Http\Resources\Category\CategoryResource;
use App\Domain\Ingredient\Http\Resources\Ingredient\IngredientResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->formatted_price,
            'stock_count' => $this->stock_count,
            'in_stock' => $this->in_stock,
            'status' => $this->status,
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
            'images' => $this->getMediaCollectionUrl('product-images'),
            'user' => new UserResource($this->whenLoaded('user')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'variations' => ProductVariationResource::collection($this->whenLoaded('variations')),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}

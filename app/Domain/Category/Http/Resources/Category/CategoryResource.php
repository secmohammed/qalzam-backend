<?php

namespace App\Domain\Category\Http\Resources\Category;

use Illuminate\Http\Request;
use App\Domain\Post\Http\Resources\Post\PostResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Product\Http\Resources\Product\ProductResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'user' => new UserResource($this->whenLoaded('user')),
            'parent' => new self($this->whenLoaded('parent')),
            'type' => $this->type,
            'icon' => $this->getFirstMediaUrl('icon'),
            'children' => CategoryResource::collection($this->whenLoaded('children')),

            $this->mergeWhen($this->type === 'post', [
                'posts' => PostResource::collection($this->whenLoaded('posts')),

            ]),
            $this->mergeWhen($this->type === 'product', [
                'products' => ProductResource::collection($this->whenLoaded('products')),

            ]),
            'created_at_human' => $this->created_at->diffForHumans(),

        ];
    }
}

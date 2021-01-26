<?php

namespace App\Domain\Post\Http\Resources\Post;

use Illuminate\Http\Request;
use App\Common\Http\Resources\MediaResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Category\Http\Resources\Category\CategoryResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class PostResource extends JsonResource
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
            'status' => $this->status,
            'type' => $this->type,
            'image' => $this->getFirstMediaUrl('image'),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'likes_count' => $this->reviews_count,
            'comments_count' => $this->comments_count,
            'user' => new UserResource($this->whenLoaded('user')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'created_at_human' => $this->created_at->diffForHumans(),

        ];
    }
}

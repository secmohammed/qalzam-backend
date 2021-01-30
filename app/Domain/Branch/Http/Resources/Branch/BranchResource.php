<?php

namespace App\Domain\Branch\Http\Resources\Branch;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Location\Http\Resources\Location\LocationResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class BranchResource extends JsonResource
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
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'user' => new UserResource($this->whenLoaded('user')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'media' => $this->getMediaCollectionUrl('branch-gallery'),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}

<?php

namespace App\Domain\Accommodation\Http\Resources\Accommodation;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class AccommodationResource extends JsonResource
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
            'code' => $this->code,
            'branch_id' => $this->branch_id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'price' => $this->price,
            'media' => $this->getMediaCollectionUrl('accommodation-gallery'),
            'capacity' => $this->capacity,
            'type' => $this->type,
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}

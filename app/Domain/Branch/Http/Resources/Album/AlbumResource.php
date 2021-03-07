<?php

namespace App\Domain\Branch\Http\Resources\Album;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class AlbumResource extends JsonResource
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
            'user_id' => $this->user_id,
            'branch_id' => $this->branch_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'media' => $this->getMediaCollectionUrl('album-media'),
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}

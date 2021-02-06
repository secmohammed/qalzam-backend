<?php

namespace App\Domain\Branch\Http\Resources\Album;

use Illuminate\Http\Request;
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
            'media' => $this->getMediaCollectionUrl('album-media'),
            'branch' => new BranchResource($this->whenLoaded('branch')),
        ];
    }
}

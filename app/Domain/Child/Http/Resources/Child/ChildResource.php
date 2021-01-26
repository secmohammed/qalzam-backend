<?php

namespace App\Domain\Child\Http\Resources\Child;

use Illuminate\Http\Request;
use App\Domain\Feed\Http\Resources\Feed\FeedResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Competition\Http\Resources\Competition\CompetitionResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class ChildResource extends JsonResource
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
            'birthdate' => $this->birthdate->format('Y-m-d'),
            'relation' => $this->relation,
            'status' => $this->status,
            'location_id' => $this->location_id,
            'avatar' => $this->getFirstMediaUrl('child-avatar'),
            'national_id' => $this->national_id,
            'birthdate-certificate' => $this->getFirstMediaUrl('child-birthdate-certificate'),
            'feeds' => FeedResource::collection($this->whenLoaded('feeds')),
            'user' => new UserResource($this->whenLoaded('user')),
            'competitions' => CompetitionResource::collection($this->whenLoaded('competitions')),
            'gender' => $this->gender,
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}

<?php

namespace App\Domain\Competition\Http\Resources\Competition;

use Illuminate\Http\Request;
use App\Common\Http\Resources\MediaResource;
use App\Domain\Feed\Http\Resources\Feed\FeedResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Child\Http\Resources\Child\ChildResource;
use App\Domain\Location\Http\Resources\Location\LocationResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class CompetitionResource extends JsonResource
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
            'participants' => ChildResource::collection($this->whenLoaded('children')),
            $this->mergeWhen(is_int($this->children_count), [
                'participant_count' => $this->children_count,
            ]),
            'location' => new LocationResource($this->whenLoaded('location')),
            $this->mergeWhen(auth()->check() && array_key_exists('children', $this->getRelations()), [
                'is_joined' => $this->children->contains('user_id', auth()->id()),
            ]),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'feeds' => FeedResource::collection($this->whenLoaded('feeds')),
            $this->mergeWhen(is_int($this->feeds_count), [
                'feed_count' => $this->feeds_count,
            ]),
            'status' => $this->status,
            'gender' => $this->gender,
            'cover_photo' => $this->getFirstMediaUrl('competition-cover'),
            'type' => $this->type,
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
            'start_date' => $this->start_date->toDayDateTimeString(),
            'end_date' => $this->end_date->toDayDateTimeString(),
            'created_at_human' => $this->created_at->diffForHumans(),

        ];
    }
}

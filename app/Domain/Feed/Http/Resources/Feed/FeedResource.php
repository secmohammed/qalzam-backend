<?php

namespace App\Domain\Feed\Http\Resources\Feed;

use Illuminate\Http\Request;
use App\Common\Http\Resources\MediaResource;
use App\Common\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Child\Http\Resources\Child\ChildResource;
use App\Domain\Competition\Http\Resources\Competition\CompetitionResource;

class FeedResource extends JsonResource
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
            'status' => $this->status,
            'competition_id' => $this->competition_id,
            'child_id' => $this->child_id,
            'child' => new ChildResource($this->whenLoaded('child')),
            'description' => $this->description,
            'user' => new UserResource($this->whenLoaded('user')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'reviews' => $this->whenLoaded('reviews'),
            'competition' => new CompetitionResource($this->whenLoaded('competition')),
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'feed-isomorphic' => $this->getMediaCollectionUrl('feed-isomorphic'),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'feed-isomorphic-ids' => $this->media->pluck('id'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'comments_count' => $this->comments_count,
            'likes_count' => $this->reviews_count,
        ];
    }
}

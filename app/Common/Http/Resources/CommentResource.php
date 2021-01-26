<?php

namespace App\Common\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Feed\Http\Resources\Feed\FeedResource;
use App\Domain\Post\Http\Resources\Post\PostResource;
use App\Domain\User\Http\Resources\User\UserResource;

class CommentResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'body' => $this->body,
            'created_at_human' => $this->created_at->diffForHumans(),
            $this->mergeWhen($this->whenLoaded('commentable'), $this->resolveCommentable()),
            'likes_count' => $this->reviews_count ?? 0,
            'replies' => self::collection($this->whenLoaded('children')),
        ];
    }

    protected function resolveCommentable()
    {
        switch (class_basename($this->commentable)) {
            case 'Post':
                return [
                    'post' => (new PostResource($this->commentable))->toArray($this->request),
                ];
            case 'Feed':
                return [
                    'feed' => (new FeedResource($this->commentable))->toArray($this->request),
                ];
            default:
                return [];
        }
    }
}

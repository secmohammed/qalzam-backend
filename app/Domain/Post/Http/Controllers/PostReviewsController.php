<?php

namespace App\Domain\Post\Http\Controllers;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Http\Requests\Review\PostReviewStoreFormRequest;
use App\Domain\Post\Http\Requests\Review\PostReviewUpdateFormRequest;
use App\Domain\Post\Repositories\Contracts\PostRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use Joovlly\Reviewable\Models\Review;

class PostReviewsController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'posts';

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'posts';

    /**
     * View Path
     *
     * @var string
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Review $review)
    {
        $review->delete();
        $this->redirectBack();
        $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostReviewStoreFormRequest $request, Post $post)
    {
        $review = $post->createReview($request->score, $request->body);
        if ($review) {
            $this->redirectBack("{$this->resourceRoute}.show", [$review->id]);
            $this->setApiResponse(fn() => response()->json(['created' => true, 'review' => $review]));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['created' => false]));
        }

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PostReviewUpdateFormRequest $request, Post $post, Review $review)
    {
        $review->update($request->validated());
        $this->redirectBack("{$this->resourceRoute}.show", [$review->id]);
        $this->setApiResponse(fn() => response()->json(['updated' => true, 'review' => $review->fresh()]));

        return $this->response();
    }
}

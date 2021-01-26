<?php

namespace App\Domain\Feed\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Feed\Entities\Feed;
use Joovlly\Reviewable\Models\Review;
use App\Domain\Feed\Notifications\FeedLiked;
use App\Domain\Feed\Http\Requests\Review\FeedReviewStoreFormRequest;
use App\Domain\Feed\Http\Requests\Review\FeedReviewUpdateFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class FeedReviewsController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'feeds';

    /**
     * @var PostRepository
     */
    protected $feedRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'feeds';

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
    public function destroy(Feed $feed, Review $review)
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
    public function store(FeedReviewStoreFormRequest $request, Feed $feed)
    {
        $review = $feed->createReview($request->score ?? 5, $request->body);
        $feed->user->notify(new FeedLiked($feed, $review));
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
    public function update(FeedReviewUpdateFormRequest $request, Feed $feed, Review $review)
    {
        $review->update($request->validated());
        $this->redirectBack("{$this->resourceRoute}.show", [$review->id]);
        $this->setApiResponse(fn() => response()->json(['updated' => true, 'review' => $review->fresh()]));

        return $this->response();
    }
}

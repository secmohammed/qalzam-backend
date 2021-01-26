<?php

namespace App\Domain\Feed\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Feed\Entities\Feed;
use Joovlly\Commentable\Models\Comment;
use App\Domain\Feed\Notifications\FeedCommented;
use App\Domain\Feed\Repositories\Contracts\FeedRepository;
use App\Domain\Feed\Http\Requests\Comment\CommentStoreFormRequest;
use App\Domain\Feed\Http\Requests\Comment\CommentUpdateFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class FeedCommentsController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'feeds';

    /**
     * @var FeedRepository
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
    public function destroy($feed, Comment $comment)
    {
        $delete = $comment->delete();
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
    public function store(CommentStoreFormRequest $request, Feed $feed)
    {
        $comment = $feed->comment($request->validated() + ['commentable_id' => $feed->id]);
        $feed->user->notify(new FeedCommented($feed, $comment));
        if ($comment) {
            $this->redirectBack("{$this->resourceRoute}.show", [$comment->id]);
            $this->setApiResponse(fn() => response()->json(['created' => true, 'comment' => $comment]));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['created' => false]));
        }

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdateFormRequest $request, Feed $feed, Comment $comment)
    {
        $feed->updateComment($comment->id, $request->validated());
        $this->redirectBack();
        $this->setApiResponse(fn() => response()->json(['updated' => true, 'comment' => $comment->fresh()], 201));

        return $this->response();
    }
}

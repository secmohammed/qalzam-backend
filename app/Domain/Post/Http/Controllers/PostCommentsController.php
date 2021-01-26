<?php

namespace App\Domain\Post\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Post\Entities\Post;
use Joovlly\Commentable\Models\Comment;
use App\Domain\Post\Repositories\Contracts\PostRepository;
use App\Domain\Post\Http\Requests\Comment\CommentStoreFormRequest;
use App\Domain\Post\Http\Requests\Comment\CommentUpdateFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class PostCommentsController extends Controller
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
    public function destroy($post, Comment $comment)
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
    public function store(CommentStoreFormRequest $request, Post $post)
    {
        $comment = $post->comment($request->validated() + ['commentable_id' => $post->id]);
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
    public function update(CommentUpdateFormRequest $request, Post $post, Comment $comment)
    {
        $post->updateComment($comment->id, $request->validated());
        $this->redirectBack();
        $this->setApiResponse(fn() => response()->json(['updated' => true, 'comment' => $comment->fresh()], 201));

        return $this->response();
    }
}

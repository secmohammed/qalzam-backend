<?php

namespace App\Domain\Post\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Post\Entities\Post;
use App\Domain\Category\Entities\Category;
use App\Domain\Post\Events\Http\PostCreated;
use App\Domain\Post\Http\Resources\Post\PostResource;
use App\Domain\Post\Repositories\Contracts\PostRepository;
use App\Domain\Post\Http\Requests\Post\PostStoreFormRequest;
use App\Domain\Post\Http\Requests\Post\PostUpdateFormRequest;
use App\Domain\Post\Http\Resources\Post\PostResourceCollection;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class PostController extends Controller
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
    protected $viewPath = 'post';

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.post'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $categories = Category::all();
        $this->setData('categories', $categories);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = explode(',', request()->get('ids', $id));

        $slugs = implode(',', $this->postRepository->whereIn('slug', $ids)->get()->pluck('slug')->toArray());

        $delete = $this->postRepository->destroy($slugs);
        if ($delete->count()) {
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['deleted' => false], 404));
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.post') . ' : ' . $post->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $categories = Category::all();
        $this->setData('categories', $categories);

        $post->load('translations');
        $this->setData('edit', $post);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(PostResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->postRepository->spatie()->paginate(
            $request->per_page ?? config('clinic9.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.post'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(PostResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.post') . ' : ' . $post->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('post', $post);
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(PostResource::class, 'post');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreFormRequest $request)
    {
        $post = $this->postRepository->make($request->validated());
        $post->user()->associate(auth()->user());
        $post->save();

        $post->setTranslation([
            'title' => $request->title_ar,
            'description' => $request->description_ar,
        ], 'ar');

        event(new PostCreated($post));
        if ($request->has('categories')) {
            $post->categories()->attach($request->validated()['categories']);
        }
        if ($request->has('image') && $post) {
            if ($post->hasMedia('image')) {
                $post->clearMediaCollection('image');
            }
            $post->addMedia($request->file('image'))->toMediaCollection('image');
        }
        $this->setData('data', $post);
        $this->redirectRoute("{$this->resourceRoute}.show", [$post->slug]);
        $this->useCollection(PostResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateFormRequest $request, Post $post)
    {
        $post->update($request->validated());

        $post->setTranslation([
            'title' => $request->title_ar,
            'description' => $request->description_ar,
        ], 'ar', true);

        if ($request->has('categories')) {
            $post->categories()->sync($request->validated()['categories']);
        }
        if ($request->has('image') && $post) {
            if ($post->hasMedia('image')) {
                $post->clearMediaCollection('image');
            }
            $post->addMedia($request->file('image'))->toMediaCollection('image');
        }

        $this->redirectRoute("{$this->resourceRoute}.show", [$post->slug]);
        $this->setData('data', $post);
        $this->useCollection(PostResource::class, 'data');

        return $this->response();
    }
}

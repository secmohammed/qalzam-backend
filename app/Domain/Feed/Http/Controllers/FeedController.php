<?php

namespace App\Domain\Feed\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Feed\Entities\Feed;
use App\Domain\Child\Entities\Child;
use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Competition\Entities\Competition;
use App\Domain\Feed\Notifications\CompetitionWon;
use App\Domain\Feed\Http\Resources\Feed\FeedResource;
use App\Domain\Feed\Repositories\Contracts\FeedRepository;
use App\Domain\Feed\Http\Requests\Feed\FeedStoreFormRequest;
use App\Domain\Feed\Http\Requests\Feed\FeedUpdateFormRequest;
use App\Domain\Feed\Http\Resources\Feed\FeedResourceCollection;
use App\Domain\Competition\Repositories\Contracts\CompetitionRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class FeedController extends Controller
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
    protected $viewPath = 'feed';

    /**
     * @param FeedRepository $feedRepository
     */
    public function __construct(FeedRepository $feedRepository, CompetitionRepository $competitionRepository)
    {
        $this->feedRepository = $feedRepository;
        $this->competitionRepository = $competitionRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.feed'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $competitions = Competition::all();
        $this->setData('competitions', $competitions);

        $children = Child::all();
        $this->setData('children', $children);

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
        $ids = request()->get('ids', $id);

        $delete = $this->feedRepository->destroy($ids)->count();

        if ($delete) {
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
    public function edit(Feed $feed)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.feed') . ' : ' . $feed->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $feed);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(FeedResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->feedRepository->spatie()->paginate(
            $request->per_page ?? config('semak.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.feed'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(FeedResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Feed $feed)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.feed') . ' : ' . $feed->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $feed);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(FeedResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeedStoreFormRequest $request)
    {

        // if ($request->user()->feeds()->where('competition_id', $request->competition_id)->count()) {
        //     $this->setApiResponse(fn() => response()->json(['message' => 'you cannot create more than one feed'], 422));
        //     $this->redirectBack();

        //     return $this->response();
        // }
        // if (collect($request->file('feed-isomorphic'))->count() > 10) {
        //     $this->setApiResponse(fn() => response()->json(['message' => 'you cannot create a feed with more than 10 feed image/video'], 422));
        //     $this->redirectBack();

        //     return $this->response();
        // }
        //TODO: verify end date of competitions before storing feed.
        // $competition = $this->competitionRepository->find($request->competition_id);
        // if ($competition->end_date->lt(now())) {
        //     $this->setApiResponse(fn() => response()->json(['message' => 'You cannot create a feed for a competition ended.']));
        //     $this->redirectBack();

        //     return $this->response();

        // }
        $feed = $this->feedRepository->create($request->validated());
        if ($feed->status === 'winner') {
            $feed->user->notify(new CompetitionWon($feed));
        }

        app(Pipeline::class)->send([
            'model' => $feed,
            'request' => $request,
            'name' => 'feed-isomorphic',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $feed->fresh());

        $this->redirectRoute("{$this->resourceRoute}.show", [$feed->id]);
        $this->useCollection(FeedResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeedUpdateFormRequest $request, Feed $feed)
    {
        if ($request->has('deleted-feeds')) {
            $feed->media()->detach($request->get('deleted-feeds'));
        };
        if (collect($request->file('feed-isomorphic'))->count() + $feed->media()->count() > 10) {
            $this->setApiResponse(fn() => response()->json(['message' => ' you cannot create a feed with more than 10 feed image/video']));
            $this->redirectBack();

            return $this->response();
        }
        $feed->load('user');

        $feed->update($request->validated());
        if ($feed->status === 'winner') {
            $feed->user->notify(new CompetitionWon($feed));
        }
        app(Pipeline::class)->send([
            'model' => $feed,
            'request' => $request,
            'name' => 'feed-isomorphic',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();
        $this->redirectRoute("{$this->resourceRoute}.show", [$feed->id]);
        $this->setData('data', $feed);
        $this->useCollection(FeedResource::class, 'data');

        return $this->response();
    }
}

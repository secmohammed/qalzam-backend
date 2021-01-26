<?php

namespace App\Domain\Competition\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;
use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Competition\Entities\Competition;
use App\Domain\Location\Repositories\Contracts\LocationRepository;
use App\Domain\Competition\Repositories\Contracts\CompetitionRepository;
use App\Domain\Competition\Http\Resources\Competition\CompetitionResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Competition\Http\Requests\Competition\CompetitionStoreFormRequest;
use App\Domain\Competition\Http\Requests\Competition\CompetitionUpdateFormRequest;
use App\Domain\Competition\Http\Resources\Competition\CompetitionResourceCollection;

class CompetitionController extends Controller
{
    use Responder;

    /**
     * @var CompetitionRepository
     */
    protected $competitionRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'competitions';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'competitions';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'competition';

    /**
     * @param CompetitionRepository $competitionRepository
     */
    public function __construct(CompetitionRepository $competitionRepository, LocationRepository $locationRepository)
    {
        $this->competitionRepository = $competitionRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.competition'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('locations', $this->locationRepository->where('type', 'district')->get(), 'web');

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

        $delete = $this->competitionRepository->destroy($ids)->count();

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
    public function edit(Competition $competition)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.competition') . ' : ' . $competition->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $competition->load('translations');
        $this->setData('edit', $competition);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(CompetitionResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->competitionRepository->spatie()->paginate(
            $request->per_page ?? config('semak.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.competition'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(CompetitionResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        if (!request()->is('api/*')) {
            $competition = $competition->where('id', $competition->id)->with('feeds.child', 'feeds.comments', 'feeds.reviews')->withTopRatedParticipants()->first();
        }
        $this->setData('title', __('main.show') . ' ' . __('main.competition') . ' : ' . $competition->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $competition);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(CompetitionResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetitionStoreFormRequest $request)
    {
        $competition = $this->competitionRepository->create($request->validated());
        app(Pipeline::class)->send([
            'model' => $competition,
            'request' => $request,
            'name' => 'competition-cover',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $competition->setTranslation([
            'name' => $request->name_ar,
        ], 'ar');

        $this->setData('data', $competition);

        $this->redirectRoute("{$this->resourceRoute}.show", [$competition->id]);
        $this->useCollection(CompetitionResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompetitionUpdateFormRequest $request, Competition $competition)
    {
        $competition->update($request->validated());
        app(Pipeline::class)->send([
            'model' => $competition,
            'request' => $request,
            'name' => 'competition-cover',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();
        optional($request->name_ar, fn($name) => $competition->setTranslation(compact('name'), 'ar', true));

        $this->redirectRoute("{$this->resourceRoute}.show", [$competition->id]);
        $this->setData('data', $competition);
        $this->useCollection(CompetitionResource::class, 'data');

        return $this->response();
    }
}

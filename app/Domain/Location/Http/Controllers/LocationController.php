<?php

namespace App\Domain\Location\Http\Controllers;

use App\Domain\Location\Datatables\LocationDataTable;
use App\Domain\Location\Entities\Location;
use App\Domain\Location\Http\Requests\Location\LocationStoreFormRequest;
use App\Domain\Location\Http\Requests\Location\LocationUpdateFormRequest;
use App\Domain\Location\Http\Resources\Location\LocationResource;
use App\Domain\Location\Http\Resources\Location\LocationResourceCollection;
use App\Domain\Location\Repositories\Contracts\LocationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class LocationController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'locations';

    /**
     * @var LocationRepository
     */
    protected $locationRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'locations';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'location';

    /**
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.location'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $locations = $this->locationRepository->all();
        $this->setData('locations', $locations);
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
        $delete = $this->locationRepository->destroy($ids)->count();
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
    public function edit(Location $location)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.location') . ' : ' . $location->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $locations = Location::where('id', "!=", $location->id)->get();
        $this->setData('locations', $locations);

        $location->load('translations');
        $this->setData('edit', $location);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(LocationResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->locationRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.locations'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(LocationResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param LocationDataTable $dataTable
     * @return mixed
     */
    public function dataTable(LocationDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCityDistricts(Request $request)
    {
        // dd($this->locationRepository->find(22)->up());
        $index = $this->locationRepository->descendantsOf($request->id)->where('type', "zone")->where('status', "active");

        $this->setData('title', __('main.show-all') . ' ' . __('main.locations'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(LocationResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.

     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.location') . ' : ' . $location->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $location);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(LocationResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreFormRequest $request)
    {

        $location = $this->locationRepository->make($request->validated());
        $location->user()->associate(auth()->user());
        $location->save();

        $location->setTranslation([
            'name' => $request->name_ar,
        ], 'ar');

        $location->load('translations');

        if ($location) {
            $this->setData('data', $location);

            $this->redirectRoute("{$this->resourceRoute}.show", [$location->id]);
            $this->useCollection(LocationResource::class, 'data');
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
    public function update(LocationUpdateFormRequest $request, Location $location)
    {
        $location->update($request->validated());
        $location->setTranslation([
            'name' => $request->name_ar,
        ], 'ar', true);

        $this->redirectRoute("{$this->resourceRoute}.show", [$location->id]);
        $this->setData('data', $location);
        $this->useCollection(LocationResource::class, 'data');

        return $this->response();
    }
}

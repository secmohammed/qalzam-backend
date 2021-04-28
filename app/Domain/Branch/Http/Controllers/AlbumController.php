<?php

namespace App\Domain\Branch\Http\Controllers;

use App\Domain\Branch\Datatables\AlbumDataTable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Branch\Entities\Album;
use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Branch\Http\Resources\Album\AlbumResource;
use App\Domain\Branch\Repositories\Contracts\AlbumRepository;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Branch\Http\Requests\Album\AlbumStoreFormRequest;
use App\Domain\Branch\Http\Requests\Album\AlbumUpdateFormRequest;
use App\Domain\Branch\Http\Resources\Album\AlbumResourceCollection;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class AlbumController extends Controller
{
    use Responder;

    /**
     * @var AlbumRepository
     */
    protected $albumRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'branches';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'albums';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'album';

    /**
     * @param AlbumRepository $albumRepository
     */
    public function __construct(AlbumRepository $albumRepository, BranchRepository $branchRepository)
    {
        $this->albumRepository = $albumRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.album'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('branches', $this->branchRepository->all());
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

        $delete = $this->albumRepository->destroy($ids)->count();

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
    public function edit(Album $album)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.album') . ' : ' . $album->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('branches', $this->branchRepository->all());
        $this->setData('edit', $album);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(AlbumResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->albumRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.album'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(AlbumResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param AlbumDataTable $datatable
     * @return mixed
     */
    public function dataTable(AlbumDataTable  $datatable)
    {
        return $datatable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.album') . ' : ' . $album->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('album', $album);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(AlbumResource::class, 'album');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumStoreFormRequest $request)
    {
        $album = $this->albumRepository->create($request->validated());
        app(Pipeline::class)->send([
            'model' => $album,
            'request' => $request,
            'name' => 'album-gallery',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $album);

        $this->redirectRoute("{$this->resourceRoute}.show", [$album->id]);
        $this->useCollection(AlbumResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumUpdateFormRequest $request, Album $album)
    {
        $album->update($request->validated());
        app(Pipeline::class)->send([
            'model' => $album,
            'request' => $request,
            'name' => 'album-gallery',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$album->id]);
        $this->setData('data', $album);
        $this->useCollection(AlbumResource::class, 'data');

        return $this->response();
    }
}

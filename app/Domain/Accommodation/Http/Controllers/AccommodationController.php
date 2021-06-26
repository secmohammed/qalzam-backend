<?php

namespace App\Domain\Accommodation\Http\Controllers;

use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Accommodation\Datatables\AccommodationDataTable;
use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Accommodation\Http\Requests\Accommodation\AccommodationStoreFormRequest;
use App\Domain\Accommodation\Http\Requests\Accommodation\AccommodationUpdateFormRequest;
use App\Domain\Accommodation\Http\Resources\Accommodation\AccommodationResource;
use App\Domain\Accommodation\Http\Resources\Accommodation\AccommodationResourceCollection;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Accommodation\Repositories\Contracts\ContractRepository;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;

class AccommodationController extends Controller
{
    use Responder;

    /**
     * @var AccommodationRepository
     */
    protected $accommodationRepository;
    protected $categoryRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'accommodations';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'accommodations';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'accommodation';

    /**
     * @param AccommodationRepository $accommodationRepository
     */
    public function __construct(AccommodationRepository $accommodationRepository, CategoryRepository $categoryRepository)
    {
        $this->accommodationRepository = $accommodationRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BranchRepository $branchRepository, Accommodation $accommodation, ContractRepository $contractRepository)
    {
        $this->setData('title', __('main.add') . ' ' . __('main.accommodation'), 'web');
        $this->setData('categories', $this->categoryRepository->where('status', 'active')->where('type', 'accommodations')->get());
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('branches', $branchRepository->all());
        $this->setData('contracts', $contractRepository->all());
        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids', $id);

        $delete = $this->accommodationRepository->destroy($ids)->count();

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
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Accommodation $accommodation, BranchRepository $branchRepository, ContractRepository $contractRepository)
    {
        $this->setData('categories', $this->categoryRepository->where('status', 'active')->where('type', 'accommodation')->get());
        $this->setData('title', __('main.edit') . ' ' . __('main.accommodation') . ' : ' . $accommodation->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('categories', $this->categoryRepository->where('status', 'active')->where('type', 'accommodations')->get());
        $this->setData('branches', $branchRepository->all());
        $this->setData('edit', $accommodation);
        $this->setData('contracts', $contractRepository->all());
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(AccommodationResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->accommodationRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.accommodation'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(AccommodationResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param AccommodationDataTable $datatable
     * @return mixed
     */
    public function dataTable(AccommodationDataTable  $datatable)
    {
        return $datatable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show(Accommodation $accommodation)
    {
        // dd($accommodation->contracts/);
        
        $this->setData('title', __('main.show') . ' ' . __('main.accommodation') . ' : ' . $accommodation->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('categories', $this->categoryRepository->where('status', 'active')->where('type', 'accommodation')->get());
        $this->setData('accommodation', $accommodation);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(AccommodationResource::class, 'accommodation');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccommodationStoreFormRequest $request)
    {

        $accommodation = $this->accommodationRepository->create($request->validated());
        $accommodation->categories()->attach($request->categories);
        $accommodation->contracts()->syncWithoutDetaching($request->contracts);
        app(Pipeline::class)->send([
            'model' => $accommodation,
            'request' => $request,
            'name' => 'accommodation-gallery',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $accommodation);

        $this->redirectRoute("{$this->resourceRoute}.show", [$accommodation->id]);
        $this->useCollection(AccommodationResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccommodationUpdateFormRequest $request, Accommodation $accommodation)
    {
        $accommodation->update($request->validated());

        if ($request->categories) {
            $accommodation->categories()->sync($request->categories);
        }
        if ($request->contracts) {
            $accommodation->contracts()->sync($request->contracts);
        }

        if ($request->{'accommodation-gallery'}) {
            app(Pipeline::class)->send([
            'model' => $accommodation,
            'request' => $request,
            'name' => 'accommodation-gallery',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();
        }
        $this->redirectRoute("{$this->resourceRoute}.show", [$accommodation->id]);
        $this->setData('data', $accommodation);
        $this->useCollection(AccommodationResource::class, 'data');

        return $this->response();
    }
    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->accommodationRepository->destroy($ids)->count();

        if ($delete) {
            $args = [];
            $type = $request->get('type');
            if($type != '')
                $args = ['type' => $type];
            $this->redirectRoute("{$this->resourceRoute}.index", $args);
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 404));
        }

        return $this->response();
        //todo implement the method logic....
    }

}

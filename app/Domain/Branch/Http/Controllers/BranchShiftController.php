<?php

namespace App\Domain\Branch\Http\Controllers;

use App\Domain\Branch\Datatables\BranchShiftDataTable;
use App\Domain\Branch\Entities\BranchShift;
use App\Domain\Branch\Http\Requests\BranchShift\BranchShiftStoreFormRequest;
use App\Domain\Branch\Http\Requests\BranchShift\BranchShiftUpdateFormRequest;
use App\Domain\Branch\Http\Resources\BranchShift\BranchShiftResource;
use App\Domain\Branch\Http\Resources\BranchShift\BranchShiftResourceCollection;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Branch\Repositories\Contracts\BranchShiftRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class BranchShiftController extends Controller
{
    use Responder;

    /**
     * @var BranchShiftRepository
     */
    protected $branchshiftRepository;

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
    protected $resourceRoute = 'branch_shifts';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'branchshift';

    /**
     * @param BranchShiftRepository $branchshiftRepository
     */
    public function __construct(BranchShiftRepository $branchshiftRepository, BranchRepository $branchRepository)
    {
        $this->branchshiftRepository = $branchshiftRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd($this->branchshiftRepository);
        $this->setData('title', __('main.add') . ' ' . __('main.branch_shift'), 'web');
        $this->setData('branches', $this->branchRepository->where("status", "active")->get());

        $this->setData('alias', $this->domainAlias, 'web');

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

        $delete = $this->branchshiftRepository->destroy($ids)->count();

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
    public function edit(BranchShift $branch_shift)
    {
        // dd(1)
        $this->setData('title', __('main.edit') . ' ' . __('main.branch_shift') . ' : ' . $branch_shift->id, 'web');
        $this->setData('branches', $this->branchRepository->where("status", "active")->get());

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $branch_shift);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(BranchShiftResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $index = $this->branchshiftRepository->spatie()->paginate(
            config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.branch_shift'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(BranchShiftResourceCollection::class, 'data');
        return $this->response();

    }

    /**
     * @param BranchShiftDataTable $datatable
     * @return mixed
     */
    public function dataTable(BranchShiftDataTable  $datatable)
    {
        return $datatable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BranchShift $branch_shift)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.branch_shift') . ' : ' . $branch_shift->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('branch_shift', $branch_shift->load("branch"));

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(BranchShiftResource::class, 'branch_shift');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchShiftStoreFormRequest $request)
    {
        $store = $this->branchshiftRepository->create($request->validated());

        $this->setData('data', $store);

        $this->redirectRoute("{$this->resourceRoute}.show", [$store->id]);
        $this->useCollection(BranchShiftResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchShiftUpdateFormRequest $request, BranchShift $branch_shift)
    {
        $branch_shift->update($request->validated());
        $this->redirectRoute("{$this->resourceRoute}.show", [$branch_shift->id]);
        $this->setData('data', $branch_shift);
        $this->useCollection(BranchShiftResource::class, 'data');

        return $this->response();
    }
    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->branchshiftRepository->destroy($ids)->count();

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

<?php

namespace App\Domain\Accommodation\Http\Controllers;

use App\Domain\Accommodation\Datatables\ContractDataTable;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Accommodation\Http\Requests\Contract\ContractStoreFormRequest;
use App\Domain\Accommodation\Http\Requests\Contract\ContractUpdateFormRequest;
use App\Domain\Accommodation\Http\Resources\Contract\ContractResource;
use App\Domain\Accommodation\Http\Resources\Contract\ContractResourceCollection;
use App\Domain\Accommodation\Repositories\Contracts\ContractRepository;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use App\Domain\Product\Repositories\Contracts\TemplateRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class ContractController extends Controller
{
    use Responder;

    /**
     * @var ContractRepository
     */
    protected $contractRepository;
    protected $templateRepository;
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
    protected $resourceRoute = 'contracts';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'contract';

    /**
     * @param ContractRepository $contractRepository
     */
    public function __construct(ContractRepository $contractRepository, TemplateRepository $templateRepository, CategoryRepository $categoryRepository)
    {
        $this->contractRepository = $contractRepository;
        $this->templateRepository = $templateRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.contract'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('templates', $this->templateRepository->all());

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

        $delete = $this->contractRepository->destroy($ids)->count();

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
    public function edit(Contract $contract)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.contract') . ' : ' . $contract->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $contract);
        $this->setData('templates', $this->templateRepository->all());

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ContractResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->contractRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.contract'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ContractResourceCollection::class, 'data');

        return $this->response();
    }

    public function DataTable(ContractDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.contract') . ' : ' . $contract->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('contract', $contract);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(ContractResource::class, 'contract');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractStoreFormRequest $request)
    {
        $store = $this->contractRepository->create($request->validated());

        if ($store) {
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show", [$store->id]);
            $this->useCollection(ContractResource::class, 'data');
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
    public function update(ContractUpdateFormRequest $request, Contract $contract)
    {
        $contract->update($request->validated());
        $this->redirectRoute("{$this->resourceRoute}.show", [$contract->id]);
        $this->setData('data', $contract);
        $this->useCollection(ContractResource::class, 'data');

        return $this->response();
    }
    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->contractRepository->destroy($ids)->count();

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

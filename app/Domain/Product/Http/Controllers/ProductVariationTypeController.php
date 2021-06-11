<?php

namespace App\Domain\Product\Http\Controllers;

use App\Domain\Product\Datatables\ProductVariationTypeDataTable;
use App\Domain\Product\Entities\ProductVariationType;
use App\Domain\Product\Http\Requests\ProductVariationType\ProductVariationTypeStoreFormRequest;
use App\Domain\Product\Http\Requests\ProductVariationType\ProductVariationTypeUpdateFormRequest;
use App\Domain\Product\Http\Resources\ProductVariationType\ProductVariationTypeResource;
use App\Domain\Product\Http\Resources\ProductVariationType\ProductVariationTypeResourceCollection;
use App\Domain\Product\Repositories\Contracts\ProductVariationTypeRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class ProductVariationTypeController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'products';

    /**
     * @var ProductVariationTypeRepository
     */
    protected $productvariationtypeRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'product_variation_types';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'productvariationtype';

    /**
     * @param ProductVariationTypeRepository $productvariationtypeRepository
     */
    public function __construct(ProductVariationTypeRepository $productvariationtypeRepository)
    {
        $this->productvariationtypeRepository = $productvariationtypeRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.productvariationtype'), 'web');

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

        $delete = $this->productvariationtypeRepository->destroy($ids)->count();

        if ($delete) {
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 404));
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductVariationType $product_variation_type)
    {
        $product_variation_type->load('translations');
        $this->setData('title', __('main.edit') . ' ' . __('main.product_variation_type') . ' : ' . $product_variation_type->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $product_variation_type);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ProductVariationTypeResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->productvariationtypeRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.productvariationtype'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ProductVariationTypeResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param ProductVariationTypeDataTable $dataTable
     * @return mixed
     */
    public function dataTable(ProductVariationTypeDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariationType $productVariationType)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.productvariationtype') . ' : ' . $productVariationType->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $productVariationType);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(ProductVariationTypeResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductVariationTypeStoreFormRequest $request)
    {
        $store = $this->productvariationtypeRepository->create($request->validated());

        $store->setTranslation([
            'name' => $request->name_ar,
        ], 'ar');

        $this->setData('data', $store);

        $this->redirectRoute("{$this->resourceRoute}.show", [$store->id]);
        $this->useCollection(ProductVariationTypeResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductVariationTypeUpdateFormRequest $request, ProductVariationType $productVariationType)
    {
        $productVariationType->update($request->validated());

        $productVariationType->setTranslation([
            'name' => $request->name_ar,
        ], 'ar', true);

        $this->redirectRoute("{$this->resourceRoute}.show", [$productVariationType->id]);
        $this->setData('data', $productVariationType);
        $this->useCollection(ProductVariationTypeResource::class, 'data');

        return $this->response();
    }
    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->productvariationtypeRepository->destroy($ids)->count();

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

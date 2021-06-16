<?php

namespace App\Domain\Product\Http\Controllers;

use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Product\Datatables\ProductVariationDataTable;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Http\Requests\ProductVariation\ProductVariationStoreFormRequest;
use App\Domain\Product\Http\Requests\ProductVariation\ProductVariationUpdateFormRequest;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResourceCollection;
use App\Domain\Product\Repositories\Contracts\ProductRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationTypeRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Joovlly\DDD\Traits\Responder;

class ProductVariationController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'products';

    /**
     * @var ProductVariationRepository
     */
    protected $productvariationRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'product_variations';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'productvariation';

    /**
     * @param ProductVariationRepository $productvariationRepository
     */
    public function __construct(ProductVariationRepository $productvariationRepository, ProductRepository $productRepository, ProductVariationTypeRepository $productVariationTypeRepository)
    {
        // DB::connection()->enableQueryLog();
        // $queries = DB::getQueryLog();
        // return dd($queries);
        $this->productvariationRepository = $productvariationRepository;
        $this->productRepository = $productRepository;
        $this->productVariationTypeRepository = $productVariationTypeRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.productvariation'), 'web');
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('products', $this->productRepository->all());
        $this->setData('productVariationTypes', $this->productVariationTypeRepository->all());

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

        $delete = $this->productvariationRepository->destroy($ids)->count();

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
    public function edit(ProductVariation $product_variation)
    {
        $product_variation->load('translations');
        $this->setData('title', __('main.edit') . ' ' . __('main.productvariation') . ' : ' . $product_variation->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('edit', $product_variation);
        $this->setData('products', $this->productRepository->all());
        $this->setData('productVariationTypes', $this->productVariationTypeRepository->all());
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ProductVariationResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $index = $this->productvariationRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.productvariation'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ProductVariationResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param ProductVariationDataTable $dataTable
     * @return mixed
     */
    public function dataTable(ProductVariationDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariation $productVariation)
    {
        $productVariation;
      
        $this->setData('title', __('main.show') . ' ' . __('main.productvariation') . ' : ' . $productVariation->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $productVariation->load('product'));

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(ProductVariationResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductVariationStoreFormRequest $request)
    {
        $productVariation = $this->productvariationRepository->create($request->validated());

        $productVariation->setTranslation([
            'name' => $request->name_ar,
        ], 'ar', true);

        app(Pipeline::class)->send([
            'model' => $productVariation,
            'request' => $request,
            'name' => 'product_variation-images',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $productVariation);

        $this->redirectRoute("{$this->resourceRoute}.show", [$productVariation->id]);
        $this->useCollection(ProductVariationResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductVariationUpdateFormRequest $request, ProductVariation $productVariation)
    {
        $productVariation->update($request->validated());
        $productVariation->setTranslation([
            'name' => $request->name_ar,
        ], 'ar', true);

        app(Pipeline::class)->send([
            'model' => $productVariation,
            'request' => $request,
            'name' => 'product_variation-images',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$productVariation->id]);
        $this->setData('data', $productVariation);
        $this->useCollection(ProductVariationResource::class, 'data');

        return $this->response();
    }
    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->productvariationRepository->destroy($ids)->count();

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

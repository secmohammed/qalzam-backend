<?php

namespace App\Domain\Product\Http\Controllers;

use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Http\Requests\Product\ProductStoreFormRequest;
use App\Domain\Product\Http\Requests\Product\ProductUpdateFormRequest;
use App\Domain\Product\Http\Resources\Product\ProductResource;
use App\Domain\Product\Http\Resources\Product\ProductWithVariationResource;
use App\Domain\Product\Http\Resources\Product\ProductWithVariationResourceCollection;
use App\Domain\Product\Repositories\Contracts\ProductRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;

class ProductController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'products';

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'products';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'product';

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.product'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('categories', $this->categoryRepository->where('status', 'active')->where('type', 'products')->get());
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

        $delete = $this->productRepository->destroy($ids)->count();

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
    public function edit(Product $product)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.product') . ' : ' . $product->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('categories', $this->categoryRepository->where('status', 'active')->where('type', 'products  ')->get());

        $this->setData('edit', $product);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ProductWithVariationResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.product'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $products);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ProductWithVariationResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.product') . ' : ' . $product->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('show', $product);
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");
        $this->useCollection(ProductResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreFormRequest $request)
    {
        $product = $this->productRepository->create($request->validated());
        $product->categories()->attach($request->categories);
        app(Pipeline::class)->send([
            'model' => $product,
            'request' => $request,
            'name' => 'product-images',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $product);

        $this->redirectRoute("{$this->resourceRoute}.show", [$product->id]);
        $this->useCollection(ProductResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateFormRequest $request, Product $product)
    {

        $product->update($request->validated());
        $product->categories()->sync($request->categories);

        app(Pipeline::class)->send([
            'model' => $product,
            'request' => $request,
            'name' => 'product-images',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$product->id]);
        $this->setData('data', $product);
        $this->useCollection(ProductResource::class, 'data');

        return $this->response();
    }
}

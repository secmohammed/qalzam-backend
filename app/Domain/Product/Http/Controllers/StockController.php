<?php

namespace App\Domain\Product\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Product\Entities\Stock;
use App\Domain\Product\Http\Resources\Stock\StockResource;
use App\Domain\Product\Repositories\Contracts\StockRepository;
use App\Domain\Product\Http\Requests\Stock\StockStoreFormRequest;
use App\Domain\Product\Http\Requests\Stock\StockUpdateFormRequest;
use App\Domain\Product\Http\Resources\Stock\StockResourceCollection;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class StockController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'products';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'stocks';

    /**
     * @var StockRepository
     */
    protected $stockRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'stock';

    /**
     * @param StockRepository $stockRepository
     */
    public function __construct(StockRepository $stockRepository, ProductVariationRepository $productVariationRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.stock'), 'web');
        $this->setData('productVariations', $this->productVariationRepository->all());

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

        $delete = $this->stockRepository->destroy($ids)->count();

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
    public function edit(Stock $stock)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.stock') . ' : ' . $stock->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('productVariations', $this->productVariationRepository->all());
        $this->setData('edit', $stock);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(StockResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stocks = $this->stockRepository->spatie()->paginate(
            $request->per_page ?? config('semak.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.product'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $stocks);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(StockResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.stock') . ' : ' . $stock->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $stock);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(StockResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockStoreFormRequest $request)
    {
        $stock = $this->stockRepository->create($request->validated());

        $this->setData('data', $stock);

        $this->redirectRoute("{$this->resourceRoute}.show", [$stock->id]);
        $this->useCollection(StockResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockUpdateFormRequest $request, Stock $stock)
    {
        $stock->update($request->validated());

        $this->redirectRoute("{$this->resourceRoute}.show", [$stock->id]);
        $this->setData('data', $stock);
        $this->useCollection(StockResource::class, 'data');

        return $this->response();
    }
}

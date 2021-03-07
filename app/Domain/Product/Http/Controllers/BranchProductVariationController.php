<?php

namespace App\Domain\Product\Http\Controllers;

use Joovlly\DDD\Traits\Responder;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;

class BranchProductVariationController extends Controller
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
    protected $resourceRoute = 'productvariations';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'productvariation';

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch, ProductVariation $product)
    {
        if (!$product->branches->contains($branch)) {
            $this->setApiResponse(fn() => response()->json(['message' => 'product does not exist at this branch'], 422));

            return $this->response();
        }
        $this->setData('title', __('main.show') . ' ' . __('main.productvariation') . ' : ' . $product->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $product);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(ProductVariationResource::class, 'show');

        return $this->response();
    }
}

<?php

namespace App\Domain\Product\Http\Controllers;

use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Entities\Template;
use App\Domain\Product\Http\Requests\TemplateProduct\TemplateProductStoreFormRequest;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class TemplateProductController extends Controller
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
    protected $resourceRoute = 'templates';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'template.product';

    /**
     * @param ProductVariationRepository $productvariationRepository
     */
    public function create(Template $template, ProductVariation $products)
    {

        $this->setData('title', __('main.add') . ' ' . __('main.order'), 'web');

        $this->setData('template', $template, 'web');
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('products', $products, 'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    public function edit()
    {
        //TODO
    }

    /**
     * @param Template $template
     * @param Request $request
     */
    public function store(Template $template, TemplateProductStoreFormRequest $request)
    {

        $template->products()->sync(
            $request->validated()
        );
        return $template;
        // $this->setData('$', $template);
        // $this->r("{$this->resourceRoute}.show", [$template->id]);
        // $this->useCollection(TemplateResource::class, 'data');

        // return $this->response();

    }
}

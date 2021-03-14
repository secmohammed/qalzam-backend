<?php

namespace App\Domain\Product\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Product\Entities\Template;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Product\Http\Requests\TemplateProduct\TemplateProductStoreFormRequest;

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
     * @param $productVariationRepository
     */
    public function __construct(ProductVariationRepository $productVariationRepository)
    {
        $this->productVariationRepository = $productVariationRepository;
    }

    /**
     * @param ProductVariationRepository $productvariationRepository
     */
    public function create(Template $template)
    {

        $this->setData('title', __('main.add') . ' ' . __('main.order'), 'web');

        $this->setData('template', $template, 'web');
        $this->setData('auth_token', auth()->user()->generateAuthToken());
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('products', $this->productVariationRepository->all(), 'web');

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
    }
}

<?php

namespace App\Domain\Product\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Product\Entities\Template;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Http\Resources\Template\TemplateResource;
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
    protected $viewPath = 'template';

    /**
     * @param ProductVariationRepository $productvariationRepository
     */
    public function create()
    {
        //TODO
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
        $this->setData('data', $template);
        $this->redirectRoute("{$this->resourceRoute}.show", [$template->id]);
        $this->useCollection(TemplateResource::class, 'data');

        return $this->response();

    }
}

<?php

namespace App\Domain\Product\Http\Controllers;

use App\Domain\Product\Datatables\TemplateDataTable;
use App\Domain\Product\Entities\Template;
use App\Domain\Product\Http\Requests\Template\TemplateStoreFormRequest;
use App\Domain\Product\Http\Requests\Template\TemplateUpdateFormRequest;
use App\Domain\Product\Http\Resources\Template\TemplateResource;
use App\Domain\Product\Http\Resources\Template\TemplateResourceCollection;
use App\Domain\Product\Repositories\Contracts\TemplateRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class TemplateController extends Controller
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
    protected $resourceRoute = 'templates';

    /**
     * @var TemplateRepository
     */
    protected $templateRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'template';

    /**
     * @param TemplateRepository $templateRepository
     */
    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.template'), 'web');

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

        $delete = $this->templateRepository->destroy($ids)->count();

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
    public function edit(Template $template)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.template') . ' : ' . $template->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $template);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(TemplateResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->templateRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.template'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(TemplateResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param TemplateDataTable $dataTable
     * @return mixed
     */
    public function dataTable(TemplateDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        $template_products = $template->products->map(function ($product) {
            // dd($product->pivot->price);
            return array_merge($product->pivot->only("quantity", "price"), $product->product->only("name", "id"), ["image" => $product->getFirstMediaUrl("product-images")]);
        });

        $this->setData('title', __('main.show') . ' ' . __('main.template') . ' : ' . $template->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $template);
        $this->setData('template_products', $template_products);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(TemplateResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateStoreFormRequest $request)
    {
        $store = $this->templateRepository->create($request->validated());

        if ($store) {
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show", [$store->id]);
            $this->useCollection(TemplateResource::class, 'data');
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
    public function update(TemplateUpdateFormRequest $request, Template $template)
    {
        $template->update($request->validated());
        $this->redirectRoute("{$this->resourceRoute}.show", [$template->id]);
        $this->setData('data', $template);
        $this->useCollection(TemplateResource::class, 'data');

        return $this->response();
    }


    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->templateRepository->destroy($ids)->count();

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

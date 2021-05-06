<?php

namespace App\Domain\Ingredient\Http\Controllers;

use App\Domain\Ingredient\Datatables\IngredientDataTable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;
use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Ingredient\Entities\Ingredient;
use App\Domain\Ingredient\Repositories\Contracts\IngredientRepository;
use App\Domain\Ingredient\Http\Resources\Ingredient\IngredientResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Ingredient\Http\Requests\Ingredient\IngredientStoreFormRequest;
use App\Domain\Ingredient\Http\Requests\Ingredient\IngredientUpdateFormRequest;
use App\Domain\Ingredient\Http\Resources\Ingredient\IngredientResourceCollection;

class IngredientController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'ingredients';

    /**
     * @var IngredientRepository
     */
    protected $ingredientRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'ingredients';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'ingredient';

    /**
     * @param IngredientRepository $ingredientRepository
     */
    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.ingredient'), 'web');

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
        $delete = $this->ingredientRepository->destroy($ids)->count();
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
    public function edit(Ingredient $ingredient)
    {
        $ingredient->load('translations');
        $this->setData('title', __('main.edit') . ' ' . __('main.ingredient') . ' : ' . $ingredient->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $ingredient);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(IngredientResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->ingredientRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.ingredient'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(IngredientResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param IngredientDataTable $dataTable
     * @return mixed
     */
    public function dataTable(IngredientDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.ingredient') . ' : ' . $ingredient->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $ingredient);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(IngredientResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientStoreFormRequest $request)
    {
        $ingredient = $this->ingredientRepository->create($request->validated());

        $ingredient->setTranslation([
            'name' => $request->name_ar,
        ], 'ar');

        app(Pipeline::class)->send([
            'model' => $ingredient,
            'request' => $request,
            'name' => 'ingredient-icon',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $ingredient);

        $this->redirectRoute("{$this->resourceRoute}.show", [$ingredient->id]);
        $this->useCollection(IngredientResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IngredientUpdateFormRequest $request, Ingredient $ingredient)
    {
        $ingredient->update($request->validated());

        $ingredient->setTranslation([
            'name' => $request->name_ar,
        ], 'ar', true);

        app(Pipeline::class)->send([
            'model' => $ingredient,
            'request' => $request,
            'name' => 'ingredient-icon',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$ingredient->id]);
        $this->setData('data', $ingredient);
        $this->useCollection(IngredientResource::class, 'data');

        return $this->response();
    }
}

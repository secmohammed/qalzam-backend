<?php

namespace App\Domain\Ingredient\Http\Controllers;

use Joovlly\DDD\Traits\Responder;
use App\Domain\Ingredient\Entities\Ingredient;
use App\Domain\Product\Repositories\Contracts\ProductRepository;
use App\Domain\Ingredient\Repositories\Contracts\IngredientRepository;
use App\Domain\Ingredient\Http\Resources\Ingredient\IngredientResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Ingredient\Http\Requests\IngredientProduct\IngredientProductStoreFormRequest;

class IngredientProductController extends Controller
{
    use Responder;

    /**
     * @var string
     */
    protected $domainAlias = 'ingredients';

    /**
     * @var string
     */
    protected $resourceRoute = 'ingredients';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'ingredient_product';

    /**
     * @var mixed
     */
    private $productRepository;

    /**
     * @param IngredientRepository $ingredientRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function create(Ingredient $ingredient)
    {

        $this->setData('title', __('main.add') . ' ' . __('main.ingredient_product'), 'web');
        $this->setData('ingredient', $ingredient);
        $this->setData('products', $this->productRepository->all());

        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        return $this->response();

    }

    /**
     * @param Meeting $meeting
     * @param MeetingProductStoreFormRequest $request
     */
    public function store(Ingredient $ingredient, IngredientProductStoreFormRequest $request)
    {
        $ingredient->products()->sync($request->products);
        $this->setData('data', $ingredient);
        $this->redirectRoute("{$this->resourceRoute}.show", [$ingredient->id]);
        $this->useCollection(IngredientResource::class, 'data');

        return $this->response();
    }
}

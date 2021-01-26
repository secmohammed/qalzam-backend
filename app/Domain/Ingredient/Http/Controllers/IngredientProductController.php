<?php

namespace App\Domain\Ingredient\Http\Controllers;

use Joovlly\DDD\Traits\Responder;
use App\Domain\Ingredient\Entities\Ingredient;
use App\Domain\Ingredient\Http\Resources\Ingredient\IngredientResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Ingredient\Http\Requests\IngredientProduct\IngredientProductStoreFormRequest;

class IngredientProductController extends Controller
{
    use Responder;

    /**
     * @var string
     */
    protected $resourceRoute = 'ingredients';

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

<?php

namespace App\Domain\User\Http\Controllers;

use App\Common\Cart\Cart;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Http\Requests\Cart\CartStoreFormRequest;
use App\Domain\User\Http\Requests\Cart\CartUpdateFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class CartController extends Controller
{
    use Responder;

    /**
     * @var AddressRepository
     */
    protected $cart;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'users';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'carts';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'cart';

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Cart $cart)
    {
        $ids = request()->get('ids', [$id]);
        $delete = $cart->delete($ids);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Cart $cart)
    {
        $cart->sync();
        $request->user()->load(['cart.product', 'cart.product.variations.stock', 'cart.stock', 'cart.type', 'reservations']);
        $this->setData('title', __('main.show-all') . ' ' . __('main.address'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $request->user());

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(UserResource::class, 'data');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreFormRequest $request, Cart $cart)
    {
        $store = $cart->add($request->validated());
        if (count($store['attached']) || count($store['updated'])) {
            $this->setApiResponse(fn() => response()->json(['message' => 'added to cart successfully']));
            $this->redirectBack();
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
    public function update(CartUpdateFormRequest $request, ProductVariation $productVariation, Cart $cart)
    {
        $cart->update($productVariation->id, $request->quantity);
        // $this->redirectRoute("{$this->resourceRoute}.show", [$update->id]);
        $this->setData('data', $request->user());
        $this->useCollection(UserResource::class, 'data');

        return $this->response();
    }
}

<?php

namespace App\Domain\User\Http\Controllers;

use App\Common\Cart\Cart;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Branch\Http\Resources\Branch\BranchResourceCollection;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\User\Http\Requests\Cart\CartStoreFormRequest;
use App\Domain\User\Http\Requests\Cart\CartUpdateFormRequest;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

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
    public function destroy(Branch $branch, Cart $cart, $id)
    {
        $ids = request()->get('ids', [$id]);
        $delete = $cart->setCartType('cart')->withBranch($branch)->delete($ids);
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
    public function index(Request $request, Cart $cart, Branch $branch)
    {
        $cart->setCartType('cart')->withBranch($branch)->sync();
        $request->user()->load(['cart' => function ($query) use ($branch) {
            $query->where('branch_id', $branch->id);
        }, 'cart.product', 'cart.product.variations.stock', 'cart.stock', 'cart.type']);
        $this->setData('title', __('main.show-all') . ' ' . __('main.address'));
        // dd($request->user());

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $request->user());

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");
        $this->useCollection(UserResource::class, 'data');

        return $this->response();
    }
    public function AllCart(Request $request, Cart $cart)
    {
        // dd(2);
        $branchesId = $request->user()->cart->map(function ($product) {
            return $product->pivot->branch_id;

        });
        $branches = Branch::whereIn('id', $branchesId)->get();
        // $cart->setCartType('cart')->sync();

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $branches);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(BranchResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreFormRequest $request, Cart $cart, Branch $branch)
    {
        // dd($request->validated());
        $store = $cart->setCartType('cart')->withBranch($branch)->add($request->validated());
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
    public function update(Branch $branch, ProductVariation $productVariation, CartUpdateFormRequest $request, Cart $cart)
    {
        if (!$cart->setCartType('cart')->withBranch($branch)->update($productVariation->id, $request->quantity)) {
            $this->setApiResponse(fn() => response()->json(['message' => 'Cart Could not be updated.'], 422));
        }
        
        // $this->redirectRoute("{$this->resourceRoute}.show", [$update->id]);
        $this->setData('data', $request->user());
        $this->useCollection(UserResource::class, 'data');

        return $this->response();
    }
}

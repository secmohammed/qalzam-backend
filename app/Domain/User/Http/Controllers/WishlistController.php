<?php

namespace App\Domain\User\Http\Controllers;

use App\Common\Cart\Cart;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Branch\Entities\Branch;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Http\Requests\Cart\CartStoreFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class WishlistController extends Controller
{
    use Responder;

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
    protected $viewPath = 'wishlist';

    /**
     * @var AddressRepository
     */
    protected $wishlist;

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch, Cart $wishlist, $id)
    {
        $ids = request()->get('ids', [$id]);
        $delete = $wishlist->setCartType('wishlist')->withBranch($branch)->delete($ids);
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
    public function index(Request $request, Cart $wishlist, Branch $branch)
    {
        $request->user()->load(['wishlist.product', 'wishlist.product.variations.stock', 'wishlist.stock', 'wishlist.type']);
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
    public function store(CartStoreFormRequest $request, Cart $wishlist, Branch $branch)
    {
        $store = $wishlist->setCartType('wishlist')->withBranch($branch)->add($request->validated());
        if (count($store['attached']) || count($store['updated'])) {
            $this->setApiResponse(fn() => response()->json(['message' => 'added to wishlist successfully']));
            $this->redirectBack();
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['created' => false]));
        }

        return $this->response();
    }
}

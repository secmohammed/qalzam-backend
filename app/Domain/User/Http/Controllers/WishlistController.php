<?php

namespace App\Domain\User\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Http\Requests\Wishlist\WishlistStoreFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class WishlistController extends Controller
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
    public function destroy($id)
    {
        $ids = request()->get('ids', $id);
        $ids = explode(',', $ids);
        auth()->user()->wishlist()->detach($ids);

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
    public function index(Request $request)
    {

        $request->user()->load(['wishlist', 'wishlist.product', 'wishlist.product.variations', 'wishlist.type']);

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
    public function store(WishlistStoreFormRequest $request)
    {
        $store = auth()->user()->wishlist()->syncWithoutDetaching($request->products);
        if (count($store['attached'])) {
            $this->setApiResponse(fn() => response()->json(['message' => 'added to cart successfully']));
            $this->redirectRoute("{$this->resourceRoute}.show", [$request->products]);
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['created' => false]));
        }

        return $this->response();
    }
}

<?php

namespace App\Domain\Discount\Http\Controllers;

use App\Common\Cart\Cart;
use App\Domain\Branch\Entities\Branch;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Discount\Http\Resources\Discount\DiscountResource;
use App\Domain\Discount\Repositories\Contracts\DiscountRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Discount\Http\Requests\DiscountUser\DiscountUserStoreFormRequest;
use App\Domain\User\Http\Resources\User\UserResource;

class DiscountUserController extends Controller
{
    use Responder;

    /**
     * @var DiscountRepository
     */
    protected $discountRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'discounts';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'discounts';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'discount';

    /**
     * @param DiscountRepository $discountRepository
     */
    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountUserStoreFormRequest $request)
    {
        $discount = $this->discountRepository->where($request->validated())->firstOrFail();
        try {
            $discount->attachToUser(auth()->user());
            $this->setData('data', $discount);
            $this->redirectRoute("{$this->resourceRoute}.show", [$discount->id]);
            $this->useCollection(DiscountResource::class, 'data');
        } catch (Exception $e) {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['created' => false, 'message' => $e->getMessage()], 422));
        }

        return $this->response();
    }
    public function validateCoupon(Request $request,Branch $branch, Cart $cart)
    {
        $discount = auth()->user()->discounts()->where('code', $request->code)->first();
        // dd($discount);
        if(!$discount)
        {
            $this->setApiResponse(fn() => response()->json(['valid' => false, 'message' =>'invalid Coupon'], 400));
            return $this->response();
    
        }
        if($discount->validate()) {
            $cart->setCartType('cart')->withBranch($branch)->withDiscount($discount);
            // dd();
            // dd($cart);
// dd($cart->hasBranch(),$cart->branch,$cart->getType());

            $this->setApiResponse(fn() => response()->json(['valid' => true, 'message' =>'Valid Coupon','discount'=>$discount , new UserResource(auth()->user())], 200));

            return $this->response();
        }
        $this->setApiResponse(fn() => response()->json(['valid' => false, 'message' =>'invalid'], 400));
        return $this->response();

    }
}

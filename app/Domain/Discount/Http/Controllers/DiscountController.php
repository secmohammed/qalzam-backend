<?php

namespace App\Domain\Discount\Http\Controllers;

use App\Domain\Category\Entities\Category;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use App\Domain\Discount\Datatables\DiscountDataTable;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Discount\Http\Requests\Discount\DiscountStoreFormRequest;
use App\Domain\Discount\Http\Requests\Discount\DiscountUpdateFormRequest;
use App\Domain\Discount\Http\Resources\Discount\DiscountResource;
use App\Domain\Discount\Http\Resources\Discount\DiscountResourceCollection;
use App\Domain\Discount\Notifications\DiscountAttachedToUser;
use App\Domain\Discount\Repositories\Contracts\DiscountRepository;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class DiscountController extends Controller
{
    use Responder;

    /**
     * @var DiscountRepository
     */
    protected $discountRepository, $userRepository;

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
    public function __construct(DiscountRepository $discountRepository, UserRepository $userRepository, Category $categoryRepository)
    {
        $this->discountRepository = $discountRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.discount'), 'web');
        $this->setData('categories', $this->categoryRepository->where('type', 'product')->get());
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('users', $this->userRepository->whereHas('roles', function ($query) {
            $query->where('slug', 'user');
        })->get());
        $this->setData('auth_token', auth()->user()->generateAuthToken());

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids', $id);

        $delete = $this->discountRepository->destroy($ids);

        if ($delete->count()) {
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
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.discount') . ' : ' . $discount->id, 'web');
        $this->setData('categories', $this->categoryRepository->where('type', 'products')->get());
        $this->setData('auth_token', auth()->user()->generateAuthToken());

        $this->setData('alias', $this->domainAlias, 'web');
        $discount->load('users');
        $this->setData('edit', $discount);
        $this->setData('discountable', $discount->discountable);
        $this->setData('users', $this->userRepository->whereHas('roles', function ($query) {
            $query->where('slug', '!=', 'admin');
        })->get());
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(DiscountResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->discountRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.discount'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(DiscountResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param DiscountDataTable $dataTable
     * @return mixed
     */
    public function dataTable(DiscountDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }

    /**
     * Display the specified resource.
     *
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        $discount->remaining_purchases = $discount->number_of_usage - $discount->users()->count();
        $this->setData('title', __('main.show') . ' ' . __('main.discount') . ' : ' . $discount->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $discount);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(DiscountResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountStoreFormRequest $request)
    {
        $discount = $this->discountRepository->make($request->validated());
        $discount->owner()->associate(auth()->user());
        $discount->save();
        $discount->users()->attach($request->validated()['users']);
        $this->userRepository->find($request->validated()['users'])->each(function ($user) use ($discount) {
            $user->notify(new DiscountAttachedToUser($discount));
        });
        $this->setData('data', $discount);
        $this->redirectRoute("{$this->resourceRoute}.show", [$discount->id]);
        $this->useCollection(DiscountResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountUpdateFormRequest $request, Discount $discount)
    {
        // dd();
        $discount->update($request->validated());
        $discount->users()->sync($request->validated()['users']);
        $this->redirectRoute("{$this->resourceRoute}.show", [$discount->id]);
        $this->setData('data', $discount);
        $this->useCollection(DiscountResource::class, 'data');

        return $this->response();
    }
    public function checkDiscount(Request $request, Discount $discount)
    {
        $discount = $discount->where([["code", $request->code], ['status', "active"]])->first();
        if ($discount) {
            if (auth()->user()->discounts()->where("id", $discount->id)->exists()) {

                $this->setApiResponse(fn() => response()->json(["data" => $discount, 'isAvailable' => true, 'message' => 'added to cart successfully']));
                $this->redirectBack();
            }
        }
        // dd(1);
        $this->setApiResponse(fn() => response()->json(['message' => "discount not available"]));
        $this->redirectBack();
        return $this->response();
    }

}

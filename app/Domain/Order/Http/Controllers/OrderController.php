<?php

namespace App\Domain\Order\Http\Controllers;

use App\Common\Facades\Branch;
use App\Common\Facades\Cart;
use App\Common\Transformers\Money;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Discount\Repositories\Contracts\DiscountRepository;
use App\Domain\Location\Repositories\Contracts\LocationRepository;
use App\Domain\Order\Datatables\OrderDataTable;
use App\Domain\Order\Entities\Order;
use App\Domain\Order\Http\Events\GenerateOrderPdfInvoice;
use App\Domain\Order\Http\Events\OrderDestroyed;
use App\Domain\Order\Http\Requests\Order\OrderStoreFormRequest;
use App\Domain\Order\Http\Requests\Order\OrderUpdateFormRequest;
use App\Domain\Order\Http\Requests\Order\UpdateStatusFormRequest;
use App\Domain\Order\Http\Resources\Order\OrderResource;
use App\Domain\Order\Http\Resources\Order\OrderResourceCollection;
use App\Domain\Order\Pipelines\ApplyDiscountToOrderIfPresent;
use App\Domain\Order\Pipelines\CreateOrderPipeline;
use App\Domain\Order\Pipelines\NotifyUserWithOrderStatus;
use App\Domain\Order\Pipelines\NotifyUserWithPlacedOrder;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Domain\User\Entities\Address;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\Contracts\RoleRepository;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Joovlly\DDD\Traits\Responder;
use PDF;

class OrderController extends Controller
{
    use Responder;

    /**
     * @var mixed
     */
    protected $addressRepository;

    /**
     * @var mixed
     */
    protected $branchRepository;

    /**
     * @var mixed
     */
    protected $discountRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'orders';

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'orders';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'order';

    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository, RoleRepository $roleRepository, LocationRepository $locationRepository, BranchRepository $branchRepository, UserRepository $userRepository, DiscountRepository $discountRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->branchRepository = $branchRepository;
        $this->userRepository = $userRepository;
        $this->discountRepository = $discountRepository;
        $this->roleRepository = $roleRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductVariationRepository $productVariation)
    {
        // dd($locationRepository->all());

        $this->setData('title', __('main.add') . ' ' . __('main.order'), 'web');
        // dd($this->branchRepository->with(['products'])->first()->products[0]->name);
//         DB::connection()->enableQueryLog();
//         $this->branchRepository->with(['products','products.translations'])->first();
// //   $product =$productVariation->first();
//   $queries = DB::getQueryLog();
//   return dd($queries);
//   dd($product ,  $this->branchRepository->first());
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('auth_token', auth()->user()->generateAuthToken());
        $this->setData('roles', $this->roleRepository->all());
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
        $ids = explode(',', request()->get('ids', $id));
        $orders = $this->orderRepository->whereIn('id', $ids)->with('products')->get();
        $deletedOrders = $this->orderRepository->whereIn('id', $ids)->delete();
        if ($deletedOrders && $orders->count()) {
            event(new OrderDestroyed($orders));

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
    public function edit(Order $order)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.order') . ' : ' . $order->id, 'web');
        $user = $this->userRepository->find($order->user_id);
        $address = Address::find($order->address_id);
        $order->user = $user;
        $order->address = $address;
        // $order->append'user' => $user, 'address' => $address]);
        // dd($order);
        // dd($order->load("products"));
        $this->setData('roles', $this->roleRepository->all());

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('edit', $order->load("products"));
        $this->setData('auth_token', auth()->user()->generateAuthToken());

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(OrderResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->orderRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.order'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(OrderResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param OrderDataTable $dataTable
     * @return mixed
     */
    public function dataTable(OrderDataTable $dataTable)
    {
        // dd(Order::find(5)->deliverer);
        $deliverers = User::where('type','delivery')->get();
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index",['deliverers'=>$deliverers]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // dd($order->branch);
        $this->setData('title', __('main.show') . ' ' . __('main.order') . ' : ' . $order->id, 'web');
        session(['current_branch' => $order->branch->id]);
        $statuses =['pending', 'processing', 'picked', 'delivered'];
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('auth_token', auth()->user()->generateAuthToken());

        $this->setData('show', $order);
        $this->setData('statuses', $statuses);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(OrderResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreFormRequest $request)
    {
//        return $request->products;
        $order = app(Pipeline::class)->send($request)->through([
            ApplyDiscountToOrderIfPresent::class,
            CreateOrderPipeline::class,
            NotifyUserWithPlacedOrder::class,
        ])->then(fn($order) => $order);
        //todo fix next line error
        GenerateOrderPdfInvoice::dispatch($order);
        Cart::clear();
        Cart::clearCoupon();
        Branch::clear(); // todo replace these with event
        $this->setData('data', $order);

        $this->redirectRoute("{$this->resourceRoute}.show", [$order->id]);
        $this->useCollection(OrderResource::class, 'data');
//        session()->flash('message', 'order Created!');
        toastr()->success('Order Created!', 'Order');
        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateFormRequest $request, Order $order)
    {
        app(Pipeline::class)->send($request)->through([
            CreateOrderPipeline::class,
            NotifyUserWithOrderStatus::class,

        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$order->id]);
        $this->setData('data', $order);
        $this->useCollection(OrderResource::class, 'data');

        return $this->response();
    }
    public function generatePdf(Order $order)
    {
        // dd($order->user->addresses()->activeAddress()->first());
        $locations = $order->user->addresses()->activeAddress()->first()->location->prevNodes()->get();
        $data = ["order" => $order->load(["products", "user"]), "locations" => $locations];
        $pdf = PDF::loadView('orders::order.invoice', $data);
        $pdf->download($order->id . '.pdf');
        return redirect()->back();

    }
    public function updateStatus(UpdateStatusFormRequest $request, Order $order)
    {
         $order->update($request->validated());
        if($order)
        {

          return  response()->json(['message'=>'updated successfully']);
        }
        return  response()->json(['message'=>"can't update status "],400);


    }
    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->orderRepository->destroy($ids)->count();

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

<?php

namespace App\Domain\Order\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Order\Entities\Order;
use App\Domain\Order\Http\Events\OrderDestroyed;
use App\Domain\Order\Pipelines\CreateOrderPipeline;
use App\Domain\Order\Http\Resources\Order\OrderResource;
use App\Domain\Order\Pipelines\NotifyUserWithOrderStatus;
use App\Domain\Order\Pipelines\NotifyUserWithPlacedOrder;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Order\Pipelines\ApplyDiscountToOrderIfPresent;
use App\Domain\Order\Http\Requests\Order\OrderStoreFormRequest;
use App\Domain\Order\Http\Requests\Order\OrderUpdateFormRequest;
use App\Domain\Order\Http\Resources\Order\OrderResourceCollection;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class OrderController extends Controller
{
    use Responder;

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
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.order'), 'web');

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

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $order);

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
            $request->per_page ?? config('semak.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.order'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(OrderResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.order') . ' : ' . $order->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $order);

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
        $order = app(Pipeline::class)->send($request)->through([
            ApplyDiscountToOrderIfPresent::class,
            CreateOrderPipeline::class,
            NotifyUserWithPlacedOrder::class,
        ])->then(fn($rqeuest) => $request->order);
        $this->setData('data', $order);

        $this->redirectRoute("{$this->resourceRoute}.show", [$order->id]);
        $this->useCollection(OrderResource::class, 'data');

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
        app(Pipeline::class)->send($order)->through([
            NotifyUserWithOrderStatus::class,
        ])->thenReturn();
        $order->update($request->validated());

        $this->redirectRoute("{$this->resourceRoute}.show", [$order->id]);
        $this->setData('data', $order);
        $this->useCollection(OrderResource::class, 'data');

        return $this->response();
    }
}

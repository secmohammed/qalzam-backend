<?php

namespace App\Domain\Order\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Order\Entities\Deliveryorder;
use App\Domain\Order\Http\Resources\Order\OrderResource;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Order\Repositories\Contracts\DeliveryorderRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Order\Http\Requests\Deliveryorder\DeliveryorderStoreFormRequest;
use App\Domain\Order\Http\Requests\Deliveryorder\DeliveryorderUpdateFormRequest;

class DeliveryOrderController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'orders';

    /**
     * @var DeliveryorderRepository
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
        $ids = request()->get('ids', [$id]);

        $delete = $this->orderRepository->destroy($ids);

        if ($delete) {
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 422));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Branch $branch, DeliveryorderStoreFormRequest $request)
    {
        $store = $this->orderRepository->create($request->validated());

        if ($store) {
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show", [$store->id]);
            $this->useCollection(OrderResource::class, 'data');
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
    public function update(DeliveryorderUpdateFormRequest $request, Order $order, Branch $branch)
    {
        $update = $this->orderRepository->update($request->validated(), $order);

        if ($update) {
            $this->redirectRoute("{$this->resourceRoute}.show", [$update->id]);
            $this->setData('data', $update);
            $this->useCollection(OrderResource::class, 'data');
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 422));
        }

        return $this->response();
    }
}

<?php

namespace App\Domain\Payment\Http\Controllers;

use App\Domain\Order\Entities\Order;
use App\Domain\Order\Http\Controllers\OrderController;
use App\Domain\Order\Http\Requests\Order\OrderStoreFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Payment\Http\Requests\Payment\PaymentStoreFormRequest;
use App\Domain\Payment\Http\Requests\Payment\PaymentUpdateFormRequest;
use App\Domain\Payment\Repositories\Contracts\PaymentRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Payment\Entities\Payment;
use App\Domain\Payment\Http\Resources\Payment\PaymentResourceCollection;
use App\Domain\Payment\Http\Resources\Payment\PaymentResource;
use Illuminate\Support\Facades\Request as FacadesRequest;
use LaravelPayfort\Facades\Payfort;

class PaymentController extends Controller
{
    use Responder;
    
    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'payment';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'payments';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'payments';


    /**
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->paymentRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.payment'));

        $this->setData('alias', $this->domainAlias);
        
        $this->setData('data', $index);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(PaymentResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.payment'), 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn()=> response()->json(['create_your_own_form'=>true]));

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
        // $order = app(OrderController::class)->store($request);
        // dd($order);
       $order =  Order::find(13);
       return Payfort::redirection()->displayRedirectionPage([
        'command' => 'AUTHORIZATION',              # AUTHORIZATION/PURCHASE according to your operation.
        'merchant_reference' => $order->id,   # You reference id for this operation (Order id for example).
        'amount' => $order->subtotal->amount(),                           # The operation amount.
        'currency' => 'SAR',                       # Optional if you need to use another currenct than set in config.
        'customer_email' => auth()->user()->email  # Customer email.
    ]); 

        $store = $this->paymentRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);
            
            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(PaymentResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.payment') . ' : ' . $payment->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('show', $payment);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(PaymentResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.payment') . ' : ' . $payment->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('edit', $payment);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(PaymentResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentUpdateFormRequest $request, $payment)
    {
        $update = $this->paymentRepository->update($request->validated(), $payment);
        
        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(PaymentResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

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
        $ids = request()->get('ids',[$id]);

        $delete = $this->paymentRepository->destroy($ids);

        if($delete){
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn()=>response()->json(['deleted'=>true],200));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }

}

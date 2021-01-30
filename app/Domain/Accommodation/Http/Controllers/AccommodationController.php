<?php

namespace App\Domain\Accommodation\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Accommodation\Http\Requests\Accommodation\AccommodationStoreFormRequest;
use App\Domain\Accommodation\Http\Requests\Accommodation\AccommodationUpdateFormRequest;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Accommodation\Http\Resources\Accommodation\AccommodationResourceCollection;
use App\Domain\Accommodation\Http\Resources\Accommodation\AccommodationResource;

class AccommodationController extends Controller
{
    use Responder;
    
    /**
     * @var AccommodationRepository
     */
    protected $accommodationRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'accommodation';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'accommodations';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'accommodations';


    /**
     * @param AccommodationRepository $accommodationRepository
     */
    public function __construct(AccommodationRepository $accommodationRepository)
    {
        $this->accommodationRepository = $accommodationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->accommodationRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.accommodation'));

        $this->setData('alias', $this->domainAlias);
        
        $this->setData('data', $index);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(AccommodationResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.accommodation'), 'web');

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
    public function store(AccommodationStoreFormRequest $request)
    {
        $store = $this->accommodationRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);
            
            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(AccommodationResource::class, 'data');
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
    public function show(Accommodation $accommodation)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.accommodation') . ' : ' . $accommodation->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('show', $accommodation);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(AccommodationResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Accommodation $accommodation)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.accommodation') . ' : ' . $accommodation->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('edit', $accommodation);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(AccommodationResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccommodationUpdateFormRequest $request, $accommodation)
    {
        $update = $this->accommodationRepository->update($request->validated(), $accommodation);
        
        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(AccommodationResource::class, 'data');
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

        $delete = $this->accommodationRepository->destroy($ids);

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

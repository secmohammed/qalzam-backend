<?php

namespace App\Domain\User\Http\Controllers;

use App\Domain\User\Datatables\AddressDataTable;
use App\Domain\User\Entities\Address;
use App\Domain\User\Http\Requests\Address\AddressFastStoreFormRequest;
use App\Domain\User\Http\Requests\Address\AddressStoreFormRequest;
use App\Domain\User\Http\Requests\Address\AddressUpdateFormRequest;
use App\Domain\User\Http\Resources\Address\AddressResource;
use App\Domain\User\Http\Resources\Address\AddressResourceCollection;
use App\Domain\User\Repositories\Contracts\AddressRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class AddressController extends Controller
{
    use Responder;

    /**
     * @var AddressRepository
     */
    protected $addressRepository;

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
    protected $resourceRoute = 'addresses';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'address';

    /**
     * @param AddressRepository $addressRepository
     */
    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.address'), 'web');

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
    public function destroy(Address $address)
    {
        $delete = auth()->user()->addresses()->where('id', $address->id)->delete();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.address') . ' : ' . $address->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $address);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(AddressResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = $this->addressRepository->spatie()->where('user_id', $request->user()->id)->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );
        $this->setData('title', __('main.show-all') . ' ' . __('main.address'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $addresses);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(AddressResourceCollection::class, 'data');

        return $this->response();
    }


    /**
     * @param AddressDataTable $dataTable
     * @return mixed
     */
    public function datTable(AddressDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }
    public function userAddresses(Request $request)
    {

        $addresses = auth()->user()->addresses->map(function ($address) {
            return $address->getFullNameAddress();
        });
        // dd($addresses);
        $this->setApiResponse(fn() => response()->json(["data" => $addresses]));

        return $this->response();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.address') . ' : ' . $address->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $address);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(AddressResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressStoreFormRequest $request)
    {
        // dd($request->user());
        $address = $request->user()->addresses()->save(
            $this->addressRepository->make(
                $request->validated()
            )
        );
        $this->setData('data', $address);

        $this->redirectRoute("{$this->resourceRoute}.show", [$address->id]);
        $this->useCollection(AddressResource::class, 'data');

        return $this->response();
    }
    public function storeFastAddress(AddressFastStoreFormRequest $request)
    {
        // dd($request->user());
        $address = $request->user()->addresses()->save(
            $this->addressRepository->make(
                $request->validated()
            )
        );
        $this->setData('data', $address);

        $this->redirectRoute("{$this->resourceRoute}.show", [$address->id]);
        $this->useCollection(AddressResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressUpdateFormRequest $request, Address $address)
    {
        $address->update($request->validated());
        // Update old addresses to usnet default from them, as we have the current is default.
        if ($address->default) {
            $address->user->addresses()->update([
                'default' => false,
            ]);

        }
        $this->redirectRoute("{$this->resourceRoute}.show", [$address->id]);
        $this->setData('data', $address->fresh());
        $this->useCollection(AddressResource::class, 'data');

        return $this->response();
    }
}

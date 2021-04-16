<?php

namespace App\Domain\Branch\Http\Controllers;

use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Branch\Http\Requests\Branch\BranchStoreFormRequest;
use App\Domain\Branch\Http\Requests\Branch\BranchUpdateFormRequest;
use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use App\Domain\Branch\Http\Resources\Branch\BranchResourceCollection;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Location\Repositories\Contracts\LocationRepository;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;

class BranchController extends Controller
{
    use Responder;

    /**
     * @var BranchRepository
     */
    protected $branchRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'branches';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'branches';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'branch';

    /**
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(UserRepository $userRepository, LocationRepository $locationRepository)
    {
        // dd($this->)
        $this->setData('title', __('main.add') . ' ' . __('main.branch'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('users', $userRepository->whereHas('roles', function ($query) {
            $query->whereNotIn('slug', ['user', 'admin', 'delivery']);
        })->all());
        $this->setData('deliverers', $userRepository->whereHas('roles', function ($query) {
            $query->where('slug', 'delivery');
        })->all());
        $this->setData('branch_managers', $userRepository->whereHas('roles', function ($query) {
            $query->where('slug', 'branch-manager');
        })->all());
        $this->setData('locations', $locationRepository->all());
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
        $ids = request()->get('ids', $id);

        $delete = $this->branchRepository->destroy($ids)->count();
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
    public function edit(Branch $branch, UserRepository $userRepository, LocationRepository $locationRepository)
    {

        $this->setData('title', __('main.edit') . ' ' . __('main.branch') . ' : ' . $branch->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('users', $userRepository->whereHas('roles', function ($query) {
            $query->whereNotIn('slug', ['user', 'admin', 'delivery']);
        })->all());
        $this->setData('deliverers', $userRepository->whereHas('roles', function ($query) {
            $query->where('slug', 'delivery');
        })->all());
        $this->setData('branch_managers', $userRepository->whereHas('roles', function ($query) {
            $query->where('slug', 'branch-manager');
        })->all());
        $this->setData('selected_users', $branch->employees);

        $this->setData('locations', $locationRepository->all());

        $this->setData('edit', $branch);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(BranchResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->branchRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.branch'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index->load("accommodations"));

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(BranchResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.branch') . ' : ' . $branch->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('branch', $branch);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(BranchResource::class, 'branch');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchStoreFormRequest $request)
    {
        $validatedRequest = $request->validated();
        // dd($validatedRequest);
        // dd(array_merge($request->get('users'), $request->get('deliverers', [])), $request->get('users'), $request->get('deliverers', []));
        $branch = $this->branchRepository->create($validatedRequest);
        $branch->employees()->attach($validatedRequest['users']);
        app(Pipeline::class)->send([
            'model' => $branch,
            'request' => $request,
            'name' => 'branch-gallery',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $branch);

        $this->redirectRoute("{$this->resourceRoute}.show", [$branch->id]);
        $this->useCollection(BranchResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchUpdateFormRequest $request, Branch $branch)
    {

        $validatedRequest = $request->validated();
        $branch->update($validatedRequest);
        if ($request->has('users')) {
            $branch->employees()->sync($validatedRequest["users"]);
        }

        app(Pipeline::class)->send([
            'model' => $branch,
            'request' => $request,
            'name' => 'branch-gallery',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$branch->id]);
        $this->setData('data', $branch);
        $this->useCollection(BranchResource::class, 'data');

        return $this->response();
    }
}

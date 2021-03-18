<?php

namespace App\Domain\User\Http\Controllers;

use App\Common\Pipeline\HandleFileUpload;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\User\Http\Requests\User\UserStoreFormRequest;
use App\Domain\User\Http\Requests\User\UserUpdateFormRequest;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Http\Resources\User\UserResourceCollection;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;

class UserController extends Controller
{
    use Responder;

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
    protected $resourceRoute = 'users';

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'user';

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $this->setData('roles', $roles);

        $this->setData('title', __('main.add') . ' ' . __('main.user'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids', $id);

        $delete = $this->userRepository->destroy($ids)->count();

        if ($delete) {
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 404));
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $this->setData('roles', $roles);

        $this->setData('title', __('main.edit') . ' ' . __('main.user') . ' : ' . $user->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $user->load('translations');
        $this->setData('edit', $user);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(UserResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->userRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.users'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(UserResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.user') . ' : ' . $user->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $user);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(UserResource::class, 'show');

        return $this->response();
    }

    public function statistics()
    {
        $this->setData('title', __('main.statistics'), 'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.statistics");

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreFormRequest $request)
    {
        // dd($request);

        $store = $this->userRepository->create($request->validated());
        $store->roles()->attach($request->role_id);
        if ($request->expectsJson()) {
            $this->setData('meta', [
                'token' => $store->generateAuthToken(),
            ]);
        }

        app(Pipeline::class)->send([
            'model' => $store,
            'request' => $request,
            'name' => 'image',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $store->setTranslation([
            'name' => $request->name_ar,
        ], 'ar');

        if ($store) {
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show", [$store->id]);
            $this->useCollection(UserResource::class, 'data');
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['created' => false]));
        }

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateFormRequest $request, User $user)
    {
        $user->update($request->validated());
        if ($request->role_id) {
            $user->roles()->sync($request->role_id);
        }
        app(Pipeline::class)->send([
            'model' => $user,
            'request' => $request,
            'name' => 'image',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $user->setTranslation([
            'name' => $request->name_ar,
        ], 'ar', true);

        $this->redirectRoute("{$this->resourceRoute}.show", [$user->id]);
        $this->setData('data', $user);
        $this->useCollection(UserResource::class, 'data');

        return $this->response();
    }
}

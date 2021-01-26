<?php

namespace App\Domain\Child\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Child\Entities\Child;
use App\Common\Pipeline\HandleFileUpload;
use App\Domain\Child\Http\Resources\Child\ChildResource;
use App\Domain\Child\Repositories\Contracts\ChildRepository;
use App\Domain\Child\Http\Requests\Child\ChildStoreFormRequest;
use App\Domain\Child\Http\Requests\Child\ChildUpdateFormRequest;
use App\Domain\Child\Http\Resources\Child\ChildResourceCollection;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class ChildController extends Controller
{
    use Responder;

    /**
     * @var ChildRepository
     */
    protected $childRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'childrens';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'children';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'child';

    /**
     * @param ChildRepository $childRepository
     */
    public function __construct(ChildRepository $childRepository)
    {
        $this->childRepository = $childRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.child'), 'web');

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
        $ids = request()->get('ids', $id);

        $delete = $this->childRepository->destroy($ids)->count();
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
    public function edit(Child $child)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.child') . ' : ' . $child->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $child->load('translations');
        $this->setData('edit', $child);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ChildResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->childRepository->spatie()->paginate(
            $request->per_page ?? config('semak.pagination')
        );

        $this->setData('title', __('main.show-all') . ' ' . __('main.child'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ChildResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Child $child)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.child') . ' : ' . $child->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $child);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(ChildResource::class, 'show');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChildStoreFormRequest $request)
    {
        $child = $this->childRepository->create($request->validated());
        app(Pipeline::class)->send([
            'model' => $child,
            'request' => $request,
            'name' => 'child-avatar',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();
        app(Pipeline::class)->send([
            'model' => $child,
            'request' => $request,
            'name' => 'child-birthdate-certificate',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->setData('data', $child);

        $this->redirectRoute("{$this->resourceRoute}.show", [$child->id]);
        $this->useCollection(ChildResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChildUpdateFormRequest $request, Child $child)
    {
        $child->update($request->validated());
        app(Pipeline::class)->send([
            'model' => $child,
            'request' => $request,
            'name' => 'child-avatar',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();
        app(Pipeline::class)->send([
            'model' => $child,
            'request' => $request,
            'name' => 'child-birthdate-certificate',
        ])->through([
            HandleFileUpload::class,
        ])->thenReturn();

        $this->redirectRoute("{$this->resourceRoute}.show", [$child->id]);
        $this->setData('data', $child);
        $this->useCollection(ChildResource::class, 'data');

        return $this->response();
    }
}

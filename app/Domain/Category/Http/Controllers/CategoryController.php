<?php

namespace App\Domain\Category\Http\Controllers;

use App\Domain\Category\Datatables\CategoryDataTable;
use App\Domain\Category\Entities\Category;
use App\Domain\Category\Http\Requests\Category\CategoryStoreFormRequest;
use App\Domain\Category\Http\Requests\Category\CategoryUpdateFormRequest;
use App\Domain\Category\Http\Resources\Category\CategoryResource;
use App\Domain\Category\Http\Resources\Category\CategoryResourceCollection;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;

class CategoryController extends Controller
{
    use Responder;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'categories';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'categories';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'category';

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.category'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $categories = Category::all();
        $this->setData('auth_token', auth()->user()->generateAuthToken());

        $this->setData('categories', $categories);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

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

        $count = $this->categoryRepository->destroy($ids)->count();
        if ($count) {
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
    public function edit(Category $category)
    {
        // dd($category);
//        $category->load('translations');
        $this->setData('title', __('main.edit') . ' ' . __('main.category') . ' : ' . $category->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $categories = Category::all();

        $this->setData('categories', $categories);
        $this->setData('auth_token', auth()->user()->generateAuthToken());

//        $this->setData('translations', $category->load('translations'));
        $this->setData('edit', $category->load([$category->type, 'translations']));
        $this->setData('type_data', $category->{$category->type});
        $this->setData('translations', $category->translations);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(CategoryResource::class, 'edit');

        return $this->response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->categoryRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );
        $this->setData('title', __('main.show-all') . ' ' . __('main.category'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(CategoryResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * @param CategoryDataTable $dataTable
     * @return mixed
     */
    public function dataTable(CategoryDataTable $dataTable)
    {
        return $dataTable->render("{$this->domainAlias}::{$this->viewPath}.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.category') . ' : ' . $category->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('category', $category);
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(CategoryResource::class, 'category');

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreFormRequest $request)
    {
        $category = $this->categoryRepository->make($request->validated());
        $category->user()->associate(auth()->user());
        $category->save();
        $category->{$request->type}()->attach($request->categorizable_id);

        $category->setTranslation([
            'name' => $request->name_ar,
        ], 'ar');

        if ($request->has('icon') && $category) {
            if ($category->hasMedia('icon')) {
                $category->clearMediaCollection('icon');
            }
            $category->addMedia($request->file('icon'))->toMediaCollection('icon');
        }

        $this->setData('data', $category);

        $this->redirectRoute("{$this->resourceRoute}.show", [$category->id]);
        $this->useCollection(CategoryResource::class, 'data');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateFormRequest $request, Category $category)
    {
        $category->update($request->validated());
        $category->{$request->type.'s'}()->attach($request->categorizable_id);

        $category->setTranslation([
            'name' => $request->name_ar,
        ], 'ar', true);

        if ($request->has('icon') && $category) {
            if ($category->hasMedia('icon')) {
                $category->clearMediaCollection('icon');
            }
            $category->addMedia($request->file('icon'))->toMediaCollection('icon');
        }

        $this->redirectRoute("{$this->resourceRoute}.show", [$category->id]);
        $this->setData('data', $category->fresh());
        $this->useCollection(CategoryResource::class, 'data');

        return $this->response();
    }

    public function deleteAll(Request $request)
    {
        $ids = implode(',', $request->items);

        $delete = $this->categoryRepository->destroy($ids)->count();

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

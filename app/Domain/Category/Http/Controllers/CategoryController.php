<?php

namespace App\Domain\Category\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Category\Entities\Category;
use App\Domain\Category\Http\Resources\Category\CategoryResource;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use App\Domain\Category\Http\Requests\Category\CategoryStoreFormRequest;
use App\Domain\Category\Http\Requests\Category\CategoryUpdateFormRequest;
use App\Domain\Category\Http\Resources\Category\CategoryResourceCollection;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

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
        $this->setData('title', __('main.edit') . ' ' . __('main.category') . ' : ' . $category->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $categories = Category::all();

        $this->setData('categories', $categories);

        $this->setData('edit', $category);

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
            $request->per_page ?? config('semak.pagination')
        );
        $this->setData('title', __('main.show-all') . ' ' . __('main.category'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(CategoryResourceCollection::class, 'data');

        return $this->response();
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
}

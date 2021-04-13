<?php

namespace App\Domain\Branch\Http\Controllers;

use App\Domain\Branch\Entities\Branch;
use App\Domain\Branch\Http\Requests\BranchProduct\BranchProductStoreFormRequest;
use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Joovlly\DDD\Traits\Responder;

class BranchProductController extends Controller
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
    protected $viewPath = 'branch_product';

    /**
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository, ProductVariationRepository $productVariationRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->productVariationRepository = $productVariationRepository;
    }
    public function index()
    {

    }
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.branch_product'), 'web');
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('auth_token', auth()->user()->generateAuthToken());
        $this->setData('products', $this->productVariationRepository->all());
        $this->setData('branches', $this->branchRepository->all(), 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();

    }

    public function edit(Branch $branch)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.branch_product'), 'web');
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('auth_token', auth()->user()->generateAuthToken());
        $this->setData('products', $this->productVariationRepository->all());
        $this->setData('branch', $branch->load('products'));
        $this->setData('branches', Branch::where('status', 'active')->get(), 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    /**
     * @param Branch $branch
     * @param BranchProductStoreFormRequest $request
     */
    public function store(Branch $branch, BranchProductStoreFormRequest $request)
    {
        $branch->products()->sync(
            $request->validated()
        );
        $this->setData('data', $branch);
        $this->redirectRoute("{$this->resourceRoute}.show", [$branch->id]);
        $this->useCollection(BranchResource::class, 'data');

        return $this->response();

    }
}

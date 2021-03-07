<?php

namespace App\Domain\Branch\Http\Controllers;

use Joovlly\DDD\Traits\Responder;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Branch\Http\Requests\BranchProduct\BranchProductStoreFormRequest;

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
    protected $viewPath = 'branch';

    /**
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function create()
    {

    }

    public function edit()
    {

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

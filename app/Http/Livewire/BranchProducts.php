<?php

namespace App\Http\Livewire;

use App\Common\Criteria\StatusIsCriteria;
use App\Common\Facades\Branch;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Product\Criteria\BranchIdCriteria;
use App\Domain\Product\Criteria\ProductVariationCategoriesCriteria;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use Livewire\Component;
use Livewire\WithPagination;

class BranchProducts extends Component
{
    use WithPagination;

    private $productRepository;
    private $branchRepository;
    public $branchId;
    public $products;
    public $pagination;
    public $action;

    protected $listeners = ['productsWithCategory', 'clearFilter' => 'rendProducts'];
    /**
     * @param ProductVariationRepository $productRepository
     */

    public function updating(ProductVariationRepository $productRepository, BranchRepository $branchRepository)
    {
        $this->productRepository = $productRepository;
        $this->branchRepository = $branchRepository;
    }
    public function render()
    {
        return view('livewire.branch-products');
    }

    public function productsWithCategory($category_id, BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->branchRepository->pushCriteria(new StatusIsCriteria(true));
        $this->products = $this->branchRepository->with(['products' => function($q) use($category_id){ return $q->where('status', 'active')->categories($category_id);}])->find($this->branchId)->products ?: [];
        $this->emitTo('total-products', 'totalCount', count($this->products));
    }

    public function rendProducts(ProductVariationRepository $productRepository, BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->branchRepository->pushCriteria(new StatusIsCriteria(true));
        $this->products = $this->branchRepository->with(['products' => function($q) {return $q->where('status', 'active');}])->find($this->branchId)->products;
        $this->emitTo('total-products', 'totalCount', $this->products->count());
    }
}

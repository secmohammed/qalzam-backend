<?php

namespace App\Http\Livewire;

use App\Common\Criteria\StatusIsCriteria;
use App\Common\Facades\Branch;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Product\Criteria\BranchIdCriteria;
use App\Domain\Product\Criteria\ProductVariationCategoriesCriteria;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class BranchProducts extends Component
{
    use WithPagination;

    private $productRepository;
    private $branchRepository;
    public $branchId;
    protected $rendProducts;
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

    public function mount($rendProducts)
    {
        $this->rendProducts = $rendProducts;
    }
    public function render()
    {
        $products = $this->rendProducts;
        return view('livewire.branch-products',compact('products'));
    }

    public function productsWithCategory($category_id, BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->branchRepository->pushCriteria(new StatusIsCriteria(true));
        $this->rendProducts = $this->branchRepository->with(['mainProducts' => function($q) use($category_id)
            {
                return $q->where('status', 'active')->whereHas('categories', function ($category) use ($category_id)
                {
                    return $category->where('category_id', $category_id);
                });
            }])->find($this->branchId)->mainProducts->duplicatesStrict() ?: [];
        $this->emitTo('total-products', 'totalCount', $this->rendProducts->count());
    }

    public function rendProducts(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->branchRepository->pushCriteria(new StatusIsCriteria(true));
        $this->rendProducts = $this->branchRepository->with(['mainProducts' => function($q) {return $q->where('status', 'active');}])->find($this->branchId)->mainproducts->duplicatesStrict();
        $this->emitTo('total-products', 'totalCount', $this->rendProducts->count());
    }
}

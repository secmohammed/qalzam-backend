<?php

namespace App\Http\Livewire;

use App\Common\Criteria\StatusIsCriteria;
use App\Common\Facades\Cart;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Product\Criteria\BranchIdCriteria;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use Livewire\Component;
use Livewire\WithPagination;

class MostOrderedProduct extends Component
{
    use WithPagination;

    private $productRepository;
    private $branchRepository;
    public $branchId;
    public $pagination;
    public $action;
    /**
     * @param ProductVariationRepository $productRepository
     */
    public function mount(ProductVariationRepository $productRepository, BranchRepository $branchRepository)
    {
        $this->productRepository = $productRepository;
        $this->branchRepository = $branchRepository;
    }

    public function render()
    {
        $this->productRepository->pushCriteria(new StatusIsCriteria(true));
        $products = $this->productRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );
        return view('livewire.most-ordered-product', compact('products'));
    }
}

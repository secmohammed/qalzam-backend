<?php

namespace App\Http\Livewire;

use App\Common\Criteria\StatusIsCriteria;
use App\Common\Facades\Cart;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use Livewire\Component;
use Livewire\WithPagination;

class MostSellProduct extends Component
{
    use WithPagination;

    private $productRepository;

    /**
     * @param ProductVariationRepository $productRepository
     */
    public function mount(ProductVariationRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function render()
    {
        $this->productRepository->pushCriteria(new StatusIsCriteria(true));
        $products = $this->productRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );
        return view('livewire.most-sell-product', compact('products'));
    }

}

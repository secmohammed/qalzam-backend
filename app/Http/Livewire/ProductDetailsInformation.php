<?php

namespace App\Http\Livewire;

use App\Common\Facades\Branch;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use Livewire\Component;

class ProductDetailsInformation extends Component
{
    public $description;
    public $product;
    public $productVariation;
   
    protected $listeners = ['variationDescriptionChanged'];
    public function getBranchProperty()
    {
        return  Branch::getChangeableBranch();
    }

    public function getBranchIdProperty()
    {
        return $this->branch->id;
    }

  public function mount(ProductVariationRepository   $productVariationRepository)
  {
    $branch_id = $this->branch->id;
    $this->productVariation = $productVariationRepository->with(['branches' => function ($q) use($branch_id) { return $q->where('branch_id', $branch_id);}])
    ->findWhere(['product_id' => $this->product->id])->first();
        $this->variationDescriptionChanged($this->productVariation->description);
   
  }

    public function render()
    {

        return view('livewire.product_details_information');
    }
    public function variationDescriptionChanged($description)
    {
        $this->description = $description;
        # code...
    }
    /**
    *
     */
   
}

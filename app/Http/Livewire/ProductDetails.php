<?php

namespace App\Http\Livewire;

use App\Common\Facades\Branch;
use App\Common\Facades\Cart;
use App\Common\Transformers\Money;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Entities\ProductVariationType;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use Livewire\Component;

class ProductDetails extends Component
{
    public $product;
    public $quantity;
    public $productVariation;
    public $productVariationId;
    public $productVariationName;
    public $productVariationDescription;
    public $productVariationSlug;
    public $productVariationPrice;
    public $productName;
    protected $listeners = ['changeVariationType'];
    public function getVariationTypesProperty()
    {
        return $this->product->variations()->whereHas('branches', function ($q){ return $q->where('branches.id', Branch::getChangeableBranch()->id);})->get()->pluck('type');
    }

    public function getProductIdProperty()
    {
        return $this->product->id;
    }

    /**
     * @return mixed
     */
    public function getBranchProperty()
    {
        return  Branch::getChangeableBranch();
    }

    public function getBranchIdProperty()
    {
        return $this->branch->id;
    }

    public function mount(ProductVariationRepository $productVariationRepository)
    {
        $branch_id = $this->branch->id;
        $this->quantity = 1;
        $this->productName =$this->product->name;
        // get First Product Variation
        $this->productVariation = $productVariationRepository
            ->with(['branches' => function ($q) use($branch_id) { return $q->where('branch_id', $branch_id);}])
            ->findWhere(['product_id' => $this->product->id])->first();
       
            $this->productVariationChanged();
    }

    public function render()
    {
        
        return view('livewire.product-details');
    }
    /**
    *
     */
    public function addToCart()
    {
        $added = Cart::add($this->productVariation, $this->quantity);
        if($added)
        {
            $this->emit('toaster', 'Added To Cart Successfully','success');
            $this->emit('amountChanged');
            $this->resetQuantity();
            return;
        }
        $this->emit('toaster', 'You Should Choose Product From The Same Current Branch Or Clear The Cart', 'error');
        return;
    }

    public function increaseQuantity()
    {
        // todo check amount in stock before increase amount
        $this->quantity += 1;
    }

    public function decreaseQuantity()
    {
        if($this->quantity == 1){
            $this->emit('toaster', 'Amount Should Be one or More', 'warning');
            $this->quantity = 1 ;
            return ;
        }
        $this->quantity -= 1;
    }

    /**
     * @param $product_variation_id
     * @param ProductVariationRepository $productVariationRepository
     */
    public function changeVariationType($product_variation_type_id,ProductVariationRepository $productVariationRepository)
    {
        $branch_id = $this->branch_id;
        $this->productVariation = $productVariationRepository->with('branches')
            ->whereHas('branches', function ($q) use($branch_id)
            {
                return $q->where('id' , $branch_id);
            }
            )->findWhere(['product_variation_type_id' => $product_variation_type_id, 'product_id' => $this->product_id])->first();
        $this->productVariationChanged();

    }

    private function productVariationChanged()
    {
        $this->emit('variationDescriptionChanged',$this->productVariation->description  );

        $this->productVariationId = $this->productVariation->id;
        $this->resetQuantity();
        $this->productVariationName = $this->productVariation->name;
        $this->productVariationDescription = $this->productVariation->description;
        $this->productVariationSlug = $this->productVariation->slug;
        $this->productVariationPrice = $this->formatPrice($this->productVariation->branches->filter(function($branch){ return $branch->id == $this->branchId;})->first()->pivot->price * 100);
    }
    private function resetQuantity()
    {
        $this->quantity = 1;
    }

    private function formatPrice($price)
    {
        $newMoney = new Money($price);
        return $newMoney->formatted();
    }
}

<?php

namespace App\Http\Livewire;

use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use Livewire\Component;

class ProductVariationTypes extends Component
{
    public $variationTypes;

    public function getTypesProperty()
    {
        return $this->variationTypes;
    }

    public function render()
    {
        return view('livewire.product-variation-types');
    }

    public function changeVariationType($product_variation_type_id)
    {
//        dd($product_variation_type_id . ' this is ');
        $this->emit('changeVariationType', $product_variation_type_id);
    }
}

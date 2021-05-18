<?php

namespace App\Http\Livewire\Card;

use App\Common\Facades\Branch;
use App\Common\Facades\Cart;
use App\Domain\Product\Entities\ProductVariation;
use Livewire\Component;

class VerticalCard extends Component
{
    public $product;
    public $action;

    public $productId;
    public $productImage;
    public $productPrice;
    public $productName;

    public function render()
    {
        $branch = Branch::get();
        return view('livewire.card.vertical-card',["branch"=>$branch]);
    }

    public function addToCart(ProductVariation $productId)
    {
        $product = Cart::add($productId);
        $this->emit('amountChanged');
    }
}

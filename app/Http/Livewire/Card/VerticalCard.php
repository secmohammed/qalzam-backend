<?php

namespace App\Http\Livewire\Card;

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
    public function render()
    {
        return view('livewire.card.vertical-card');
    }

    public function addToCart(ProductVariation $productId)
    {
        $product = Cart::add($productId);
        $this->emit('amountChanged');
    }
}

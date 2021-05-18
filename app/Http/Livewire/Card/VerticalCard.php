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
    public $productName;

    public function render()
    {
        return view('livewire.card.vertical-card');
    }

    public function addToCart(ProductVariation $productId)
    {
        $added = Cart::add($productId);
        if($added)
        {
            $this->emit('toaster', 'Added To Cart Successfully','success');
            $this->emit('amountChanged');
            return;
        }
        $this->emit('toaster', 'You Should Choose Product From The Same Current Branch Or Clear The Cart', 'error');
        return;
    }
}

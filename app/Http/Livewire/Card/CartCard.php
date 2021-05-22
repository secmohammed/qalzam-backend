<?php

namespace App\Http\Livewire\Card;

use App\Common\Facades\Cart;
use Livewire\Component;

class CartCard extends Component
{
    public $product;
    public $quantity;
    public $productId;
    public $productName;
    public $productVariationName;
    public $productCategory;
    public $productTotalPrice;
    public $productImage;
//    protected $listeners = ['amountChanged' => '$refresh'];

    public function render()
    {
        return view('livewire.card.cart-card');
    }

    public function removeProduct($productId)
    {
        Cart::remove($productId);
        $this->emit('productRemoved');
    }

    public function increaseAmount($productId)
    {
        $cart = Cart::get();
        Cart::productCartIncrement($productId,$cart['products']);
        $this->quantity += 1;
        $this->emit('amountChanged');
    }

    public function reduceAmount($productId)
    {
        $cart = Cart::get();
        $products = collect($cart['products']);
        $product = $products->where('id', $productId)->first();
        if($product->quantity > 1){
            Cart::ProductCartReduce($productId, $cart['products']);
            $this->quantity -= 1;
        }
        else
            $this->removeProduct($productId);
        $this->emit('amountChanged');
    }

}

<?php

namespace App\Http\Livewire\Card;

use App\Common\Facades\Cart;
use Livewire\Component;

class CartCard extends Component
{
    public $product;

    public function render()
    {
        $amount = $this->product->amount;
        return view('livewire.card.cart-card', compact('amount'));
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
        $this->emit('amountChanged');
    }

    public function reduceAmount($productId)
    {
        $cart = Cart::get();
        $products = collect($cart['products']);
        $product = $products->where('id', $productId)->first();
        if($product->amount > 1)
            Cart::ProductCartReduce($product->id, $cart['products']);
        else
            $this->removeProduct($productId);
        $this->emit('amountChanged');
    }

}

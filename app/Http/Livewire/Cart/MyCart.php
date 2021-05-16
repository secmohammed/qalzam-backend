<?php

namespace App\Http\Livewire\Cart;

use App\Common\Facades\Cart;
use Livewire\Component;

class MyCart extends Component
{
    protected $listeners = ['amountChanged' => '$refresh'];


    public function render()
    {
        $cart = Cart::get();
        $products = $cart['products'];
        $totalPrice = Cart::totalPrice();
        $afterVat = Cart::afterVat();
        return view('livewire.cart.my-cart', compact('products', 'totalPrice', 'afterVat'));
    }
}

<?php

namespace App\Http\Livewire\Cart;

use App\Common\Facades\Cart;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class SliderCart extends Component
{
    protected $listeners = ['amountChanged' => '$refresh'];
    public $totalPrice;

    public function render()
    {
        $cart = Cart::get();
        $products = $cart['products'];
        $total_price = Cart::totalPrice();
        $after_vat =Cart::afterVat();
        $total_after_vat = Cart::totalPriceAfterVat();
        return view('livewire.cart.slider-cart' , compact('products', 'total_price', 'after_vat', 'total_after_vat'));
    }
}

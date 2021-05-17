<?php

namespace App\Http\Livewire;

use App\Common\Facades\Cart;
use Livewire\Component;

class PriceCard extends Component
{
    public $method;
    public $action;
    public $finishOrder;
    protected $listeners = ['productAdded' => '$refresh', 'amountChanged' => '$refresh'];

    public function render()
    {
        $totalPrice =Cart::totalPrice();
        $afterVat =Cart::afterVat();
        $totalAfterVat = Cart::totalPriceAfterVat();
        return view('livewire.price-card', compact('totalPrice', 'afterVat' , 'totalAfterVat'));
    }
}

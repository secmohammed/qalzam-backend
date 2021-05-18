<?php

namespace App\Http\Livewire;

use App\Common\Facades\Cart;
use App\Domain\Discount\Entities\Discount;
use Livewire\Component;

class PriceCard extends Component
{
    public $method;
    public $action;
    public $finishOrder;
    public $code;
    protected $rules = [
        'code' => ['required', 'exists:discounts,code'],
    ];
    protected $listeners = ['productAdded' => '$refresh', 'amountChanged' => '$refresh'];

    public function render()
    {
        $totalPrice =Cart::totalPrice();
        $afterVat =Cart::afterVat();
        $totalAfterVat = Cart::totalPriceAfterVat();
        $totalAfterCoupon = Cart::CouponValue();
        $priceTotal = Cart::getTotalPrice();
        return view('livewire.price-card', compact('totalPrice', 'afterVat' , 'totalAfterVat', 'totalAfterCoupon', 'priceTotal'));
    }

    public function applyCoupon()
    {
        $this->validate();
        try {
            $discount = Discount::where('code', $this->code)->first();
            $discount->validate();
            Cart::applyCoupon($discount);
        }
        catch (\Exception $e){
            $this->addError('code', $e->getMessage());
        }
    }
}

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
        $totalBeforeVat = Cart::totalPriceBeforeVat();
        $totalAfterCoupon = Cart::CouponValue();
        $priceTotalBeforeVat = Cart::getTotalPrice();
        return view('livewire.price-card', compact('totalPrice', 'afterVat' , 'totalBeforeVat', 'totalAfterCoupon', 'priceTotalBeforeVat'));
    }

    public function applyCoupon()
    {
        $this->validate();
        try {
            $discount = Discount::where('code', $this->code)->first();
            $discount->validate();
            if(Cart::applyCoupon($discount))
                $this->emit('toaster', 'Coupon Activated!', 'success');
            else
                $this->emit('toaster', 'Coupon Already Activated Before!', 'error');
        }
        catch (\Exception $e){
            $this->emit('toaster', $e->getMessage(),'error');
        }
    }
}

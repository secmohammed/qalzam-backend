<?php


namespace App\Common\Traits;


use App\Common\Facades\Cart;
use App\Domain\Discount\Entities\Discount;

trait HasCoupon
{

    /**
     * @param Discount $discount
     * @return bool
     */
    public function applyCoupon(Discount $discount):bool
    {
        if($this->getCoupon() != $discount){
            $this->setCoupon($discount);
            return true;
        }
        return false;
    }

    /**
     * @return float|int
     */
    public function applyCouponValue()
    {
        $this->getCoupon()->users()->attach(auth()->id(), ['used_at' => now()]);
        return $this->totalPrice();
    }

    public function CouponValue()
    {
        $discount =  $this->getCoupon();
        if($discount)
            return $discount->type == 'amount' ? $discount->value : $this->totalPrice() * ($discount->value/100);
        return 0;
    }
    /**
     * @param Discount $discount
     */
    public function setCoupon(Discount $discount)
    {
        request()->session()->put('coupon', $discount);
    }

    public function clearCoupon()
    {
        request()->session()->put('coupon', null);
    }
    /**
     * @return mixed
     */
    public function getCoupon()
    {
        return session('coupon');
    }

    public function getCouponId()
    {
        return $this->getCoupon() ? $this->getCoupon()->id  : null;

    }
    public function totalPriceAfterCoupon()
    {
        $discount = $this->getCoupon();
        $total_after_vat = $this->totalPrice();
        if($discount)
            return $total_after_vat -= $discount->type == 'percentage' ? $this->byPercentage($discount->value,$this->totalPrice()) : $this->byAmount($discount->value);
        return $this->totalPrice();
    }

    public function applyCouponValueWhenExist()
    {
        $discount = $this->getCoupon();
        if($discount)
            $this->total_price -= $discount->type == 'percentage' ? $this->byPercentage($discount->value,$this->total_price) : $this->byAmount($discount->value);
    }

    /**
     * @param Discount $discount
     * @return bool|mixed
     */
    public function isValidCoupon(Discount $discount)
    {
        return $discount->validate();
    }

    /**
     * @param $value
     * @param null $amount
     * @param bool $overwrite
     * @return float|int|mixed|null
     */
    private function byPercentage($value,$amount)
    {
        return $amount * ($value/100);
    }

    /**
     * @param $value
     * @return float|int
     */
    private function byAmount($value)
    {
        return $value;
    }
}

<?php

namespace App\Common\Cart;

use App\Common\Transformers\Money;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Discount\Traits\PriceCalculator;
use App\Domain\User\Entities\User;

class Cart
{
    public $user;

    protected $changed = false;
    protected $type;
    protected $branch;
    protected $discount;
    const VAT = .15;
    public function __construct(User $user = null)
    {
        $this->user = $user;
        $this->discount = new Discount;
    }
    public function add($products)
    {
        return $this->user->{$this->getType()}()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }
    public function withDiscount($discount)
    {
        $this->discount = $discount;
    }
    public function setCartType(string $type)
    {
        if (!in_array($type, $types = ['cart', 'wishlist'])) {
            throw new \Exception('Invalid cart type, it must be type of ' . implode(',', $types));
        }
        $this->type = $type;
        return $this;
    }
    public function getType()
    {
        if (!in_array($this->type, $types = ['cart', 'wishlist'])) {
            throw new \Exception('Invalid cart type, it must be type of ' . implode(',', $types));
        }
        return $this->type;
    }
    public function hasBranch()
    {
        return !!$this->branch;
    }
    public function hasType()
    {
        return !!$this->type;
    }
    public function hasDiscount()
    {
        return !!$this->discount;
    }
    public function update($productId, $quantity)
    {
        return $this->user->{$this->getType()}()->wherePivot('branch_id', $this->branch->id)->wherePivot('type', $this->getType())->updateExistingPivot($productId, [
            'quantity' => $quantity,
        ]);
    }
    public function delete($productId)
    {
        return $this->user->{$this->getType()}()->wherePivot('branch_id', $this->branch->id)->wherePivot('type', $this->getType())->detach($productId);
    }
    public function subtotalWithoutDiscount()
    {
        $products = $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id);
        return new Money(
            app(PriceCalculator::class)->calculcateDiscountedPrice(new Discount, $products)
        );
    }
    public function discountValue()
    {
        return new Money(
            $this->hasDiscount() ?   $this->subtotalWithoutDiscount()->amount() - $this->subtotal()->amount():0
        );

         
    }
    function empty() {
        $this->user->{$this->getType()}()->wherePivot('branch_id', $this->branch->id)->wherePivot('type', $this->getType())->detach();
        $this->branch = null;
    }
    public function withBranch(Branch $branch)
    {
        $this->branch = $branch;
        return $this;
    }
    public function isEmpty()
    {
        // dd($this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id));
        return $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id)->sum('pivot.quantity') <= 0;
    }
    public function subtotal()
    {

        $products = $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id);
        return new Money(
            app(PriceCalculator::class)->calculcateDiscountedPrice($this->discount, $products)
        );
    }

    public function sync()
    {
        $this->user->load(sprintf('%s.stock', $this->type));
        $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id)->each(function ($product) {
            $quantity = $product->minStock($product->pivot->quantity);
            if ($quantity != $product->pivot->quantity) {
                $this->changed = true;
            }
            $product->pivot->update([
                'quantity' => $quantity,
            ]);
        });
    }
    public function hasChanged()
    {
        return $this->changed;
    }
    public function total()
    {
        if ($this->subtotal()->amount()) {
            return $this->subtotal()->add(new Money($this->branch->delivery_fee + $this->subtotal()->amount()*self::VAT));

        }
        return $this->subtotal();
    }
    public function Vat()
    {
            return new Money( $this->subtotal()->amount()* self::VAT);

    }
    public function deliveryFee()
    {
            return new Money($this->branch->delivery_fee);

    }
    // public function discountValue()
    // {
    //         if($this->discount)
    //         return   $this->subtotal() -   
    // }

    public function products()
    {
        return $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id);
    }
    protected function getCurrentQuantity($productId)
    {
        if ($product = $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id)->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }
        return 0;
    }
    protected function getStorePayload($products)
    {
        return collect($products)->collapse()->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $this->getType() == 'cart' ? $product['quantity'] + $this->getCurrentQuantity($product['id']) : 1,
                'type' => $this->type,
                'branch_id' => $this->branch->id,
            ];
        })->toArray();
    }
}

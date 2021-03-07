<?php

namespace App\Common\Cart;

use App\Common\Transformers\Money;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;

class Cart
{
    public $user;

    protected $changed = false;
    protected string $type;
    protected $branch;
    protected $discount;
    public function __construct(User $user = null)
    {
        $this->user = $user;
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
        if(!in_array($type, $types = ['cart', 'wishlist'])) {
            throw new \Exception('Invalid cart type, it must be type of '. implode(',', $types));
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
    public function update($productId , $quantity)
    {
        return $this->user->{$this->getType()}()->wherePivot('branch_id', $this->branch->id)->wherePivot('type', $this->getType())->updateExistingPivot($productId , [
            'quantity' => $quantity,
        ]);
    }
    public function delete($productId)
    {
      return  $this->user->{$this->getType()}()->wherePivot('branch_id', $this->branch->id)->wherePivot('type', $this->getType())->detach($productId);
    }
    public function empty()
    {
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
        return $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id)->sum('pivot.quantity') <= 0;
    }
    public function subtotal()
    {
        $subtotal = $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id)->sum(function ($product) {
            //TODO: after updating the discount to be using discountable, check if the model is category and product is belonging to this category
            // TODO: Also, check if the discountable type is product, then check if the variation added is belonging to the product.
            // if  ($product->product->categories->contains('id', $this->discount->category->id)) {
            //     $subtotal = $product->price->amount() * $product->pivot->quantity;

            //     $subtotal = $subtotal - ($subtotal * $this->discount->percentage / 100);

            // }
            return $product->price->amount() * $product->pivot->quantity;
        });
        return new Money($subtotal);
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
                'quantity' => $quantity
            ]);
        });
    }
    public function hasChanged()
    {
        return $this->changed;
    }
    public function total()
    {
        if  ($this->subtotal()->amount()) {
            return $this->subtotal()->add(new Money($this->branch->delivery_fee));

        }
        return $this->subtotal();
    }
    public function products()
    {
        return $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id);
    }
    protected function getCurrentQuantity($productId)
    {
        if ($product = $this->user->{$this->getType()}->where('pivot.branch_id', $this->branch->id)->where('id',$productId)->first()) {
            return $product->pivot->quantity;
        }
        return 0;
    }
    protected function getStorePayload($products)
    {
        return collect($products)->collapse()->keyBy('id')->map(function ($product) {
            return  [
                'quantity' => $this->getType() == 'cart' ? $product['quantity'] + $this->getCurrentQuantity($product['id']) : 1,
                'type' => $this->type,
                'branch_id' => $this->branch->id
            ];
        })->toArray();
    }
}

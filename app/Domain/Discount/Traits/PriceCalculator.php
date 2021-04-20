<?php
namespace App\Domain\Discount\Traits;

use App\Domain\Discount\Entities\Discount;
use App\Domain\Product\Entities\ProductVariation;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;

class PriceCalculator
{
    /**
     * @param Discount   $discount
     * @param Collection $products
     */
    public function calculcateDiscountedPrice(Discount $discount, Collection $products)
    {
        switch ($discount->discountable_type) {
            case 'category':
                return $this->calculcateDiscountedPriceBasedOnCategory($discount, $products);
            case 'product':
                return $this->calculateDiscountedPriceBasedOnProduct($discount, $products);
            case 'variation':
                return $this->calculateDiscountedPriceBasedOnVariation($discount, $products);
            default:
                return $this->calculatePrice($discount, $products, new Collection());
        }

    }

    /**
     * @param $discount
     * @param $products
     */
    private function calculateDiscountedPriceBasedOnProduct(Discount $discount, Collection $products): float
    {
        $variationsBasedOnProduct = app(ProductVariation::class)->whereIn('id', $products->pluck('id'))->whereHas('product', function ($query) use ($discount) {
            $query->where('id', $discount->discountable_id);
        })->get()->map(function ($product) use ($products) {

            $product->pivot = new Pivot([
                'quantity' => $products->where('id', $product->id)->first()->pivot->quantity,
            ]);

            return $product;
        });

        return $this->calculatePrice($discount, $products, $variationsBasedOnProduct);
    }

    /**
     * @param  $discount
     * @param  $products
     * @return mixed
     */
    private function calculateDiscountedPriceBasedOnVariation(Discount $discount, Collection $products): float
    {
        $products->load(['discount' => function ($query) use ($discount) {
            $query->whereId($discount->id);
        }]);
        return $products->sum(function ($product) {
            // dd($product->discount->contains('id',$discount->id),$product->discount->find($discount->id),$discount);
            if ($discount = $product->discount->first()) {
                return $this->calculatePriceBasedOnDiscountType($discount, $product->price->amount() * $product->pivot->quantity);

            }
            return $product->price->amount() * $product->pivot->quantity;
        
        });
    }

    /**
     * @param Discount   $discount
     * @param Collection $products
     * @param Collection $matchedProducts
     */
    private function calculatePrice(Discount $discount, Collection $products, Collection $matchedProducts): float
    {
        $count = $matchedProducts->count() ? $matchedProducts->count() : 1;
        $discountedPrice = $matchedProducts->sum(function ($product) use ($count, $discount) {

            return $this->calculatePriceBasedOnDiscountType($discount, $product->price->amount() * $product->pivot->quantity, $count);
        });
        $filteredProducts = $products->filter(function ($product) use ($matchedProducts) {
            return !$matchedProducts->contains('id', $product->id);
        });
        return $filteredProducts->reduce(function ($carry, $product) {
            return $carry + ($product->price->amount() * $product->pivot->quantity);
        }, $discountedPrice);
    }

    /**
     * @param  $discount
     * @param  $price
     * @return mixed
     */
    private function calculatePriceBasedOnDiscountType(Discount $discount, int $price, int $divison = 1): float
    {

        if ($discount->type == 'amount') {
            $discountedPrice = $price - ($discount->value / $divison);
            // APPLY discounts only if the price is larger than amount of discount price.

            return $discountedPrice > 0 ? $discountedPrice : $price;
        }

        return $price - ($price * ($discount->value / $divison) / 100);
    }

    /**
     * @param $discount
     * @param $products
     */
    private function calculcateDiscountedPriceBasedOnCategory(Discount $discount, Collection $products): float
    {
        $variationsBasedOnCategory = app(ProductVariation::class)->whereIn('id', $products->pluck('id'))->whereHas('product.categories', function ($query) use ($discount) {
            $query->where('categories.id', $discount->discountable_id);
        })->get()->map(function ($product) use ($products) {

            $product->pivot = new Pivot([
                'quantity' => $products->where('id', $product->id)->first()->pivot->quantity,
            ]);

            return $product;
        });

        return $this->calculatePrice($discount, $products, $variationsBasedOnCategory);
    }

}

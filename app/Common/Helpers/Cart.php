<?php


namespace App\Common\Helpers;


use App\Domain\Product\Entities\ProductVariation;

class Cart
{
    public function __construct()
    {
        if($this->get() === null)
            $this->set($this->empty());
    }

    public function add(ProductVariation $product, $amount = 0): void
    {
        $cart = $this->get();
        $cartProductsIds = array_column($cart['products'], 'id');

        $product->amount = !empty($product->amount) ? $product->amount + $amount : $this->addedAmount($amount);

        $product->image = $product->getLastMediaUrl('product_variation-images');
        if (in_array($product->id, $cartProductsIds)) {
            $cart['products'] = $this->productCartIncrement($product->id, $cart['products'],$amount);
            $this->set($cart);
            return;
        }
        $product->total_price = $product->price->amount() * $amount;
        array_push($cart['products'], $product);
        $this->set($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();
        array_splice($cart['products'], array_search($productId, array_column($cart['products'], 'id')), 1);
        $this->set($cart);
    }

    public function clear(): void
    {
        $this->set($this->empty());
    }

    public function empty(): array
    {
        return [
            'products' => [],
        ];
    }

    public function get()
    {
        return request()->session()->get('cart');
    }

    private function set($cart): void
    {
        request()->session()->put('cart', $cart);
    }

    public function productCartIncrement($productId, $cartItems, $amount = 0)
    {
        $amount = $this->addedAmount($amount);
        $cartItems = array_map(function ($item) use ($productId, $amount) {
            if ($productId == $item['id']) {
                $item['amount'] += $amount;
                $item['total_price'] += $item['total_price'];
            }

            return $item;
        }, $cartItems);

        return $cartItems;
    }

    public function ProductCartReduce($productId, $cartItems)
    {
        $amount = 1;
        $cartItems = array_map(function ($item) use ($productId, $amount) {
            if ($productId == $item['id']) {
                $item['amount'] -= $amount;
                $item['total_price'] -= $item['total_price'];
            }

            return $item;
        }, $cartItems);
        return $cartItems;
    }

    public function cartTotalProductsAmount($products = null)
    {
        if ((is_null($products))) {
            $cart = $this->get();
            $products = $cart['products'];
        }
        return array_sum(array_column($products,'amount'));
//        return  collect($products)->sum('amount');
    }

    public function totalPrice($products = null)
    {
        $total_price = 0;
        if ((is_null($products))){
            $cart = $this->get();
            $products = $cart['products'];
        }

        foreach ($products as $product){
            $total_price += $product->price->amount() * $product->amount;
        }
        return $total_price;
    }

    public function afterVat()
    {
        return $this->totalPrice() * config('qalzam.vat');
    }

//    public function s
    private function addedAmount($amount)
    {
        if($amount > 0)
            return $amount;
        return 1;
    }
    public function getProduct($productId)
    {
        $cart = $this->get();
        $products = collect($cart['products']);
        $product = $products->first(function ($item) use ($productId){
            return $item->id = $productId;
        });
        return $product ?: null;
    }
}

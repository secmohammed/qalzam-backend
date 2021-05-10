<?php


namespace App\Common\Helpers;


use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Branch\Entities\Branch as Branch;
use App\Common\Facades\Branch as BranchFacade;
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

        $product->quantity = !empty($product->qunatity) ? $product->qunatity + $amount : $this->addedAmount($amount);

        $product->image = $product->getLastMediaUrl('product_variation-images');
        $product->type = 'cart';
        $product->product_variation_id  = $product->id;
        $product->branch_id = BranchFacade::get()->id;
        // check Porduct in the same Session Branch
        if(!$this->inBranch(BranchFacade::get(),$product))
            return ;
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
                $item['quantity'] += $amount;
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
                $item['quantity'] -= $amount;
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
            $total_price += $product->price->amount() * $product->quantity;
        }
        return $total_price;
    }

    public function afterVat()
    {
        return $this->totalPrice() * config('qalzam.vat');
    }

    public function syncAfterLogin()
    {
        $cart = $this->get();
        $products = $cart['products'];

        $products = collect($products)->collapse()->keyBy('id')->map(function ($product) {
            return [
                'quantity' =>  $product['quantity'] ,
                'type' => $product['type'],
                'branch_id' => $product['branch_id'],
            ];
        })->toArray();

//        $products = $products->only('product_variation_id', 'branch_id', 'quantity', 'type');
        if(count($products) > 0)
            auth()->user()->cart()->firstOrCreate($products);
    }

    public function getProductsToBeOrdered()
    {
        $cart = $this->get();
        $products = array_map(function ($product){
            return array(
                'id' => $product['id'],
                'quantity' => $product['quantity'],
            );
        },$cart['products']);
        return collect($products);
    }

    private function addedAmount($amount)
    {
        if($amount > 0)
            return $amount;
        return 1;
    }

    public function inBranch(Branch $branch,$product):bool
    {
        $branch = $product->branches()->where('branch_id', $branch->id)->first();
        if($branch)
            return true;
        return false;
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

<?php


namespace App\Common\Helpers;


use App\Common\Traits\HasCoupon;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Branch\Entities\Branch as Branch;
use App\Common\Facades\Branch as BranchFacade;
use App\Domain\Product\Entities\Stock;

class Cart
{
    use HasCoupon;

    public $total_price = 0;
    /**
     * Cart constructor.
     * Initial Cart if Not Exist Before
     */
    public function __construct()
    {
        if($this->get() === null)
            $this->set($this->empty());
    }

    /**
     * Add Product OR Increase product quantity by quantity if exist
     * @param ProductVariation $product
     * @param int $quantity
     * @return bool
     */
    public function add(ProductVariation $product,int $quantity = 1): bool
    {
        // check Product in the same Session Branch
        if(! BranchFacade::checkBranchIdentical(BranchFacade::getChangeableBranch()))
            return false;
        // Check Product Available in stock
//        $this->availableInStock($product,$quantity);

        // Get Single Instance Product
        $product = $this->getProductInstance($product->id);

        // get Cart From Session
        $cart = $this->get();

        $this->setProductCustomData($product,$quantity);

        if (in_array($product->id, $this->productsIds())) {
            $cart['products'] = $this->productCartIncrement($product->id, $cart['products'],$quantity);
            $this->set($cart);
            return true;
        }
        $product->total_price = $product->pivot->price * $quantity;
        array_push($cart['products'], $product);
        $this->set($cart);
        return true;
    }

    /**
     * remove single product from cart by product id
     * @param int $productId
     */
    public function remove(int $productId): void
    {
        $cart = $this->get();
        array_splice($cart['products'], array_search($productId, array_column($cart['products'], 'id')), 1);
        $this->set($cart);
    }

    /**
     * Remove Products from session cart
     */
    public function clear(): void
    {
        $this->set($this->empty());
    }

    /**
     * assign cart products to empty array to clear session cart
     * @return array[]
     */
    public function empty(): array
    {
        return [
            'products' => [],
        ];
    }

    /**
     * return cart from session
     * @return mixed
     */
    public function get()
    {
        return request()->session()->get('cart');
    }

    /**
     * initial cart in session
     * @param $cart
     */
    private function set($cart): void
    {
        request()->session()->put('cart', $cart);
    }

    /**
     * increase quantity of product
     * @param $productId
     * @param $cartItems
     * @param int $quantity
     * @return array
     */
    public function productCartIncrement($productId, $cartItems,int $quantity = 1)
    {
        $cartItems = array_map(function ($item) use ($productId, $quantity) {
            if ($productId == $item['id']) {
                $item['quantity'] += $quantity;
                $item['total_price'] += $item['pivot']->price;
            }
            return $item;
        }, $cartItems);

        return $cartItems;
    }

    /**
     * reduce quantity of product
     * @param $productId
     * @param $cartItems
     * @param int $quantity
     * @return array
     */
    public function ProductCartReduce($productId, $cartItems,int $quantity = 1):array
    {
        $cartItems = array_map(function ($item) use ($productId, $quantity) {
            if ($productId == $item['id']) {
                $item['quantity'] -= $quantity;
                $item['total_price'] = $item['total_price'] -  $item['pivot']->price;
            }

            return $item;
        }, $cartItems);

        return $cartItems;
    }

    /**
     * sum all products quantity
     * @param null $products
     * @return float|int
     */
    public function totalProductsQuantity($products = null)
    {
        if ((is_null($products))) {
            $cart = $this->get();
            $products = $cart['products'];
        }
        return array_sum(array_column($products,'quantity'));
    }

    /**
     * @return int|float
     */
    public function getTotalPrice()
    {
        $this->total_price = $this->totalPriceBeforeVat();
        $this->applyCouponValueWhenExist();
        return $this->total_price;
    }

    /**
     * get total price for products in cart Which Include VAt But without Discount
     * @param null $products
     * @return float|int
     */
    public function totalPrice($products = null)
    {
        $total_price = 0;
        if ((is_null($products))){
            $cart = $this->get();
            $products = $cart['products'];
        }
        foreach ($products as $product){
            $total_price += $product->total_price;
        }
        return $total_price;
    }

    /**
     * get VAT value from total price
     * @return float|int
     */
    public function afterVat()
    {
        return $this->totalPrice() * config('qalzam.vat');
    }

    public function applyVat()
    {
        $this->total_price *= config('qalzam.vat');
    }

    /**
     * get total price Before VAT
     * @return float|int
     */
    public function totalPriceBeforeVat()
    {
        return $this->totalPrice() - $this->afterVat();
    }

    /**
     * get products ready to store new order
     */
    public function getProductsToBeOrdered()
    {
        $cart = $this->get();
        $products = array_map(function ($product){
            return array(
                'id' => (int)$product['id'],
                'quantity' => (int)$product['quantity'],
            );
        },$cart['products']);
        return collect($products)->toArray();
    }

    /**
     * Check product in the branch_products
     * @param Branch $branch
     * @param $product
     * @return bool
     */
    public function inBranch(Branch $branch,$product):bool
    {
        $branch = $product->branches()->where('branch_id', $branch->id)->first();
        if($branch)
            return true;
        return false;
    }

    /**
     * get single product from cart using product_id
     * @param $productId
     * @return mixed|null
     */
    public function getProduct($productId)
    {
        $cart = $this->get();
        $products = collect($cart['products']);
        $product = $products->first(function ($item) use ($productId){
            return $item->id = $productId;
        });
        return $product ?: null;
    }

    /**
     * @param ProductVariation $productId
     * @return int
     */
//    public function totalInStock(ProductVariation $product):int
//    {
//        return Stock::where('product_variation_id', $product->id)->count();
//    }

    /**
     * @param ProductVariation $product
     * @return bool
     */
//    public function hasNoStock(ProductVariation $product):bool
//    {
//        return dd($product->stock()->count()) ;
//    }
    /**
     * @param ProductVariation $product
     * @param $quantity
     * @throws \Exception
     */
//    public function availableInStock(ProductVariation $product,$quantity = 1)
//    {
//        if( $this->hasNoStock($product))
//            throw new \ErrorException('our Of Stocksa', 422);
////        throw new \Exception('Out Of Stock');
//        if($this->totalInStock($product) - $quantity <= 0 )
//            throw new \ErrorException('out Of Stock', 422);
////            throw new \Exception('Out Of Stock!');
//    }

    /**
     * get single product instance with pivot and branch where branch_id = branch in session
     * @param $product_id
     * @return ProductVariation
     */
    private function getProductInstance($product_id):ProductVariation
    {
        $branch = Branch::where('status', 'active')->with(['products' => function($q) {return $q->where('status', 'active');}])->find(BranchFacade::get()->id);
        return $branch->products->firstWhere('id',$product_id);
    }

    /**
     * set product Custom Data To be saved in the Cart Session
     * @param ProductVariation $product
     * @param $quantity
     */
    private function setProductCustomData(ProductVariation $product,$quantity)
    {
        $product->quantity = $product->qunatity + $quantity;

        $product->image = $product->getLastMediaUrl('product_variation-images');
        $product->type = 'cart';
        $product->product_variation_id  = $product->id;
        $product->branch_id = BranchFacade::get()->id;
    }
    /**
     * get array of ids to the cart products
     * @return array
     */
    private function productsIds():array
    {
        return array_column($this->get()['products'], 'id');
    }
}

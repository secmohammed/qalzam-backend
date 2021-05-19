<?php


namespace App\Common\Helpers;

use App\Common\Facades\Branch as BranchFacade;
use App\Domain\Product\Entities\ProductVariation ;
use \App\Common\Facades\Cart;
use App\Domain\Branch\Entities\Branch;

class Wishlist
{
    

    public function __construct()
    {
    
    }

    public function toggleWishlist(ProductVariation $product): void
    {
        // check Porduct in the same Session Branch
        if(! $this->inBranch(BranchFacade::get(),$product))
            return ;

        $wishlist = $this->get();
        $wishlistProductsIds = array_column($wishlist['products'], 'id');


        $product->image = $product->getLastMediaUrl('product_variation-images');
        $product->type = 'wishlist';
        $product->product_variation_id  = $product->id;
        $product->branch_id = BranchFacade::get()->id;
        // dd($product->id, $wishlistProductsIds);
        if (in_array($product->id, $wishlistProductsIds)) {
             $this->remove($product->id);
            return;
        }
        $this->add($product);
      
    }

    public function add(ProductVariation $product): void
    {
        $wishlist = $this->get();
        array_push($wishlist['products'], $product);
        $this->set($wishlist);
      
    }
    public function remove( $productId): void
    {
        $wishlist = $this->get();
        array_splice($wishlist['products'], array_search($productId, array_column($wishlist['products'], 'id')), 1);
        $this->set($wishlist);
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

    public function isFavorite($productId)
    {
        $wishlist = $this->get();

       if(array_search($productId, array_column($wishlist['products'], 'id')) !== false )
       return true;
       return false;
       
    }

    public function get()
    {
        return request()->session()->get('wishlist');
    }

    private function set($wishlist): void
    {
        request()->session()->put('wishlist', $wishlist);
    }

  



    public function inBranch(Branch $branch,$product):bool
    {
        $branch = $product->branches()->where('branch_id', $branch->id)->first();
        if($branch)
            return true;
        return false;
    }

 
}

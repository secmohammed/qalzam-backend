<?php


namespace App\Common\Helpers;

use App\Domain\Branch\Entities\Branch as BranchModel;
use App\Domain\Product\Entities\ProductVariation ;
use \App\Common\Facades\Cart;

class Branch
{

    public function setBranch(BranchModel $branch)
    {
        if($this->checkBranchIdentical($branch))
            $this->set($branch);
    }
    /**
     * @param BranchModel $branch
     * @return bool
     */
    public function checkBranchIdentical(BranchModel $branch):bool
    {
        $current_branch = $this->get();
        if($current_branch == null)
            return true;
        $cart = Cart::get();
        $products = $cart['products'];
        if(count($products) == 0)
            return true;
        return $current_branch->id == $branch->id;
    }

    /**
     * @param ProductVariation $product
     * @return bool
     */
    public function HasProduct(ProductVariation $product):bool
    {
        $branch = $this->get();
        $product = $branch->products()->where('Product_variation_id', $product)->first();
            if($product)
                return true;
        return false;
    }

    public function clear()
    {
        $this->set(null);
    }

    public function get()
    {
        return request()->session()->get('branch');
    }

    private function set(BranchModel $branch = null)
    {
        request()->session()->put('branch', $branch);
    }

    public function getBranchFromUrl()
    {
        $path = request()->path();
        $full_path =  explode('/', $path);
        $branch_id = end($full_path->last);
        return BranchModel::find($branch_id);
    }
}

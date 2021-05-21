<?php

namespace App\Http\Livewire\Profile;

use App\Common\Facades\Wishlist;
use Livewire\Component;

class MyWishlist extends Component
{

    public $products;
    protected $listeners = ['toggleWishlist'];

    public function render()
    {
        $this->getProducts();
        return view('livewire.profile.my_wishlists');
    }
    public function toggleWishlist($product)
    {
       Wishlist::toggleWishlist($product);
       $this->getProducts();
    }

    public function getProducts(Type $var = null)
    {
        $this->products = Wishlist::get()['products'];

    }
}

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
        return view('livewire.profile.my_wishlists');
    }
    public function toggleWishlist($product)
    
    {
        dd(1);
       Wishlist::toggleWishlist($product);
       $this->getProducts();
    }

    public function mount()
    {
        $this->getProducts();
    }
    public function getProducts(Type $var = null)
    {
        $this->products = Wishlist::get()['products']; 

    }
}

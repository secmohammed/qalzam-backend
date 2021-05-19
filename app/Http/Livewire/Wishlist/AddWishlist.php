<?php

namespace App\Http\Livewire\Wishlist;

use App\Common\Facades\Wishlist;
use Livewire\Component;

class AddWishlist extends Component
{
    protected $listeners = ['toggleWishlist'];

    public $product;    
    public $isFavorite;

    public function render()
    {
        return view('livewire.wishlist.add');
    }
    public function toggleWishlist()
    {
       Wishlist::toggleWishlist($this->product);
       $this->setIsFavorite();
    }
    public function mount()
    {
        $this->setIsFavorite();
    }
    protected function setIsFavorite()
    {
        $this->isFavorite = Wishlist::isFavorite($this->product->id);
        // dd($this->isFavorite);
    }
}

<?php

namespace App\Http\Livewire\Wishlist;

use App\Common\Facades\Wishlist;
use Livewire\Component;

class AddWishlist extends Component
{
    protected $listeners = ['toggleWishlist', 'setIsFavorite' => 'setIsFavorite'];

    public $product;
    public $isFavorite;

    public function render()
    {
        return view('livewire.wishlist.add');
    }
    public function toggleWishlist()
    {
        $toggle_wish_list = Wishlist::toggleWishlist($this->product);
        if($toggle_wish_list)
            $this->emit('toaster', "$toggle_wish_list from wishlist", 'success');
       $this->setIsFavorite();
    }

    public function mount()
    {
        $this->setIsFavorite();
    }

    public function setIsFavorite()
    {
        $this->isFavorite = Wishlist::isFavorite($this->product->id);
    }
}

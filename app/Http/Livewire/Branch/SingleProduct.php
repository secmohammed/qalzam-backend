<?php

namespace App\Http\Livewire\Branch;

use Livewire\Component;

class SingleProduct extends Component
{
    public $product;
    public $action;
    public function render()
    {
        return view('livewire.branch.single-product');
    }
}

<?php

namespace App\Http\Livewire\Card;

use Livewire\Component;

class HorizontalCard extends Component
{
    public $product;
    public function render()
    {
        return view('livewire.card.horizontal-card');
    }
}

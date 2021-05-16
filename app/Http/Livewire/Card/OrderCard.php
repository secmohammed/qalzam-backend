<?php

namespace App\Http\Livewire\Card;

use Livewire\Component;

class OrderCard extends Component
{

    public $branchName;
    public $createdAt;
    public $status;
    public $price;
    public function mount($price)
    {
        $this->price = $price;
    }
    public function render()
    {
        return view('livewire.card.order-card');
    }
}

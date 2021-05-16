<?php

namespace App\Http\Livewire\Card;

use Livewire\Component;

class AddressCard extends Component
{
    public $city;
    public $district;
    public $fullAddress;

    public function render()
    {
        return view('livewire.card.address-card');
    }
}

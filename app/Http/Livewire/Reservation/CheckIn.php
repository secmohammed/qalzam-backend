<?php

namespace App\Http\Livewire\Reservation;

use App\Common\Facades\Wishlist;
use Livewire\Component;

class CheckIn extends Component
{
    public $reservation;

    public function render()
    {
        return view('livewire.reservations.check_in');
    }
 
}

<?php

namespace App\Http\Livewire\Reservation;

use App\Common\Facades\Wishlist;
use App\Domain\Reservation\Entities\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class CheckInOut extends Component
{
    protected $listeners = ['deleteReservation'];

    public $reservations;


    public function render()
    {
        return view('livewire.reservations.check_ins');
    }
     public function mount()
    {
        $this->reservations = Reservation::whereDate('start_date',Carbon::today())->with(['accommodation','branch','user'])->where('status','upcoming')->get();
    }
     public function deleteReservation($item)
    {
        Reservation::find($item['id'])->update(['status'=>'done']);
       $this->reservations = $this->reservations->filter(function ($reservation) use ($item)
       {
           return $reservation->id !== $item['id'];
       });
    }
 
}

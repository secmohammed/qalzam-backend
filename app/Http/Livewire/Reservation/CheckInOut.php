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
        $this->reservations = Reservation::whereDate('start_date','>',Carbon::now()->format('Y-m-d H:i:s'))->with(['accommodation','branch','user'])->where('status','upcoming')->get();
        // dd($this->reservations);
    }
     public function deleteReservation($item)
    {
        // dd($item);
        Reservation::find($item['id'])->update(['status'=>'done']);
       $this->reservations = $this->reservations->filter(function ($reservation) use ($item)
       {
           return $reservation->id !== $item['id'];
       });
    }
 
}

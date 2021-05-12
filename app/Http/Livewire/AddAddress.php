<?php

namespace App\Http\Livewire;

use App\Domain\Location\Entities\Location;
use Livewire\Component;

class AddAddress extends Component
{
    public $cities;
    public $chosenCity;
    public $districts;
    public function mount(Location $location)
    {
        $this->cities = $location->where('type','city')->get();
        $this->districts = [];
    }

    public function render()
    {
        return view('livewire.add-address');
    }
    public function change(Location $location)
    {
        $this->districts = $location->where(['parent_id' => $this->chosenCity,'type'=>'district'])->get();
    }
}

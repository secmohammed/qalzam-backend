<?php

namespace App\Http\Livewire;

use App\Domain\Location\Entities\Location;
use App\Domain\User\Repositories\Contracts\AddressRepository;
use Livewire\Component;

class AddAddress extends Component
{
    public $cities;
    public $chosenCity;
    public $districts;
    public $name;
    public $landmark;
    public $location_id;
    public $postal_code;
    protected $rules = [
        'name' => 'required',
        'landmark' => 'required',
        'location_id' => 'required|exists:locations,id',
        'postal_code' => 'required',
    ];
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

    public function saveAddress(AddressRepository $addressRepository)
    {
        $this->validate();
        $location = Location::with('parent')->find($this->location_id);
        $parent_location = $location->parent;
        $address_1 = "$this->landmark, $this->name, $location->name, $parent_location->name";
        $default = 1;
        $address = $addressRepository->create([
            'name' => $this->name,
            'landmark' => $this->landmark,
            'postal_code' => $this->postal_code,
            'location_id' =>$this->location_id,
            'address_1' => $address_1,
            'user_id' => auth()->id(),
            'default' => $default,
        ]);
        $this->redirect(route(previousRouteName()));
    }
}

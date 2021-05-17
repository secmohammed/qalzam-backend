<?php

namespace App\Http\Livewire;

use App\Domain\Location\Entities\Location;
use App\Domain\User\Repositories\Contracts\AddressRepository;
use Livewire\Component;

class EditAdress extends Component
{
    public $addressId;
    public $cities;
    public $chosenCity;
    public $districts;
    public $name;
    public $landmark;
    public $city_id;
    public $district_id;
    public $location_id;
    public $postal_code;
    protected $listeners = ['editAddressStart' => 'getAddressData'];
    protected $rules = [
        'name' => 'required',
        'landmark' => 'required',
        'location_id' => 'required|exists:locations,id',
        'postal_code' => 'required',
    ];
    public function render()
    {
        return view('livewire.edit-adress');
    }
    public function mount(Location $location)
    {
        $this->cities = $location->where('type','city')->get();
        $this->districts = [];
    }
    public function change(Location $location)
    {
        $this->districts = $location->where(['parent_id' => $this->chosenCity,'type'=>'district'])->get();
    }

    public function getAddressData(AddressRepository $addressRepository,$id)
    {
        $address = $addressRepository->with('location.parent')->find($id);
        $this->name = $address->name;
        $this->landmark = $address->landmark;
        $this->location_id = $address->location_id;
        $this->city_id = $address->location->parent->id;
        $this->district_id = $address->location_id;
        $this->postal_code = $address->postal_code;
        $this->addressId = $address->id;
    }
    public function updateAddress(AddressRepository $addressRepository,$address_id)
    {
        $this->validate();
        $address_1 = "$this->landmark, $this->name";
        $default = 1;
        $address = $addressRepository->update([
            'name' => $this->name,
            'landmark' => $this->landmark,
            'postal_code' => $this->postal_code,
            'location_id' =>$this->location_id,
            'address_1' => $address_1,
            'user_id' => auth()->id(),
            'default' => $default,
        ],$address_id);
        $this->redirect(route(previousRouteName()));
    }
}

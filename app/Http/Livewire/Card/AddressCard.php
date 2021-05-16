<?php

namespace App\Http\Livewire\Card;

use App\Domain\User\Repositories\Contracts\AddressRepository;
use Livewire\Component;

class AddressCard extends Component
{
    public $city;
    public $district;
    public $fullAddress;
    public $addressId;

    public function render()
    {
        return view('livewire.card.address-card');
    }

    public function editAddressForm($id)
    {
        $this->emit('editAddressStart', $id);
    }

    public function deleteAddress(AddressRepository $addressRepository, $id)
    {
        $addressRepository->delete($id);
        $this->redirect(route(previousRouteName()));
    }
}

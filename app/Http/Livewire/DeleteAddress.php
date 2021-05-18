<?php

namespace App\Http\Livewire;

use App\Domain\User\Repositories\Contracts\AddressRepository;
use Livewire\Component;

class DeleteAddress extends Component
{
    public $address_id ;
    protected $listeners = ['deleteAddressConfirmation'];
    public function mount()
    {
        $this->address_id = 0;
    }
    public function render()
    {
        return view('livewire.delete-address');
    }

    public function deleteAddressConfirmation($id)
    {
        $this->address_id = $id;
    }

    public function deleteAddress(AddressRepository $addressRepository, $id)
    {
        $addressRepository->delete($id);
        $this->redirect(route(previousRouteName()));
    }
}

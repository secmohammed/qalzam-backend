<?php

namespace App\Http\Livewire\Profile;

use App\Domain\User\Repositories\Contracts\AddressRepository;
use Livewire\Component;

class Addresses extends Component
{
    public $addresses;
    public $isBack = false;
    public function mount()
    {
        if(!$this->isBack)
        {
            $this->addresses = app(AddressRepository::class)->where("user_id",auth()->id())->with('location.parent')->get();
        }
    }
    public function render()
    {
        return view('livewire.profile.addresses');
    }
}

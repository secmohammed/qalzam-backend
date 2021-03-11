<?php

namespace App\Http\Livewire;

use App\Domain\Branch\Entities\Branch;
use App\Domain\User\Entities\Address;
use App\Domain\User\Entities\User;
use Livewire\Component;

class step1 extends Component
{
    public $state = [];
    protected $listeners = [
        "submit",
    ];

    protected $rule = [
        'state.branch_id' => 'required',
        'state.user_id' => 'required',
        'state.address_id' => 'required',
    ];
    protected $messages = [
        "state.branch_id.required" => 'the branch is required',
        "state.user_id.required" => 'the user is required',
        "state.address_id.required" => 'the address is required',
    ];
    public function submit()
    {
        $this->validate();
        $this->emit("mergeState", $this->state);
        $this->emit('goToStep', 2);
    }

    public function render()
    {
        $users = User::all();
        $addresses = Address::all();
        $branches = Branch::all();
        return view('orders::order.form.step1', ["action" => "create", "users" => $users, "addresses" => $addresses, "branches" => $branches]);
    }

}

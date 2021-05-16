<?php

namespace App\Http\Livewire\Profile;

use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\User\Entities\User;
use App\Domain\User\Http\Controllers\UserController;
use Livewire\Component;

class MyOrders extends Component
{

    public $orders;

    public function render()
    {
        return view('livewire.profile.my_orders');
    }

    public function mount()
    {
        $this->orders = app(OrderRepository::class)->where("user_id",auth()->id())->with('branch',"address")->get();
    }
}

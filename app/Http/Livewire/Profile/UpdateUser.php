<?php

namespace App\Http\Livewire\Profile;

use App\Domain\User\Entities\User;
use App\Domain\User\Http\Controllers\UserController;
use Livewire\Component;

class UpdateUser extends Component
{

    public $name;
    public $email;
    public $mobile;
    public function render()
    {
        return view('livewire.profile.update_user');
    }
    public function submit()
    {
        request()->merge(request("serverMemo")['data']);
        request()->merge(['user'=>auth()->user()]);
            // dd(request()->all());
            // dd(auth()->user());
        app()->call(UserController::class . '@update', [
            'user' => auth()->user(),
        ]);
        // app(UserController::class)->update(request()->all(),auth()->user());
        // Execution doesn't reach here if validation fails.

    }
    public function mount()
    {
        $this->email = auth()->user()->email;
        $this->mobile = auth()->user()->mobile;
        $this->name = auth()->user()->name;
    }
}

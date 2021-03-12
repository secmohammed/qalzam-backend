<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OrderProduct extends Component
{

    public $step = 1;
    public $state = [];
    protected $listeners = [
        "goToStep",
        "mergeState",
    ];

    public function removeProduct(int $i)
    {
        unset($this->products[$i]);

        $this->products = array_values($this->products);
    }
    public function goToStep($value)
    {

        $this->step = $value;
    }
    public function mergeState($state)
    {
        $this->state = array_merge($this->state, $state);
    }

    public function render()
    {

        return view('orders::order.form.steps', ['action' => 'create']);
    }

}

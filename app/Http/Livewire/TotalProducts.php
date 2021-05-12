<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TotalProducts extends Component
{
    public $totalCount;
    protected $listeners = ['totalCount'];
    public function render()
    {
        return view('livewire.total-products');
    }
    public function totalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }
}

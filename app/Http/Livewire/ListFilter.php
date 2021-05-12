<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListFilter extends Component
{
    public $filters;
    public $filterBy;
    public function render()
    {
        $model = ucfirst($this->filterBy);
        return view('livewire.list-filter');
    }
}

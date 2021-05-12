<?php

namespace App\Http\Livewire\Filter;

use Livewire\Component;

class ClearFilter extends Component
{
    public function render()
    {
        return view('livewire.filter.clear-filter');
    }

    public function clearFilter()
    {
        $this->emit('clearFilter');
    }
}

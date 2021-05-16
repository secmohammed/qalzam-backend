<?php

namespace App\Http\Livewire;

use App\Domain\Category\Entities\Category;
use Livewire\Component;

class SingleListFilter extends Component
{
    public $filter;
    public $activeClass;
    public function render()
    {
        return view('livewire.single-list-filter');
    }

    public function filterQuery(Category $filter)
    {
        $this->emit('productsWithCategory' ,$filter->id);
    }

    public function clearFilter()
    {
        $this->emit('clearFilter');
    }
}

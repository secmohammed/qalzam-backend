<?php

namespace App\Http\Livewire\Filter;

use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use Livewire\Component;

class ProductsFilter extends Component
{
    public $filters;
    public function mount(CategoryRepository $categoryRepository)
    {
        $this->filters = $categoryRepository->findWhere(['type' => 'products']);
    }

    public function render()
    {
        return view('livewire.filter.products-filter');
    }
}

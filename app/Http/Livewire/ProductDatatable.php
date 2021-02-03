<?php

namespace App\Http\Livewire;

use App\Domain\Product\Entities\Product;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProductDatatable extends MainLivewire
{
    public function builder()
    {
        return Product::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('products.id')->label(__('main.select_all')),

            NumberColumn::name('products.id')
                ->label(__('main.id')),

            Column::name('products.name')
                ->label(__('main.name'))
                ->filterable('name'),

            DateColumn::name('products.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['products.id'], function ($id) {

                return view("products::product.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

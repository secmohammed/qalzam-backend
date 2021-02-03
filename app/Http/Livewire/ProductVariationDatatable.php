<?php

namespace App\Http\Livewire;

use Mediconesystems\LivewireDatatables\Column;
use App\Domain\Product\Entities\ProductVariation;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProductVariationDatatable extends MainLivewire
{
    public function builder()
    {
        return ProductVariation::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('product_variations.id')->label(__('main.select_all')),

            NumberColumn::name('product_variations.id')
                ->label(__('main.id')),

            Column::name('product_variations.name')
                ->label(__('main.name'))
                ->filterable('name'),

            DateColumn::name('product_variations.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['product_variations.id'], function ($id) {

                return view("products::productvariation.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

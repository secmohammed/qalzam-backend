<?php

namespace App\Http\Livewire;

use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use App\Domain\Product\Entities\ProductVariationType;

class ProductVariationTypeDatatable extends MainLivewire
{
    public function builder()
    {
        return ProductVariationType::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('product_variation_types.id')->label(__('main.select_all')),

            NumberColumn::name('product_variation_types.id')
                ->label(__('main.id')),

            Column::name('product_variation_types.name')
                ->label(__('main.name'))
                ->filterable('name'),

            DateColumn::name('product_variation_types.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['product_variation_types.id'], function ($id) {

                return view("products::productvariationtype.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

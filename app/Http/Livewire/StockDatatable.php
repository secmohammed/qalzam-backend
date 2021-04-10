<?php

namespace App\Http\Livewire;

use App\Domain\Product\Entities\Stock;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class StockDatatable extends MainLivewire
{
    public function builder()
    {
        return Stock::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('stocks.id')->label(__('main.select_all')),

            NumberColumn::name('stocks.id')
                ->label(__('main.id')),

            Column::name('stocks.quantity')
                ->label(__('main.quantity'))
                ->filterable('name'),
            Column::name('variation.name')
                ->label(__('main.product_variations'))
                ->filterable('name'),
            Column::name('variation.product.name')
                ->label(__('main.products'))
                ->filterable('name'),
            // Column::name('stocks.quantity')
            //     ->label(__('main.quantity'))
            //     ->filterable('name'),

            DateColumn::name('stocks.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['stocks.id'], function ($id) {

                return view("products::stock.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

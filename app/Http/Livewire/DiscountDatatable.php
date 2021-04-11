<?php

namespace App\Http\Livewire;

use App\Domain\Discount\Entities\Discount;
use App\Http\Livewire\MainLivewire;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class DiscountDatatable extends MainLivewire
{
    public function builder()
    {
        return Discount::query()->with('category');
    }

    public function columns()
    {

        return [
            NumberColumn::name('discounts.id')
                ->label('ID')
                ->linkTo('job', 6),

            Column::name('discounts.code')
                ->defaultSort('asc')
                ->filterable(),
            // Column::name('category.name')
            //     ->label(__('main.category'))
            //     ->defaultSort('asc')
            //     ->filterable('cateogry.name'),

            DateColumn::name('discounts.created_at')
                ->label('created at')
                ->filterable(),
            DateColumn::name('discounts.expires_at')
                ->label('expires at')
                ->filterable(),

            DateColumn::name('discounts.updated_at')
                ->label('updated at')
                ->filterable(),
            Column::callback(['discounts.id'], function ($id) {
                return view("discounts::discount.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),

        ];
    }
}

<?php

namespace App\Http\Livewire;

use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use App\Domain\Accommodation\Entities\Accommodation;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AccommodationDatatable extends MainLivewire
{
    public function builder()
    {
        return Accommodation::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('accommodations.id')->label(__('main.select_all')),

            NumberColumn::name('accommodations.id')
                ->label(__('main.id')),
            Column::name('accommodations.name')
                ->label(__('main.name'))->filterable('accommodations.name'),
            Column::name('branch.name')
                ->label(__('main.branch'))
                ->filterable(),

            DateColumn::name('accommodations.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['accommodations.id'], function ($id) {
                return view("accommodations::accommodation.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

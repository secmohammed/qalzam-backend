<?php

namespace App\Http\Livewire;

use App\Domain\Accommodation\Entities\Accommodation;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
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
                ->label(__('main.room_table'))->filterable('accommodations.name'),
            Column::name('accommodations.code')
                ->label(__('main.code'))->filterable('accommodations.code'),
            Column::name('accommodations.capacity')
                ->label(__('main.capacity'))->filterable('accommodations.capacity'),
            Column::name('contract.name')
                ->label(__('main.contract'))->filterable('contract.name'),
            // Column::name('accommodations.name')
            //     ->label(__('main.room_table'))->filterable('accommodations.name'),
            // Column::name('accommodations.status')
            //     ->label(__('main.status'))
            //     ->filterable([
            //         'active' => __('main.active'),
            //         'inactive' => __('main.inactive'),
            //     ]),

            Column::name('branch.name')
                ->label(__('main.branch'))
                ->filterable('branch.name'),
            Column::name('categories.name')
                ->label(__('main.branch'))
                ->filterable('branch.name'),

            DateColumn::name('accommodations.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['accommodations.id'], function ($id) {
                return view("accommodations::accommodation.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

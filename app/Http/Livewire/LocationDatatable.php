<?php

namespace App\Http\Livewire;

use App\Domain\Location\Entities\Location;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class LocationDatatable extends MainLivewire
{
    public function builder()
    {
        return Location::query()->leftJoin('locations as locationParent', 'locationParent.id', 'locations.parent_id');
    }

    public function columns()
    {
        return [
            Column::checkbox()->label(__('main.select_all')),

            NumberColumn::name('locations.id')
                ->label(__('main.id')),

            Column::name('locations.name')
                ->label(__('main.name'))
                ->filterable('name'),

            Column::name('locationParent.name')
                ->filterable('locationParent.name')
                ->label(__('main.parent')),

            Column::name('locations.type')
                ->label(__('main.type'))
                ->filterable([
                    'country' => __('main.country'),
                    'city' => __('main.city'),
                    'district' => __('main.district'),
                    'zone' => __('main.zone'),
                ]),

            DateColumn::name('locations.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['locations.id'], function ($id) {
                return view("locations::location.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

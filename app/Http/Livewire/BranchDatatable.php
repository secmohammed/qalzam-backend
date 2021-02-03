<?php

namespace App\Http\Livewire;

use App\Domain\Branch\Entities\Branch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class BranchDatatable extends MainLivewire
{
    public function builder()
    {
        return Branch::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('branches.id')->label(__('main.select_all')),

            NumberColumn::name('branches.id')
                ->label(__('main.id')),
            Column::name('branches.name')
                ->label(__('main.name'))->filterable('branches.name'),
            Column::name('branches.longitude')
                ->label(__('main.longitude'))->filterable('branches.longitude'),
            Column::name('branches.latitude')
                ->label(__('main.latitude'))->filterable('branches.latitude'),
            Column::name('location.name')
                ->label(__('main.location'))
                ->filterable(),

            DateColumn::name('branches.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['branches.id'], function ($id) {
                return view("branches::branch.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

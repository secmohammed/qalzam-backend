<?php

namespace App\Http\Livewire;

use App\Domain\Accommodation\Entities\Contract;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ContractDatatable extends MainLivewire
{
    public function builder()
    {
        return Contract::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('contracts.id')->label(__('main.select_all')),

            NumberColumn::name('contracts.id')
                ->label(__('main.id')),
            Column::name('contracts.name')
                ->label(__('main.name'))->filterable('contracts.name'),
            Column::name('template.name')
                ->label(__('main.template'))
                ->filterable(),
            Column::name('user.name')
                ->label(__('main.user'))
                ->filterable(),
            Column::name('contracts.status')
                ->label(__('main.status'))
                ->filterable(),

            DateColumn::name('contracts.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['contracts.id'], function ($id) {
                return view("accommodations::contract.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

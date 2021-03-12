<?php

namespace App\Http\Livewire;

use App\Domain\Branch\Entities\BranchShift;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class BranchShiftDatatable extends MainLivewire
{
    public function builder()
    {
        return BranchShift::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('branch_shifts.id')->label(__('main.select_all')),

            NumberColumn::name('branch_shifts.id')
                ->label(__('main.id')),
            Column::name('branch_shifts.day')
                ->label(__('main.day'))->filterable('branch_shifts.day'),
            Column::name('branch_shifts.status')
                ->label(__('main.status'))->filterable('branch_shifts.status'),

            DateColumn::name('branch_shifts.end_time')
                ->label('main.end_time')
                ->filterable(),
            Column::callback(['branch_shifts.id'], function ($id) {
                return view("branches::branchshift.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

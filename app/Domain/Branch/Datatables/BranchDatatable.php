<?php

namespace App\Domain\Branch\Datatables;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Domain\Branch\Entities\Branch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class BranchDatatable extends LivewireDatatable
{
    public function builder()
    {
        return Branch::query();
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->linkTo('job', 6),

            Column::name('name')
                ->defaultSort('asc')
                ->searchable()
                ->filterable(),

            DateColumn::name('created_at')
                ->label('created at')
                ->filterable(),

            DateColumn::name('updated_at')
                ->label('updated at')
                ->filterable(),
        ];
    }
}
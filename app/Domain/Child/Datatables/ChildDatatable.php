<?php

namespace App\Domain\Child\Datatables;

use App\Domain\Child\Entities\Child;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ChildDatatable extends LivewireDatatable
{
    public function builder()
    {
        return Child::query();
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

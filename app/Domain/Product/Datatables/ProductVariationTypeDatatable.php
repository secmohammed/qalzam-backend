<?php

namespace App\Domain\Product\Datatables;

use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use App\Domain\Product\Entities\ProductVariationType;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProductVariationTypeDatatable extends LivewireDatatable
{
    public function builder()
    {
        return ProductVariationType::query();
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

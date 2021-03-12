<?php

namespace App\Http\Livewire;

use App\Domain\Product\Entities\Template;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class TemplateDatatable extends MainLivewire
{
    public function builder()
    {
        // dd(Template::query()->get());
        return Template::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('templates.id')->label(__('main.select_all')),

            NumberColumn::name('templates.id')
                ->label(__('main.id')),
            Column::name('templates.name')
                ->label(__('main.name'))
                ->filterable('name'),

            Column::name('templates.status')
                ->label(__('main.status'))
                ->filterable('status'),

            DateColumn::name('templates.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['templates.id'], function ($id) {

                return view("products::template.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

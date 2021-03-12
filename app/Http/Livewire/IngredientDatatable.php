<?php

namespace App\Http\Livewire;

use App\Domain\Ingredient\Entities\Ingredient;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class IngredientDatatable extends MainLivewire
{
    public function builder()
    {
        return Ingredient::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('ingredients.id')->label(__('main.select_all')),

            NumberColumn::name('ingredients.id')
                ->label(__('main.id')),
            Column::name('ingredients.name')
                ->label(__('main.name'))->filterable('ingredients.name'),

            Column::name('ingredients.status')
                ->label(__('main.status'))
                ->filterable(),

            DateColumn::name('ingredients.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['ingredients.id'], function ($id) {
                return view("ingredients::ingredient.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

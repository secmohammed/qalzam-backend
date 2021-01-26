<?php

namespace App\Http\Livewire;

use App\Domain\Category\Entities\Category;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CategoryDatatable extends MainLivewire
{
    public function builder()
    {
        return Category::query()->leftJoin('categories as categoryParent', 'categoryParent.id', 'categories.parent_id');
    }

    public function columns()
    {
        return [
            Column::checkbox('categories.id')->label(__('main.select_all')),

            NumberColumn::name('categories.id')
                ->label(__('main.id')),
            Column::name('categoryParent.name')
                ->filterable('categoryParent.name')
                ->label(__('main.parent')),
            Column::name('categories.name')
                ->label(__('main.name'))->filterable('catories.name'),
            Column::name('categories.type')
                ->label(__('main.type'))
                ->filterable([
                    'product' => __('main.product'),
                    'post' => __('main.post'),
                ]),

            DateColumn::name('categories.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['categories.id'], function ($id) {
                return view("categories::category.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}
